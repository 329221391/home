<?php
use app\modules\AppBase\base\HintConst;
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
<title>园所信息</title>
<head>
</head>
<body><div class="z_title">园所信息</div>
<div id="ms_top"><a href=<?php echo SiteCom::$phone_url."exit" ?> target="_self"><img class="f_sy" src="images/back_0.png"></a></div>
<div class="x_pic"><img style="padding-top:4rem;"  src="images/60/icons_xz.png"><br style="clear:both;" /></div>
<div class="x_mes"><span class="mes_left">园所名称：</span><span class="mes_right"><?= $parentInfo['SchoolInfo'][HintConst::$Field_name] ?></span></div>
<div class="x_mes"><span class="mes_left">园长姓名：</span><span class="mes_right"><?= $parentInfo['HeadmastInfo'][0][HintConst::$Field_name_zh]  ?></span></div>
<div class="x_mes"><span class="mes_left">联系电话：</span><span class="mes_right"><?= $parentInfo['SchoolInfo'][HintConst::$Field_tel] ?></span></div>
<div class="x_mes"><span class="mes_left">园所介绍：</span><span class="mes_right"><?= $parentInfo['SchoolInfo'][HintConst::$Field_description] ?></span></div>
</body>
</html>
