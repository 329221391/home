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
<link href="css/css_white.css" rel="stylesheet" type="text/css">
<title>园所圈</title>
<script type="text/javascript" src="js/myscroll.js"></script>
<script type="text/javascript">
    function newon() {
        document.getElementById("ysq_title_left").style.backgroundColor = "#28cacc";
        document.getElementById("ysq_title_left").style.color = "#fff";
        document.getElementById("ysq_title_right").style.backgroundColor = "#88e2e2";
        document.getElementById("ysq_title_right").style.color = "#28cacc";
        document.getElementById("top_new").style.display = "inline";
        document.getElementById("aboutme").style.display = "none";
    }
    function aboutmeon() {
        document.getElementById("ysq_title_right").style.backgroundColor = "#28cacc";
        document.getElementById("ysq_title_right").style.color = "#fff";
        document.getElementById("ysq_title_left").style.backgroundColor = "#88e2e2";
        document.getElementById("ysq_title_left").style.color = "#28cacc";
        document.getElementById("top_new").style.display = "none";
        document.getElementById("aboutme").style.display = "inline";
    }
</script>
<head>
</head>
<body style="background:#E6E6E6">
<div class="z_title">园所圈</div>
<div id="ms_top"><a href=<?php echo SiteCom::$phone_url . "newcont" ?> target="_self"><img class="f_sy"
                                                                                           src="images/back_0.png"></a>
</div>
<div class="top_60"></div>
<div class="ysq_title_bg">
    <div class="ysq_title">
        <a>
            <div id="ysq_title_left" onClick="newon();">全部</div>
        </a>
        <a>
            <div id="ysq_title_right" onClick="aboutmeon();">与我相关</div>
        </a>
    </div>
    <br style="clear:both;">
</div>
<div class="pagetop" id="pagetop" style="text-align:center;"><img onClick="pageup()" src="images/top.png"></div>
<div id="top_new">
    <?php  foreach ($newart as $k => $v) {
        $host = str_replace('http://', '', Yii::$app->request->getHostInfo());
        $thumb = str_replace($host, '', $v->thumb);
        $url = str_replace(".thumb", '', $thumb);
        ++$record_num;
        ?>
        <div class="article">
            <div class="title_grey"><?= $v->title ?></div>
            <div class="name_time"><span class="only_left"><?= $v->author_name ?></span><span
                    class="only_right"><?= $v->createtime ?></span></div>
            <div class="art_img"><img src="<?= $url ?>"></div>
            <div class="clear ysq_content"><?= CommonFun::getsubstr($v->contents) ?></div>
            <div class="check_all"><a href=<?php echo SiteCom::$phone_url . "detail&webtype=1&id=" . $v->id ?>>查看全文</a>
            </div>
            <br style="clear:both;">
        </div>
    <?php
    }
    ?>
</div>
<div id="aboutme">
    <?php  foreach ($relateme as $kk => $vv) {
        ?>
        <div class="article">
            <div class="title_grey"><?= $vv->title ?></div>
            <div class="name_time"><span class="only_left"><?= $vv->author_name ?></span>
                <span class="only_right"><?= $v->createtime ?></span></div>
            <div class="clear ysq_content"><?= CommonFun::getsubstr($vv->contents) ?></div>
            <div class="check_all"><a href=<?php echo SiteCom::$phone_url . "detail&webtype=2&id=" . $vv->article_id ?>>查看全文</a>
            </div>
            <br style="clear:both;">
        </div>
    <?php
    }
    ?>
</div>
<div style="width:100%; height:4rem;"></div>
<div class="pagebottom" id="pagebottom"><img onClick="pagedown()" src="images/bottom.png"></div>
</body>
</html>
<script language="javascript">
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
            window.location.href = "index.php?r=phone/ysq&page=" + page;
        }
        else {
            $('#pagebottom').hide();
        }
    }
</script>