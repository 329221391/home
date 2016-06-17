<?php
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
<title>回复</title>
<script language="javascript"> function op(c_url) {
        window.open(c_url)
    }</script>
<head></head>
<body>
<div class="z_title">回复</div>
<div id="ms_top"><a href="javascript:history.go(-1);" target="_self"><img class="f_sy"
                                                                                          src="images/back_0.png"></a>
</div>
<div class="top_60"></div>
<?php foreach ($art_reply as $k => $v) {
    ?>
    <div class="reply_detail">
        <div class="top_img"><img src="<?= SiteCom::getRoleImg($v->repliers_role_id) ?>"></div>
        <div class="reply_title"><?= $v->repliers_name ?>的回复<br><span class="reply_grey"><?= $v->createtime ?></span>
        </div>
        <div class="reply_img"><img id="reply_b" name="<?= $v->repliers_id . ',' . $v->id ?>"
                                    src="images/ysq_hf.png">
        </div>
        <div class="reply_con"><?= $v->contents ?></div>
        <br style="clear:both;">
        <?php
        foreach ($v->reply_list as $kk => $vv) {
            ?>
            <div class="reply_detail">
                <div class="top_img"><img src="<?= SiteCom::getRoleImg($vv->repliers_role_id) ?>"></div>
                <div class="reply_title"><?= $vv->repliers_name ?>的回复<br><span
                        class="reply_grey"><?= $vv->createtime ?></span></div>
                <div class="reply_img"><img id="reply_b" name="<?= $v->repliers_id . ',' . $v->id ?>"
                                            src="images/ysq_hf.png"></div>
                <div class="reply_con"><?= $vv->contents ?></div>
                <br style="clear:both;">
            </div>
        <?php
        } ?>
    </div>
<?php } ?>
<div class="bottom_25"></div>
<div class="reply"><input id="contents" type="text" class="reply_text"
                          style="color:normal;color=#000000;  line-height:normal; background:#26cacb; margin-top:8px;">
    <input id="submit" value="回复" class="reply_buttom"
           style="color:normal;color=#000000;  line-height:normal;background:#336699; text-alain:center: width=20px; padding-left:8px;margin-top:8px;"></div>
<div><input id="tmp" hidden="true" value=""></div>
>
</body>
</html>
<script language="javascript">
    $("[id=reply_b]").each(function () {
        $(this).click(function () {
            $("#tmp").val($(this).attr('name'));
            $("#contents").focus();
        });
    });
    $("#submit").click(function () {
        var contents = $("#contents").val();
        contents = $.trim(contents);
        var article_id = "<?= $article_id ?>";
        if (contents == '') {
            alert("请输入回复内容");
        }
        else {
            if ($("#tmp").val() != "") {
                var a = $("#tmp").val().split(',');
                $.post('index.php?r=Articles/articles/reply-reply', {
                    reply_id: a[0],
                    id: a[1],
                    article_id: article_id,
                    content: contents
                }, function (result) {
                    if (result['ErrCode'] == "0") {
                        alert('回复成功');
                        window.location.href = 'index.php?r=phone/reply&id=' + article_id;
                    } else {
                        alert(result['Message']);
                    }
                }, "json");
            } else {
                $.post('index.php?r=Articles/articles/article-reply', {
                    article_id: article_id,
                    content: contents
                }, function (result) {
                    if (result['ErrCode'] == "0") {
                        alert('回复成功');
                        window.location.href = 'index.php?r=phone/reply&id=' + article_id;
                    } else {
                        alert(result['Message']);
                    }
                }, "json");
            }
        }
    });
</script>
