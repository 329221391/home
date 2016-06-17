<?php
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
<link href="css/css_white.css" rel="stylesheet" type="text/css">
<title>我的收藏</title>
<script type="text/javascript" src="js/myscroll.js"></script>
<head>
</head>
<body style="background:#CCCCCC;">
<div class="z_title">我的收藏</div>
<div id="ms_top"><a href="javascript:history.go(-1);" onclick="topadd();" target="_self"><img class="f_sy"
                                                                                              src="images/back_0.png"></a>
</div>
<div class="top_60"></div>
<div class="pagetop" id="pagetop" style="text-align:center;background:#fff;"><img onClick="pageup()"
                                                                                  src="images/top.png"></div>
<?php foreach ($fav as $k => $v) {
    ++$record_num;
    ?>
    <div class="mystore_m top_5">
        <div class="detail_title"><span class="title_sj"><?= SiteCom::getArticleType($v->cat_default_id) ?></span><span
                class="title_sj_time"><?= \app\modules\AppBase\base\CommonFun::getsubdate($v->createtime) ?></span>
        </div>
        <div class="detail_colume top_5">
            <div class="colume_img"><img src="<?= SiteCom::getImgUrl($v->url) ?>"></div>
            <div class="colume_col"><?= $v->desc ?></div>
        </div>
    </div>
<?php } ?>
<div class="pagebottom" id="pagebottom"><img onClick="pagedown()" src="images/bottom.png"></div>
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
            window.location.href = "index.php?r=phone/mystore&page=" + page;
        }
        else {
            $('#pagebottom').hide();
        }
    }
</script>