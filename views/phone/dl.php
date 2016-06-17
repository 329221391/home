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
<link href="css/buttons.css" rel="stylesheet" type="text/css">
<link href="css/css.css" rel="stylesheet" type="text/css">
<title>登录</title>
<head>
</head>
<body>
<div class="sy_logo"><img src="images/logo_mbweb.png"></div>
<div class=" clear dl"> 
<input class="round_ty" value="家长手机：" class="round_ty"   onFocus="if (value =='家长手机：'){value =''}" onBlur="if (value ==''){value='家长手机：'}" name="" type="text"> <br>
<input class="round_ty mmjg" value="密码：" class="round_ty"   onFocus="if (value =='密码：'){value =''}" onBlur="if (value ==''){value='密码：'}" type="text"> <br>

 <input type="button" class=" button button-caution button-pill dlsz" value="登&nbsp;录">

</div>
<div  class="xm" style="margin-top:2.2rem;"><span class="left" >忘记密码</span><span class="right"><a href=<?php echo SiteCom::$phone_url."dl_xyh" ?> target="_self" >新用户</a></span></div>
</body>
</html>
