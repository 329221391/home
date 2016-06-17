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
<link href="css/buttons.css" rel="stylesheet" type="text/css">
<link href="css/css.css" rel="stylesheet" type="text/css">
<title>园所信息</title>
<head></head>
<body style="margin:0; background:#FFFFFF;  background:url(../images/user_info_bg.png); background-size:cover;">
<div class="exit">
  <div class="iframeindex"><a  href=<?php echo SiteCom::$phone_url."index_all" ?> target="_self" style="display:block;"><table width="0" border="0" cellspacing="0" cellpadding="0"  style="width:100%; height:100%; ">
  <tr>
    <td style="background:#26cacb;"><img src="images/info_0.png"> </td>
  </tr>
  <tr>
    <td style="padding-top:5px;"><img src="images/60/icons_zj.png"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

   </a>
  </div>
  <div class="exit_head"><img style="width:5rem; float:left;" src="images/user_img02.png"><span style="float:left; line-height:3rem; margin-left:0.1rem; vertical-align:bottom; ">院所名称：<?= $parentInfo['SchoolInfo'][HintConst::$Field_name] ?><br>
    <span style="vertical-align:top; line-height:1rem;">学校码：<?= $parentInfo['SchoolInfo'][HintConst::$Field_code] ?></span></span></div>
  <div style="width:100%; min-height:500px;"> <a href=<?php echo SiteCom::$phone_url."exit_ms" ?> target="_self">
    <div class="exit_fox"><img class="exit_tb" src="images/yhxx_48.png">园所信息</div>
    </a> <a href=<?php echo SiteCom::$phone_url."exit_xgmm" ?> target="_self">
    <div class="exit_fox"><img class="exit_tb" src="images/xgmm_48.png">修改密码</div>
    </a> <a href=<?php echo SiteCom::$phone_url."exit_aboutjyq" ?> target="_self">
    <div class="exit_fox"><img class="exit_tb" src="images/jyq_48.png">关于家园桥</div>
    </a> <a href=<?php echo SiteCom::$phone_url."exit_qq" ?> target="_self">
    <div class="exit_fox"><img class="exit_tb" src="images/qq_48.png">客服	QQ</div>
    </a> <a href=<?php echo SiteCom::$phone_url."exit_phone" ?> target="_self">
    <div class="exit_fox"><img class="exit_tb" src="images/dh_48.png">客服电话</div>
 <!--   </a> <a href="javascript:closeWindow();" onclick="closeWindow();" >
    <div class="exit_fox1"></div>
    </a> -->
	<br style="clear:both;"/>
  </div>
  <br style="clear:both;"/>
</div>
</body>
</html>
