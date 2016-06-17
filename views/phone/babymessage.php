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
<title>宝宝信息</title>
<head>
</head>
<body>
<div class="z_title">宝宝信息</div>
<div id="ms_top"><a href=<?php echo SiteCom::$phone_url."mymessage" ?> target="_self"><img class="f_sy" src="images/back_0.png"></a></div>
<div class="top_60"></div>
<div class="cl"><span class="cla_grey letter_width">班级码：</span><span class="cla_black"><?= $parentInfo['ClassInfo'][0][HintConst::$Field_code] ?></span></div>
<div class="cl"><span class="cla_grey ">班级名称：</span><span class="cla_black"><?= $parentInfo['ClassInfo'][0][HintConst::$Field_name] ?></span></div>
<div class="cl"><span class="cla_grey">宝宝姓名：</span><span class="cla_black"><?= $parentInfo['ParentInfo']->name_zh ?></span></div>
<div class="cl"><span class="cla_grey">家长电话：</span><span class="cla_black"><?= $parentInfo['ParentInfo']->phone ?></span></div>



</body>
</html>
