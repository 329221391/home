<?php
use app\modules\AppBase\base\SiteCom;
?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content=" initial-scale=1.0,user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<link href="css/css_white.css" rel="stylesheet" type="text/css">
<title>查看详情</title>
<script language="javascript"> function op(c_url) {  window.open(c_url) }</script>

<head></head>
<body style="background:#E6E6E6">
<div class="z_title">查看详情</div>
<div id="ms_top"><a href=<?php echo SiteCom::$phone_url."babyevaluate" ?> target="_self"><img class="f_sy" src="images/back_0.png"></a></div>
<div class="top_60"></div>
<div class="detail_article">
  <div class="top_img"><img src="images/lstx48.png"></div>
  <div class="top_word"><span class="top_title">2015年三月的评价</span><br>
    <span class="top_title_grey">2015-03-05</span><span class="top_title_blue">王宏</span></div>
  <div class="title_con">通知通知通知通知通知通,知通知通知通知通,知通知通知通知通知通知.通知通知通。知通知通知通知通知。通知通。知通知通知通知通知通知通知通知通知</div>
  <div class="det_img"><img src="images/sj.jpg"  onclick="op(this.src)" style="cursor:pointer;" ></div>
  <div class="title_img"><a href=<?php echo SiteCom::$phone_url."evaluate_reply" ?>><img src="images/ysq_hf.png"></a></div>
  <br style="clear:both;">
</div>
</body>
</html>
