<?php
use app\modules\AppBase\base\CommonFun;
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
<title>宝宝评价</title>
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
    function getmeva(month) {
        window.location.href = 'index.php?r=phone/babyevaluate&webtype=3&month=' + month;
    }
    function getyeva(term) {
        window.location.href = 'index.php?r=phone/babyevaluate&webtype=4&term=' + term;
    }
    //    month = new Date().getMonth() + 1;
    //    year = new Date().getYear();
    curYearMonth = "<?= $month?>";//month eva  using
    curTearYear = "<?= $term?>";//year eva using
    month = curYearMonth.substr(4, 2);
    year = curYearMonth.substr(0, 4);
    function newmonth() {
        document.getElementById("m_c").innerHTML = curYearMonth;
        document.getElementById("m_year").innerHTML = curTearYear;
    }
    function monthevlleft() {
        var month1;
        month--;
        if (month == 0) {
            month = 12;
            year--;
        }
        month1 = month;
        if (month1 < 10)month1 = "0" + month1;
        newmonth = year + "" + month1;
        document.getElementById("m_c").innerHTML = newmonth;
        getmeva(newmonth);
    }
    function monthevlright() {
        var month1;
        month++;
        if (month == 13) {
            month = 1;
            year++;
        }
        month1 = month;
        if (month1 < 10)month1 = "0" + month1;
        newmonth = year + "" + month1;
        document.getElementById("m_c").innerHTML = newmonth;
        getmeva(newmonth);
    }
    function yearevlleft() {
        curTearYear--;
        document.getElementById("m_year").innerHTML = curTearYear;
        getyeva(curTearYear);
    }
    function yearevlright() {
        curTearYear++;
        document.getElementById("m_year").innerHTML = curTearYear;
        getyeva(curTearYear);
    }
</script>
<head></head>
<body onLoad="newmonth()">
<div class="z_title">宝宝评价</div>
<div id="ms_top"><a href="index.php?r=phone/newcont" target="_self"><img class="f_sy"
                                                                          src="images/back_0.png"></a>
</div>
<div class="top_60"></div>
<div class="month_add">
    <div class="ysq_title "><a>
            <div id="ysq_title_left" onClick="newon();">月评价</div>
        </a> <a>
            <div id="ysq_title_right" onClick="aboutmeon();">学期总结</div>
        </a></div>
</div>
<div id="top_new">

    <?php if ($webtype == 3) {
        foreach ($eva as $k => $v) {
            ?>
            <a href=<?php echo SiteCom::$phone_url . "detail&webtype=3&id=" . $v->id ?>>
                <div class="detail_article border_bottom1">
                    <div class="top_word"><span class="top_title">
      <?= $v->title ?>
      </span><br>
      <span class="top_title_grey">
      <?= CommonFun::getsubdate($v->createtime) ?>
      </span><span
                            class="top_title_blue">&nbsp;&nbsp;&nbsp;&nbsp;
      </span></div>
                    <div class="title_con">
                        <?= CommonFun::getsubstr($v->contents) ?>
                    </div>
                    <br style="clear:both;">
                </div>
            </a>
        <?php
        }
    } ?>
</div>
<div id="aboutme">


    <?php if ($webtype == 4) {
        foreach ($eva as $k => $v) {
            ?>
            <a href=<?php echo SiteCom::$phone_url . "detail&webtype=4&id=" . $v->id ?>>
                <div class="detail_article border_bottom1">
                    <div class="top_word"><span class="top_title">
      <?= $v->title ?>
      </span><br>
      <span class="top_title_grey">
      <?= CommonFun::getsubdate($v->createtime) ?>
      </span><span
                            class="top_title_blue">&nbsp;&nbsp;&nbsp;&nbsp;
      </span></div>
                    <div class="title_con">
                        <?= CommonFun::getsubstr($v->contents) ?>
                    </div>
                    <br style="clear:both;">
                </div>
            </a>
        <?php
        }
    } ?>
</div>
</body>
</html>
<script type="text/javascript">
    if ("<?= $webtype?>" == 4) {
        aboutmeon()
    }
    $("#ysq_title_left").click(function () {
        window.location.href = 'index.php?r=phone/babyevaluate&webtype=3';
    });
    $("#ysq_title_right").click(function () {
        window.location.href = 'index.php?r=phone/babyevaluate&webtype=4';
    });
</script>
