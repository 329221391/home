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
<script type="text/javascript" src="js/bottomgb.js" ></script>
<title>我的信息</title>
<head>
</head>
<body style="background:#eeeeee;">
<div class="z_title">我的信息</div>
<div id="ms_top"></div>
<div class="top_60"></div>
<a href=<?php echo SiteCom::$phone_url."classmessage" ?> target="_self">
<div class="amail_banner"><img class="amail_img" src="images/bj_48.png">班级信息</div></a>
<a href=<?php echo SiteCom::$phone_url."babymessage" ?> target="_self">
<div class="amail_banner"><img class="amail_img" src="images/ysq_48.png">宝宝信息</div></a>
<a href=<?php echo SiteCom::$phone_url."mystore" ?> target="_self">
<div class="amail_banner"><img class="amail_img" src="images/wdsc_48.png">我的收藏</div></a>
<?php include("fourbottom.php")?>
</body>
</html>
