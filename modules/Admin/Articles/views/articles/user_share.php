<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $article['contents']?></title>
<style type="text/css">
 
<!--
/*.share_title { text-align:left; width:100%; text-shadow: 0px 3px 3px #000;
	line-height: 2em;
	color: #FFFFFF;
	text-indent:1em;
	padding-top:0.5em;
	position:absolute; z-index:2; left:0; bottom:5em;
}*/
.share_title { text-align:left; width:100%; text-shadow: 0px 3px 3px #000;
	line-height: 2em;
	color: #FFFFFF;
	text-indent:1em;
	padding-top:0.5em;
	position:fixed; bottom:3.9em; z-index:3; left:0; 
}
* {
	font-family: "微软雅黑", Arial;
	margin: 0px;
	padding: 0px;
}

.blue {
	color: #0278fe;
}
.gray {
	color: #959595;
}
.limit_width{
   max-width:600px;
   min-width:300px;
}
.pic_title {
	width: 100%;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
.school_info {
	font-size:0.7em;
	line-height: 2em;
}
.pic_content {
	width: 100%;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0em;
	margin-left: auto;
	padding-top: 0em;
}
.tel_btn {
	position: fixed;
	width: 100%;
	background-color: #21292b;
	color: #FFFFFF;
	bottom:0px;
	font-size:0.8em;
	text-align:center;
	padding:0.5em 0px;
z-index:4; 
}
.outer {
	position:relative;
}
.deal_num {
z-index:5; 
	position: fixed;
	background-color: #28cacc;
	color: #FFFFFF;
	bottom:0.5em;
	right:1em;
	font-size:0.8em;
	text-align:center;
}
.bottom_35{ height:3.5em; width:100%;}
.tp{ width:100%; height:90%; position:absolute; left:0; top:0; text-align:center;font-size:0;}
.tel_btn a{ color:#fff; text-decoration:none;}
.img404{ border:0; width:100%; vertical-align:middle; max-width:600px;}       
.verticalAlign{ vertical-align:middle; display:inline-block; height:100%; width:1px; margin-left:-1px;}  
-->
</style>
</head>
<body style="background-color:#424545;">
    <div class="tp">
	<span class="verticalAlign"></span>
	 <img class="img404" src="<?= $article['url']?>" /> <div class="share_title"> 
<!--  <div class="school_info">
        <?= $article['createtime']?>
  </div>-->
</div></div>

<div class="bottom_35"></div>
<div class="tel_btn">
 <a class="baise" href="tel:<?= $school_info['tel']?>"><?= $school_info['name']?><br />
	 电话：<?= $school_info['tel']?><br />
  地址：<?= $school_info['address']?><br /></a>
</div>
</body>
</html>
