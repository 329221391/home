<?php
use app\modules\AppBase\base\SiteCom;
use app\modules\AppBase\base\HintConst;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>使用帮助 - 家园桥</title>
<meta name="keywords" content="家园桥，幼儿园，宝宝，园长，家长，幼儿教育，幼儿，管理教师，管理幼儿园，联系家长，联系老师，移动秘书,发现教育，图片分享，宝宝评价，园所宣传"/>
<meta Name="description" Content="家园桥，园长端，家长端，教师端，幼儿园，宝宝，今日动态，打电话，成长历程，吃饭情况，课程设置，园所信息" />
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<script type="text/javascript">
function banner(){	
	var bn_id = 0;
	var bn_id2= 1;
	var speed33=5000;
	var qhjg = 1;
    var MyMar33;
	$("#banner .d1").hide();
	$("#banner .d1").eq(0).fadeIn("slow");
	if($("#banner .d1").length>1)
	{
		$("#banner_id li").eq(0).addClass("nuw");
		function Marquee33(){
			bn_id2 = bn_id+1;
			if(bn_id2>$("#banner .d1").length-1)
			{
				bn_id2 = 0;
			}
			$("#banner .d1").eq(bn_id).css("z-index","2");
			$("#banner .d1").eq(bn_id2).css("z-index","1");
			$("#banner .d1").eq(bn_id2).show();
			$("#banner .d1").eq(bn_id).fadeOut("slow");
			$("#banner_id li").removeClass("nuw");
			$("#banner_id li").eq(bn_id2).addClass("nuw");
			bn_id=bn_id2;
		};
	
		MyMar33=setInterval(Marquee33,speed33);
		
		$("#banner_id li").click(function(){
			var bn_id3 = $("#banner_id li").index(this);
			if(bn_id3!=bn_id&&qhjg==1)
			{
				qhjg = 0;
				$("#banner .d1").eq(bn_id).css("z-index","2");
				$("#banner .d1").eq(bn_id3).css("z-index","1");
				$("#banner .d1").eq(bn_id3).show();
				$("#banner .d1").eq(bn_id).fadeOut("slow",function(){qhjg = 1;});
				$("#banner_id li").removeClass("nuw");
				$("#banner_id li").eq(bn_id3).addClass("nuw");
				bn_id=bn_id3;
			}
		})
		$("#banner_id").hover(
			function(){
				clearInterval(MyMar33);
			}
			,
			function(){
				MyMar33=setInterval(Marquee33,speed33);
			}
		)	
	}
	else
	{
		$("#banner_id").hide();
	}
}

