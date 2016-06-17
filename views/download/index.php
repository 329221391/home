<?php  use app\modules\AppBase\base\HintConst;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>家园桥</title>
<script language="JavaScript"> 
function display_tips(){
     document.getElementById('download_tips').style.display= 'block';
     document.getElementById('download_tips2').style.display= 'block';
}
</script>
<style type="text/css">
<!--
.download_tips {
	background-color: #FFFFFF;
	position: absolute;
	left: 0px;
	top: 0px;
	right: 0px;
	width: 100%;
	padding-bottom: 1em;
	padding-left: 1em;
	display:none;
	 
}
.alpha_bg {
	 
	width: 100%;
	position: absolute;
	left: 0px;
	top: 0px;
	right: 0px;
	bottom: 0px;
}
-->
</style>
</head>
<body>
<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}
body{font-family:"微软雅黑";}
.a_jia a{ color:#FFF; list-style-type:none; text-decoration:none;}
.width_load{ width:60%; /*max-width:701px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)>701?"701px":""*/); margin-top:30px;}
@media (min-width: 640px){
	.tel{ font-size:30px;margin-right:15%;}
	.b_lianjie{font-size:16px;}
	.logo_left{margin-left:15%;float:left; display:inline;}
}


@media (min-width: 460px) and (max-width: 639px) {
.tel{ font-size:20px;margin-right:15%;}
.b_lianjie{font-size:13px;}	
.logo_left{margin-left:15%;float:left; display:inline;}
	}
@media (min-width: 330px) and (max-width: 459px) {
.tel{ font-size:12px;margin-right:15%;}	
.b_lianjie{font-size:10px;} 
.logo_left{margin-left:15%;float:left; display:inline;}
	}
@media (min-width: 200px) and (max-width: 329px) {
.tel{ font-size:12px;margin-right:5%;}	
.b_lianjie{font-size:10px;} 
.logo_left{margin-left:5%;float:left; display:inline;}
	}

</style>
<Div class="download_tips" id="download_tips">
<div class="" style="float:left;width:70%;padding:1em 0 0 1em;">
如果没有跳转到下载页面，您可能使用了新版本的微信.<p>
点击右上角的跳转按钮，选择在浏览器中打开，然后即可下载
</div>
<div class="" style="float:right;"><img src="images/zhishi_xiazai.png" /></div>
<div class="" style="float:right;"><img src="images/open_in_web.png" /></div>
</Div>
 <Div class="alpha_bg" id="download_tips2" onclick="this.style.display='none';document.getElementById('download_tips').style.display= 'none';"></Div>

<div style="height:70px; line-height:70px; background:#28cacc; width:100%; text-align:center;><span class="logo_left"><a href="<?=HintConst::$WEB_JYQ ?>"><img src="images/logo1.png"  style="  margin-top:5px; line-height:80px;"  /></a></span></div>
<div style="background:#7fcdec; text-align:center;" >

<a href="<?php if($if_wx){?>javascript:display_tips();<?php }else{ ?>index.php?r=download/parent<?php }?>"><img class="width_load" src="images/jz_zj.png"   /></a>
<a href="<?php if($if_wx){?>javascript:display_tips()<?php }else{ ?>index.php?r=download/headmast<?php }?>"><img class="width_load" src="images/yz_zj.png"   /></a> 
<a href="<?php if($if_wx){?>javascript:display_tips()<?php }else{ ?>index.php?r=download/teacher<?php }?>"><img class="width_load" src="images/js_zj.png" style="margin-bottom:30px;"   /></a>
 
 
 
</div>
<div><img src="images/jyq_zj.jpg" width="100%"  /></div>
<div style="text-align:center; background:#e73462;"><a href="<?=HintConst::$WEB_JYQ?>index.php?r=site/sqhz"><img src="images/jrwm_zj.jpg"  width="65%" style=" max-width:807px;  margin-top:35px; margin-bottom:35px;"  /></a></div>
<div class="a_jia" style="text-align:center; background:#e73462; border-top:#FFF 2px dotted; color:#FFF; font-size:14px;">
  <table class="b_lianjie" width="0" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="60">&nbsp;</td>
      <td width="15%"><a href="#">首页</a></td>
      <td width="15%"><a href="#">使用帮助</a></td>
      <td width="15%"><a href="#">申请合作</a></td>
      <td width="15%"><a href="#">关于我们</a></td>
      <td>&nbsp;</td>
    </tr>
    <tr style="margin-bottom:15px;">
      <td height="60">&nbsp;</td>
      <td colspan="4">发现教育科学研究所版权所有，所有内容未经授权，不得转载或做其他使用 豫ICP备10206261号-2</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html>
