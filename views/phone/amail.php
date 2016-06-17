<?php
use app\modules\AppBase\base\HintConst;
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
<title>园所信箱</title>
<head>
</head>
<body style="background:#eeeeee;">
<div class="z_title">园所信箱</div>
<div id="ms_top"></div>
<div class="top_60"></div>
<a href=<?php echo SiteCom::$phone_url . "amail_con&id=" . $parentInfo['ParentInfo']->id . "&another_id=" . $parentInfo['HeadmastInfo'][0][HintConst::$Field_id]. "&cat_default_id=" . $parentInfo['HeadmastInfo'][0][HintConst::$Field_cat_default_id]. "&name=" . $parentInfo['HeadmastInfo'][0][HintConst::$Field_name_zh] ?> target="_self">
    <div class="amail_banner"><img class="amail_img"
                                   src="images/yhxx_48.png"><?= $parentInfo['HeadmastInfo'][0][HintConst::$Field_name_zh] ?>
    </div>
</a>
<a href=<?php echo SiteCom::$phone_url . "amail_con&id=" . $parentInfo['ParentInfo']->id . "&another_id=" . $parentInfo['TeacherInfo'][0][HintConst::$Field_id]. "&cat_default_id=" . $parentInfo['TeacherInfo'][0][HintConst::$Field_cat_default_id]. "&name=" . $parentInfo['TeacherInfo'][0][HintConst::$Field_name_zh] ?> target="_self">
    <div class="amail_banner"><img class="amail_img"
                                   src="images/bj_48.png"><?= $parentInfo['TeacherInfo'][0][HintConst::$Field_name_zh] ?>
    </div>
</a>
<?php include("fourbottom.php") ?>
</body>
</html>