function getScrollTop(){
　　var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
　　if(document.body){
　　　　bodyScrollTop = document.body.scrollTop;
　　}
　　if(document.documentElement){
　　　　documentScrollTop = document.documentElement.scrollTop;
　　}
　　scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
　　return scrollTop;
}
window.onscroll = function(){
　　if(getScrollTop() <=150){
　　　　$("#to_top").fadeOut("slow");
　　}
　　if(getScrollTop() >150){
　　　　$("#to_top").fadeIn("slow");
　　}
};
</script>
<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}
body{font:12px/180% "微软雅黑", Arial, Helvetica, sans-serif;margin-top:-20px;}
.li{ list-style-type:none;}
.clear{ clear:both;}
.nav{top:0; width:100%; background:#28cacc;  height:90px; min-width:1008px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1008?"1008px":"");}
.nav_m{ width:1008px; margin:0 auto;}
.logo{ float:left; display:inline; margin-top:18px; margin-left:5px;}
.nav_f{ margin-top:40px; float:right; display:inline; color:#FFFFFF; font-size:16px; font-weight:bolder; margin-right:20px;}
.nav_f ul li{ height:40px; line-height:40px; float:left; display:inline; width:110px; text-align:center;}
.nav_f ul li a{ color:#FFFFFF; height:40px;  display:block; text-decoration:none;}
.nav_f ul li a:hover{ text-decoration:none; background:url(images/navf_bg.gif) no-repeat center;}
.shouye a{ background:url(images/navf_bg.gif) center no-repeat;}
.yzdl a{ background:url(images/yzdl_bg.gif) center no-repeat;}
#n_zt{ width:100%; height:auto; background:#dcdcdc;min-width:1008px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1008?"1008px":"");}
.n_zt{width:1008px; margin:0 auto; height:auto; padding-top:15px; padding-bottom:5px; }
.n_ztjia{ clear:both; float:left; display:inline; width:1208px;}
.n_zt_top{  background:url(images/ntop_bg1.gif) top center no-repeat; height:3px; width:1008px;}
.n_zt_middle{ height:auto; background:url(images/nmiddle_bg1.gif) center repeat-y; width:1008px; height:auto;/*padding:0px 5px 0px 3px;*/ float:left; display:inline;}
.n_zt_bottom{ background:url(images/nbottom_bg1.gif) center bottom no-repeat; width:1008px; height:18px; }
#n_footer{ width:100%; height:70px; background:#4b6364;min-width:1008px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1008?"1008px":"");}
.n_footer{ margin:0 auto; width:1008px; color:#FFFFFF; line-height:70px;}
.n_footer a{ text-decoration:none; color:#FFFFFF;}
.n_zt_middle_left{ height:auto; width:249px; float:left; display:inline; margin-left:3px;}
.n_zt_middle_left ul li{ height:80px; width:249px; border-bottom:#dcdcdc 1px solid; line-height:80px; text-align:left; }
.n_zt_middle_left a{ color:#a0a0a0; font-size:20px; font-family:"微软雅黑"; font-weight:lighter; text-decoration:none; height:80px; width:249px; display:block; /*padding-left:40px;*/ }
.n_hover a{color:#000000; font-weight:bolder; background:url(images/nnav_hover1.gif) no-repeat center;}
.n_zt_middle_right{float:left; display:inline; height:auto; width:748px; font-family:"微软雅黑";}
.z_title{ height:80px; border-bottom:#dcdcdc 1px solid; width:750px; line-height:80px; font-size:20px; font-weight:bolder; }
.z_content{ font-size:16px; color:#000000; line-height:25px; padding:25px; height:auto; float:left; display:inline;}
p{ margin-top:15px; margin-bottom:15px;}
.a_left{ margin-left:40px;}
.to_top{position:fixed; width:100%; min-width:1100px; bottom:100px; text-align:center; z-index:100000; display:none;}
.xuanfu{ width:1100px; text-align:right; margin:0 auto;}
/*#to_top{ display:none;}*/
</style>
</head>

<body>
    <div class="nav">
    <div class="nav_m">
    <div class="logo"><img src="images/logo.png" /></div>
    <div class="nav_f">
    <ul>
    <li ><a href=<?php echo SiteCom::$site_url."index" ?>>首&nbsp;&nbsp;&nbsp;页</a></li>
        <li><a href=<?php echo SiteCom::$site_url."sqhz" ?>>申请合作</a></li>
        <li class="shouye"><a href=<?php echo SiteCom::$site_url."sybz" ?>>使用帮助</a></li>
        <li><a href=<?php echo SiteCom::$site_url."gywm" ?>>关于我们</a></li>
        <li><a href=<?php echo SiteCom::$site_url."lxwm" ?>>联系我们</a></li>
        <li ><a href=<?php echo SiteCom::$site_url."zxns" ?>>招贤纳士</a></li>
        <li><a style="background:url(images/yzdu_fen_bg.gif) no-repeat center; width:120px;"href="index.php?r=manage/class">园长登陆</a></li>
    </ul>
    </div>
    </div>
    </div>
    <div id="n_zt">
    <div class="n_zt">
   
    <div class="n_zt_top">&nbsp;</div>
    <div class="n_zt_middle">
    <div class="n_zt_middle_left">
    <ul>
    <li><a href=<?php echo SiteCom::$site_url."sqhz" ?>><span class="a_left">申请合作</span></a></li>
    <li class="n_hover"><a href=<?php echo SiteCom::$site_url."sybz" ?>><span class="a_left">使用帮助</span></a></li>
    <li><a href=<?php echo SiteCom::$site_url."gywm" ?>><span class="a_left">关于我们</span></a></li>
    <li><a href=<?php echo SiteCom::$site_url."lxwm" ?>><span class="a_left">联系我们</span></span></a></li>
    <li><a href=<?php echo SiteCom::$site_url."zxns" ?>><span class="a_left">招贤纳士</span></a></li>
    <li></li>
    <li></li>
    </ul>
    </div>
    <div class="n_zt_middle_right" >
    <div class="z_title"><span class="a_left">使用帮助</span></div>
    <div class="z_content">
	<p><b>·  家园桥使用帮助目录</b></p>
	<p><a href="#001">·  家园桥是什么？</a><br />
	<a href="#002">·  家园桥怎么下载安装？</a><br />
	<a href="#003">·  家园桥怎么下载安装？</a><br />
	<a href="#004">·  如何获取帐号及密码？</a><br />
	<a href="#005">·  忘记登录密码了怎么办？</a><br />
	<a href="#006">·  老师怎样给宝宝发评价？</a><br />
	<a href="#007">·  如何发布通知？</a><br />
	<a href="#008">·  如何发表文章？</a><br />
	<a href="#009">·  如何和其他人聊天？</a><br />
	<a href="#010">·  什么是园所圈？</a><br />
	<a href="#011">·  家长如何通过家园桥查看幼儿在校状态？</a><br />
	<a href="#012">·  家园桥都有什么功能？</a><br />
	<a href="#013">·  家园桥是干什么的？</a><br />
	<a href="#014">·  使用家园桥是怎样收费的？</a><br />
	<a href="#015">·  对园长有什么好处？</a><br />
	<a href="#016">·  家园桥园长使用说明下载</a><br />
	</p>
      <p id="001"><b>·  家园桥是什么？</b></p>
      <p>·  家园桥是国内领先的幼教互动云平台， 致力于提升幼儿园信息化水平，为幼儿园和家长搭建沟通互动新桥梁。 一部手机管理一个幼儿园，联系家长和幼儿园两端，这是提升幼儿园教育信息化水平的必然趋势，也是家园共育的全新方式。家园桥正式在这样的背景下应运而生，它不仅仅是一款让家长了解孩子在幼儿园生活的软件，更是一个能使家长与幼儿园彼此信任、家长与孩子心灵贴近的沟通成长平台。</p>
      <p id="002"><b>· 家园桥怎么下载安装？</b></p>
      <p>·  登录家园桥官网 <a href="<?=HintConst::$WEB_JYQ?>">jyq365.com</a>，选择相应的客户端下载，下载完成后，执行安装操作即可。</p>
      <p id="003"><b>· 家园桥支持哪些手机？</b></p>
      <p>·  iPhone和Android常见智能机型。</p>
      <p id="004"><b>· 如何获取帐号及密码？</b></p>
      <p>·  园长用户登录家园桥官网，点击申请合作，填写幼儿园信息后，获取注册信息。 老师用户使用园长提供的用户ID，默认的初始密码是123456。家长用户使用老师提供的班级码直接注册登录。 </p>
      <p id="005"><b>· 忘记登录密码了怎么办？</b></p>
      <p>· 忘记登录密码了，去找园长吧。园长可以帮助家长和老师初始化密码，初始密码是123456。</p>
<p id="006"><b>· 老师怎样给宝宝发评价？</b></p>
<p>·  打开家园桥【园所圈】页面，点击【宝宝评价】按钮，进入即可发布对某个宝贝的月评价和学期总结了。对宝贝的点评信息，只有该宝贝的家长和园长可以看到，其他宝贝的家长不会看到。</p>
<p id="007"><b>· 如何发布通知？</b></p>
<p>·  在家园桥【通讯录】页面，选择【全部老师】或【全部家长】后即可编辑要发布的通知内容。</p>
<p id="008"><b>· 如何发表文章？</b></p>
<p>·  不管在哪里看到了精彩文章，想要分享给大家，在家园桥首页面，点击【发文章】后即可编辑要发布的文章内容，需要提醒的是一定要选择文章分享给谁看，全体老师？全体家长，还是某个人。园长和老师都可以发表文章
</p>
<p id="009"><b>· 如何和其他人聊天？</b></p>
<p>· 在家园桥【通讯录】页面，点击园长、某个老师或某个家长，即可对他进行一对一聊天。
</p>
<p id="010"><b>·什么是园所圈？</b></p>
<p>·  园所圈是家园桥提供的一个以班级为单位的构建家长与老师、园长之间沟通的互动云平台，园长可以通过选择班级，对各个班级圈子动态信息的查看，同时也可以与各家长、老师互动，但老师和家长只能看到跟自己相关的信息。
</p><p id="011"><b>·家长如何通过家园桥查看幼儿在校状态</b>
</p><p>·打开家长端，首页面就是今天宝宝在园的情况预览，包括：今日食谱，今日饮食、休息、学习、活动状况的描述，还有最重要的幼儿精彩瞬间。

</p>
<ol>
  <li id="012"><b>·家园桥都有什么功能？ </b></li>
</ol>
<p >&nbsp;&nbsp;&nbsp;即时方便的让园长管理幼儿园 </p>
<p >可以发文章和照片给老师及家长，让家长随时了解孩子在幼儿园的每日动态 </p>
<p >园长端： </p>
<p >&#9352;&nbsp;发文章：园长可以随时发文章，可以指定给某个班级、某个老师、某个家长。 </p>
<p >&#9353;&nbsp;发私信：能够接收老师或家长发来的私信，进行一对一的聊天、沟通。&nbsp; </p>
<p >&#9354;&nbsp;宝宝评价。&#9312;.宝宝月评价：随时了解宝宝当月在幼儿园的表现，每月一评价，看到宝宝进步的点滴。教师通过宝宝月评价点评宝宝在幼儿园一月的表现，并将评价推送给家长，增强家园互动，家长可及时了解每月宝宝成长情况。&nbsp;&nbsp; </p>
<p >&#9313;.宝宝学期总结：宝宝一学期在幼儿园的表现，收获，通过宝宝学期总结及时查看，了解宝宝学期变化，加强家园互动，增加家长对幼儿园的信任度。 </p>
<p >&nbsp;&nbsp;4.待审核。&#9312;.待审图片：老师发表的图片要经过园长审核通过才能发表。 </p>
<p >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#9313;.待审文章：老师发表的文章要经过园长审核通过才能发表。 </p>
<p >&nbsp;&#9314;.待审评价：老师对宝宝做的月评价和学期总价要通过园长审核通过才能发表给家长。 </p>
<p >&nbsp;&nbsp;&nbsp;&nbsp;5.通讯录:可以群发、私聊。 </p>
<p >&nbsp;&nbsp;&nbsp;&nbsp;6.拍照：可以把某个班宝宝的动态情况发个某个班级。 </p>
<p >7.园所圈：园长可以通过选择班级，对各个班级圈子动态信息的查看，同时也可以与各家长、老师互动，但老师和家长只能看到跟自己相关的信息。 </p>
<p >&nbsp;&nbsp;宝宝评价：园长可以查看老师对某个班某个宝宝的月评价。 </p>
<p >8.管理分为（班级管理、教师管理、家长管理、食谱管理、生活标签、课程管理） </p>
<p >&nbsp;&nbsp;班级管理：可以添加班级，选择老师。 </p>
<p >&nbsp;&nbsp;教师管理：可以添加老师的信息。随时随地掌握教师动态。 </p>
<p >&nbsp;&nbsp;家长管理：可以查看所有宝宝的姓名以及家长电话。 </p>
<p >&nbsp;&nbsp;食谱管理：可以更改每周每天的食谱。 </p>
<p >&nbsp;&nbsp;生活标签：可以添加宝宝在校的动态情况。 </p>
<p >&nbsp;&nbsp;课程管理：可以添加及更改课程 </p>
<p >9.今日动态：园长可以查看某个班今天在幼儿园的生活情况。精彩瞬间（随时记录宝宝的精彩瞬间，分享给家长） </p>
<p >教师端： </p>
<p >教师端和园长端不同之处在与，管理与被管理的关系。老师是被管理者。 </p>
<p >家长端： </p>
<p >&#9312;.家长端能够看到宝宝在学校每天的饮食情况，能够看到宝宝的成长记录。 </p>
<p >&#9313;.园所信箱：可以与园长、老师进行一对一的沟通。 </p>
<p >&#9314;.新文章：每天可以查看园所圈的动态，可以看到宝宝的月评价及学期总结。 </p>
<p >&#9315;.成长历程：可以看到宝宝每天的精彩瞬间、每月的成长记录、可以看到宝宝成长的脚步，是一本有爱的宝宝成长&#8220;日记&#8221;，记录点滴童年精彩。 </p>
<ol id="013"><li><b>·家园桥是干什么的？&nbsp; </b></li>
</ol>
<p >家园桥是园长的贴心助手，随身秘书&nbsp; </p>
<p >1，家园桥是为园长更好的管理园所而产生的，我们的初衷是园长不用总那么的忙碌，随时随地了解园所动态。&nbsp; </p>
<p >&#9312;．家园桥是幼儿园管理软件。 </p>
<p >&#9313;．家园桥是园长用来管理家长和老师的。 </p>
<p >是一款让家长了解孩子在幼儿园的生活软件。 </p>
<p id="014"><b>·&nbsp;使用家园桥是怎样收费的？&#9; </b></p>
<p >免费 </p>
<p id="015"><b>·&nbsp;对园长有什么好处？</b> </p>
<p >&nbsp;&nbsp;&nbsp;可以通过发文章、发照片给老师和家长，老师和家长能够把文章和照片分享到朋友圈，让更多的人可以看到，让家长成为您园所的招生宣传员，从而提高园所的知名度。&nbsp;&nbsp; </p>
<p>&nbsp;</p>
<B id="016">家园桥园长使用说明:</B><br>
--电子书exe格式(仅支持电脑浏览)<br>
<a href="/download/家园桥使用说明.rar">点击下载</a><br>
--word文档(支持手机浏览)<br>
<a href="/download/家园桥说明书.doc">点击下载</a>
      <p>&nbsp;</p>
	  
    </div>
    </div>
    
    </div>
    <div style="clear:both;" class="n_zt_bottom"></div>
    <br style="clear:both;" />
    </div>
    </div>
    <div id="n_footer">
    <div class="n_footer">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="603" style="padding-left:50px;">北京当啷电子商务有限公司&nbsp;&nbsp;&nbsp;&nbsp;京公网安备11010502027307&nbsp;&nbsp;&nbsp;&nbsp;京ICP备12050802号-2</td>
    <td width="300">&nbsp;</td>
      <td width="35"><a href=<?php echo SiteCom::$site_url."index" ?>>首页</a></td>
      <td width="65"><a href=<?php echo SiteCom::$site_url."sybz" ?>>使用帮助</a></td>
      <td width="65"><a href=<?php echo SiteCom::$site_url."sqhz" ?>>申请合作</a></td>
      <td width="65" ><a href=<?php echo SiteCom::$site_url."gywm" ?>>关于我们</a></td>
    <td width="50">&nbsp;</td>
  </tr>
</table>
    </div>
    </div>
	<div id="to_top" class="to_top" ><div class="xuanfu"><a style="cursor:pointer;" onclick='window.scrollTo(0,0);'><img src="images/totop.png" /></a></div></div>
</body>
</html>