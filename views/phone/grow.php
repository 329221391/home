<?php
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\SiteCom;

$record_num = 0;
?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content=" initial-scale=1.0,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<link href="css/common.css" rel="stylesheet" type="text/css"/>
<link href="css/css_white.css" rel="stylesheet" type="text/css"/>
<title>成长历程</title>
<script type="text/javascript" src="js/myscroll.js"></script>
<head>
</head>
<body>
<div class="z_title">成长历程</div>
<div id="ms_top"><!--<a href="exit.html" target="_self"><img class="f_sy" src="images/info_0.png"></a>-->
</div>
<div class="top_60"></div>
<div class="pagetop" id="pagetop" style="text-align:center;"><img onClick="pageup()" src="images/top.png"></div>
<?php foreach ($grow as $k => $v) {
    ++$record_num;
    ?>
    <div id="grow_yz">
        <div class="grow_left">
            <img src="<?= SiteCom::getIcon($v->article_type_id) ?>"><br>
            <?= $v->author_name ?><br> <?= CommonFun::getsubdate($v->date) ?>
        </div>
        <div class="grow_right">
            <div class="grow_right_bg">
                <a href=<?php echo SiteCom::$phone_url . "growdetail&id=" . $v->id ?>><img class="grow_imgadd"
                                                                                           src="<?= SiteCom::getImgUrl($v->thumb) ?>"/><?= CommonFun::getsubstr($v->title) ?>
                </a><br style="clear:both;">
            </div>
        </div>
        <br style="clear:both;">
    </div>
<?php } ?>
<?php include("fourbottom.php") ?>
<div class="pagebottom" style="bottom:120px;" id="pagebottom"><img onClick="pagedown()" src="images/bottom.png"></div>
</body>
</html>
<script type="text/javascript">
    var page = "<?= $page?>";
    function pageup() {
        if (page > 1) {
            history.go(-1);
        } else {
            $('#pagetop').hide();
        }
    }
    function pagedown() {
        var record_num = "<?=$record_num ?>";
        if (record_num == "10") {
            page++;
            window.location.href = "index.php?r=phone/grow&page=" + page;
        }
        else {
            $('#pagebottom').hide();
        }
    }
</script>