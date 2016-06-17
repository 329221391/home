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

<title>新文章</title>
<head>
</head>
<body style="background:#eeeeee;">
<div class="z_title">新文章</div>
<div id="ms_top"><!--<a href="index.html" target="_self"><img class="f_sy" src="images/back_0.png"></a>--></div>
<div class="top_60"></div>

<a href=<?php echo SiteCom::$phone_url."ysq" ?> target="_self">
<div class="amail_banner"><img class="amail_img" src="images/ysq_48.png">园所圈</div></a>
<a href=<?php echo SiteCom::$phone_url."babyevaluate" ?> target="_self">
<div class="amail_banner"><img class="amail_img" src="images/bbpj_48.png">宝宝评价</div></a>
<?php include("fourbottom.php")?>
</body>
</html>
