<?php
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\SiteCom;

?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content=" initial-scale=1.0,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<link href="css/css_white.css" rel="stylesheet" type="text/css">
<title>园长</title>
<head>
</head>
<body style="background:#eeeeee;">
<div class="z_title"><?= $name ?></div>
<div id="ms_top"><a href="javascript:history.go(-1);" target="_self"><img class="f_sy"
                                                                          src="images/back_0.png"></a>
</div>
<div class="top_60"></div>
<?php foreach ($msg as $k => $v) {
    if ($v['sender_id'] != $myid) {
        ?>

        <div class="school">
            <div class="school_left"><img src="<?= SiteCom::getRoleImg($cat_default_id) ?>"></div>
            <div class="school_right">
                <div class="time"><?= CommonFun::getsubdate($v['createtime']) ?></div>
                <div class="word"><?= $v['contents'] ?></div>
            </div>
            <br style="clear:both;">
        </div>
    <?php } else { ?>
        <div class="home">
            <div class="home_right"><img src="<?= SiteCom::getRoleImg(HintConst::$ROLE_PARENT) ?>"></div>
            <div class="home_left">
                <div class="time"><?= CommonFun::getsubdate($v['createtime']) ?></div>
                <div class="word1"><?= $v['contents'] ?></div>
            </div>
            <br style="clear:both;">
        </div>

    <?php
    }
} ?>
<div class="bottom_140"></div>
<div class="x_bottom_all" style="background:#FFFFFF;">
    <div class="cs"><input id="contents" class="amail_inptu" style=" color:#000" value="在这里输入内容" type="text"
                           onFocus="if (value =='在这里输入内容'){value =''}" onBlur="if (value ==''){value='在这里输入内容'}">
        <input id="submit" type="button" value="发送"
               style=" background:#FFFFFF;border-radius:5px; color:#00a3a3; border:2px solid #00a3a3; height:2.8rem;  margin-left:5px; font-size:1.0rem;">
        <a href="#" style="margin-left:2px;"></a></div>
</div>
</body>
</html>
<script language="javascript">
    $("#submit").click(function () {
        var contents = $("#contents").val();
        contents = $.trim(contents);
        if (contents == '') {
            alert("请输入回复内容");
        }
        else {
            $.post('index.php?r=Message/messages/sendmsg', {
                reciever_id: "<?= $another_id ?>",
                contents: contents
            }, function (result) {
                if (result['ErrCode'] == "0") {
                    window.location.href = "index.php?r=phone/amail_con&id=<?=$myid?>&another_id=<?=$another_id?>&cat_default_id=<?=$cat_default_id?>&name=<?=$name?>";
                } else {
                    alert(result['Message']);
                }
            }, "json");
        }
    });
</script>