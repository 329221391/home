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
<script type="text/javascript" src="js/bottomgb.js" ></script>
<title>班级信息</title>
<head>
</head>
<body style="background:#eeeeee;">
<div class="z_title">班级信息</div>
<div id="ms_top"></div>
<div class="top_60"></div>
<div class="cl"><span class="cla_grey letter_width">班级码：</span><span class="cla_black"><?= $parentInfo['ClassInfo'][0][HintConst::$Field_code] ?></span></div>
<div class="cl"><span class="cla_grey ">班级名称：</span><span class="cla_black"><?= $parentInfo['ClassInfo'][0][HintConst::$Field_name] ?></span></div>
<div class="cl"><span class="cla_grey">主任老师：</span><span class="cla_black"><?= $parentInfo['TeacherInfo'][0][HintConst::$Field_name_zh] ?></span></div>
<div class="cl"><span class="cla_grey letter_width1">电话：</span><span class="cla_black"><?= $parentInfo['TeacherInfo'][0][HintConst::$Field_phone] ?></span></div>
<div class="cl"><span class="cla_black"><a href="tel:<?= $parentInfo['TeacherInfo'][0][HintConst::$Field_phone] ?> ">拨打电话</a></span></div>
<div class="cl cl_yz"><span class="cla_grey ">园长姓名：</span><span class="cla_black"><?= $parentInfo['HeadmastInfo'][0][HintConst::$Field_name_zh] ?></span></div>
<div  class="clear cl"><span class="cla_grey ">园长电话：</span><span class="cla_black"><?= $parentInfo['HeadmastInfo'][0][HintConst::$Field_phone] ?></span></div>
<div class="cl"><span class="cla_black"><a href="tel:<?= $parentInfo['HeadmastInfo'][0][HintConst::$Field_phone] ?>">拨打电话</a></a></span></div>

<?php include("fourbottom.php")?>
</body>
</html>
