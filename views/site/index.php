 <?php
$if_wx = strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')?1:0;
?>
<?php
use app\modules\AppBase\base\SiteCom;
?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>家园桥 - 国内领先的幼教互动云平台</title>
<meta name="keywords" content="家园桥，幼儿园，宝宝，园长，家长，幼儿教育，幼儿，管理教师，管理幼儿园，联系家长，联系老师，移动秘书,发现教育，图片分享，宝宝评价，园所宣传"/>
<meta Name="description" Content="家园桥，园长端，家长端，教师端，幼儿园，宝宝，今日动态，打电话，成长历程，吃饭情况，课程设置，园所信息" />
<script type="text/javascript" src="js/jquery.js"/></script>
<script type="text/javascript" src="js/xxk.js"/></script>
<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="js/simplefoucs.js" type="text/javascript"></script>
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
</script>
<script language="JavaScript">



function display_tips(){
     document.getElementById('download_tips').style.display= 'block';
     document.getElementById('download_tips2').style.display= 'block';
}


</script>
</head>

<body>

<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}
body{font:12px/180% Arial, Helvetica, sans-serif, "微软雅黑";background:#FFFFFF;
margin-top:-20px;
}
.li{ list-style-type:none;}
.clear{ clear:both;}
/* banner */
.banner{height:620px;overflow:hidden; position:relative;min-width:1004px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.banner .d1{width:100%;height:620px;display:block;position:absolute;left:0px;top:0px;min-width:1004px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.banner .d2{width:90%;height:30px;clear:both;position:absolute;z-index:100;left:120px;top:580px;}
.banner .d2 ul{float:left;position:absolute;left:50%;top:0;margin:0 0 0 -96px;display:inline;}
.banner .d2 li{width:17px;height:15px;overflow:hidden;cursor:pointer;background:url(images/img1.gif) no-repeat center;float:left;margin:0 3px;display:inline;}
.banner .d2 li.nuw{background:url(images/img1_1.gif) no-repeat center;}
.nav{ position:absolute; top:0; width:100%; background:url(images/nav_bg.gif) repeat; z-index:100; height:90px;min-width:1004px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.nav_m{ width:1004px; margin:0 auto; }
.logo{ float:left; display:inline; margin-top:18px;}
.nav_f{ margin-top:40px; float:right; display:inline; color:#FFFFFF; font-size:16px; font-weight:bolder;}
.nav_f ul li{ height:40px; line-height:40px; float:left; display:inline; width:110px; text-align:center;}
.nav_f ul li a{ color:#FFFFFF; height:40px;  display:block; text-decoration:none;}
.nav_f ul li a:hover{ text-decoration:none; background:url(images/navf_bg.gif) no-repeat center;}
.shouye a{ background:url(images/navf_bg.gif) center no-repeat;}
.banner_down{ position:relative; top:450px;  z-index:100; width:100%; margin:0 auto;  left:280px;}
.yzdl a:hover{ background:none;}
#khd{ width:100%; height:auto; background: #FFFFFF;min-width:1004px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.khd{ margin:0 auto; width:1004px; height:350px; text-align:center; padding-top:45px;}
#jzyz{ width:100%; height:598px; background:url(images/banner3_bg.jpg) center top no-repeat #B6BDB6; min-width:1004px;width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.jzyz{ margin:0 auto; width:1004px; background:url(images/banner3_bg_n.jpg) center no-repeat top;}
.jzyz_l{ float:left; display:inline;  height:auto; margin-top:30px; margin-left:80px;}
/*选项卡*/
#TabTab03Con1{ clear:both;width:490px; height:398px; padding-top:50px; text-align:left;}
#TabTab03Con2{ clear:both;width:490px; height:398px;padding-top:50px;text-align:left;}
#bg{ background:url(images/yzd_bg.gif) no-repeat; width:369px; height:120px; float:left; display:inline; line-height:120px;margin-left:30px;}
.tab1{ float:left; display:inline; font-size:50px; color:#000000; margin-left:50px;}
.tab2{ float:right; display:inline; font-size:35px; color:#FFFFFF; margin-right:25px;}
.tab3{ float:right; display:inline; font-size:50px; color:#000000; margin-right:50px;}
.tab4{ float:left; display:inline; font-size:35px; color:#FFFFFF; margin-left:25px;}
/*选项卡*/
.yzd_title{ font-size:30px; color:#FFFFFF;
height:30px;}
.yzd_nr{ font-size:18px; color:#FFFFFF; line-height:35px; font-family:"微软雅黑"; font-weight:lighter; height:140px;}
.hx{ color:#FFFFFF; font-size:2px;  margin-top:15px; margin-bottom:15px;}
.jzjz_r{ float:right; display:inline; margin-right:90px; margin-top:120px; width:239px; height:382px; overflow:hidden;}
#pyts{ height:560px; width:100%; overflow:hidden;min-width:1004px;width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.pyts{ margin:0 auto; width:1004px;}
.pyts_l{ float:left; display:inline; padding-left:0px; padding-top:0px; margin-top:0px;  width:470px; height:560px; }
.pyts_r{ float:right; display:inline; padding-top:100px; text-align:left;  width:530px;}
.pyts_title{ color:#000000; font-size:35px;  font-family:"微软雅黑"; line-height:40px; }
.pytj_c p{ margin-top:30px; margin-bottom:30px; }
.pytj_c{ color:#333333; font-size:20px; font-family::"微软雅黑"; line-height:30px;}
#dn{ width:100%; height:499px; background:url(images/six.jpg) no-repeat center #886C5E;min-width:1004px;width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.dn{ width:1004px; margin:0 auto; height:499px;}
.dn_l{ float:left; display:inline; padding-left:89px; padding-top:147px; width:420px; height:265px;}
.dn_r{ float:right; display:inline; margin-right:30px; margin-top:110px; width:380px; height:auto; text-align:left;}
.dn_title{ color:#FFFFFF; line-height:80px; font-family:"微软雅黑"; font-size:30px; border-bottom:1px solid #FFFFFF; font-stretch:narrower;}
.dn_c{ width:380px; color:#DFDFDF; line-height:40px; font-size:18px;font-family:"微软雅黑"; margin-top:15px; font-weight:normal;}
#msjr{ width:100%; height:300px;min-width:1004px;width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.msjr{ width:1004px; text-align:center; margin:0 auto;}
.msjr_top{ height:55px; margin-top:50px; margin-bottom:25px;}
.msjr_bottom{ width:100%; font-size:20px; font-family:Arial, Helvetica, sans-serif; text-align:center;}
.msjr_bottom_j{ margin:0 auto; width:600px; height:auto;}
.msjr_bottom_l{ background:url(images/he_bg.gif) center top no-repeat; float:left; display:inline; width:300px;}
.sz{ color:#FFFFFF; line-height:100px;}
.sz_b{ color:#000000; line-height:60px;}
.msjr_bottom_r{ float:left; display:inline; background:url(images/orange_bg.gif) center top no-repeat; width:300px;}
#footer{ background: #2d9a9b url(images/footer_bg.gif) top center no-repeat; height:530px; width:100%; font-family:"微软雅黑"; min-width:1004px;width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");}
.footer{ width:1004px; margin:0 auto; height:auto;}
.footer_l{ width:310px; float:left; display:inline; height:auto; margin-top:50px; }
.footer_title{ background:url(images/line.gif) bottom left no-repeat; line-height:60px; color:#FFFFFF; font-family:"微软雅黑"; font-size:33px;}
.footer_c{ color:#FFFFFF; font-size:13px; line-height:25px; margin-top:35px; width:310px;}
.footer_r{ width:322px; float:left; display:inline; height:auto; margin-top:50px; margin-left:60px;}
.footer_ly{ background:url(images/liuyan.gif) top center no-repeat; width:322px;  margin-top:35px;}
#footer_bottom{ width:100%;min-width:1004px;width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":""); background:url(images/footer_bg_tm.png) repeat; height:65px; line-height:65px; margin-top:15px;}
.footer_bottom{ clear:both; color:#FFFFFF; font-size:12px;  font-weight:normal; margin:0 auto; width:1004px; height:65px;}
.footer_bottom a{ color:#CCCCCC; text-decoration:none;}
.a_cc {
    position: fixed;
    bottom: 30px;
    right:10px;
    z-index: 500;
}
.f_right{ float:right; display:inline;}
.clear{ clear:both;}
.jzyz_nb ul li{ float:left; display:inline; margin:10px 16px; }
.none {display:none;}
.shubiaoshou{ cursor:pointer;}
/*手机焦点图*/
.bannerbox { width: 239px; height: 382px; overflow: hidden; margin: 0px auto; }
#focus { width: 239px; height: 382px; clear: both; overflow: hidden; position: relative; float: left; }
    #focus ul { width: 239px; height: 382px; float: left; position: absolute; clear: both; padding: 0px; margin: 0px; }
        #focus ul li { float: left; width: 239px; height: 382px; overflow: hidden; position: relative; padding: 0px; margin: 0px; }
    /*#focus .preNext { width: 150px; height: 120px; position: absolute; top: 0px; cursor: pointer; }*/
    /*#focus .pre { left: 0; background: url(../images/sprite.png) no-repeat left center; }*/
    /*#focus .next { right: 0; background: url(../images/sprite1.png) no-repeat right center; }*/
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
</style>

<div class="banner" id="banner">
	<a  class="d1" style=" background:url(images/banner1.jpg) center no-repeat #767772; "></a>
	<a  class="d1" style=" background:url(images/banner2.jpg) center no-repeat #67554b; "></a>
	<a  class="d1" style=" background:url(images/banner3.jpg) center no-repeat #0d428e; "></a>
    <div class="nav">
    <div class="nav_m">
    <div class="logo"><img src="images/logo.png" /></div>
    <div class="nav_f">
    <ul>
    <li class="shouye"><a href=<?php echo SiteCom::$site_url."index" ?>>首&nbsp;&nbsp;&nbsp;页</a></li>
        <li><a href=<?php echo SiteCom::$site_url."sqhz" ?>>申请合作</a></li>
        <li><a href=<?php echo SiteCom::$site_url."sybz" ?>>使用帮助</a></li>
        <li><a href=<?php echo SiteCom::$site_url."gywm" ?>>关于我们</a></li>
        <li><a href=<?php echo SiteCom::$site_url."lxwm" ?>>联系我们</a></li>
        <li><a href=<?php echo SiteCom::$site_url."zxns" ?>>招贤纳士</a></li>
        <li  ><a style="background:url(images/yzdl_bg.gif) center no-repeat; width:120px; height:40px;" href="index.php?r=manage/class" >园长登陆</a></li>
    </ul>
    </div>
    </div>
    </div>
    <div class="banner_down"><!--<a href="#"><img src="images/banner_download.gif" /></a>--></div>
	<div class="d2" id="banner_id">
		<ul>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>

<script type="text/javascript">banner()</script>
<div id="khd">
<script type="text/javascript">
function mouseOver1()
{document.getElementById('khd3').src ="images/jz_down.gif"
document.getElementById('khd1').src ="images/yz_down_over.gif"
document.getElementById('khd2').src ="images/js_down.gif"
}

function mouseOver2()
{
	document.getElementById('khd1').src ="images/yz_down.gif"
document.getElementById('khd2').src ="images/js_down_over.gif"
document.getElementById('khd3').src ="images/jz_down.gif"
}

function mouseOver3()
{document.getElementById('khd2').src ="images/js_down.gif"
	document.getElementById('khd1').src ="images/yz_down.gif"
document.getElementById('khd3').src ="images/jz_down_over.gif"
}

</script>
<Div class="download_tips" id="download_tips">
<div class="" style="float:left;width:70%;padding:1em 0 0 1em;">
如果没有跳转到下载页面，您可能使用了新版本的微信.<p>
点击右上角的跳转按钮，选择在浏览器中打开，然后即可下载
</div>
<div class="" style="float:right;"><img src="images/zhishi_xiazai.png" /></div>
<div class="" style="float:right;"><img src="images/open_in_web.png" /></div>
</Div>
 <Div class="alpha_bg" id="download_tips2" onclick="this.style.display='none';document.getElementById('download_tips').style.display= 'none';"></Div>

<div class="khd"><a onmouseover="mouseOver1()"  href="<?php if($if_wx){?>javascript:display_tips()<?php }else{ echo SiteCom::$download_url.'headmast'; }?>"><img src="images/yz_down_over.gif" id="khd1" /></a><a onmouseover="mouseOver2()"  href="<?php if($if_wx){?>javascript:display_tips()<?php }else{ echo SiteCom::$download_url.'teacher'; }?>"><img  style="margin:0 50px;" src="images/js_down.gif" id="khd2" /></a><a onmouseover="mouseOver3()"  href="<?php if($if_wx){?>javascript:display_tips();<?php }else{ echo SiteCom::$download_url.'parent'; }?>"><img src="images/jz_down.gif" id="khd3" /></a></div>
</div>
<div id="jzyz">
<div class="jzyz">
<div class="jzyz_l">
	<div id="bg" class="xixi1" style="cursor:pointer;">
		<div id="font1" class="tab1" onMouseOver="setTab03Syn(1);document.getElementById('bg').className='xixi1'">园长端</div>
		<div id="font2" class="tab2" onMouseOver="setTab03Syn(2);document.getElementById('bg').className='xixi2'">家长</div>
	</div>
    <div id=TabTab03Con1>
    <script type="text/javascript">
function nTabs(thisObj,Num){
if(thisObj.className == "active")return;
var tabObj = thisObj.parentNode.id;
var tabList = document.getElementById(tabObj).getElementsByTagName("li");
for(i=0; i <tabList.length; i++)
{
  if (i == Num)
  {
   thisObj.className = "active";
      document.getElementById(tabObj+"_Content"+i).style.display = "block";
  }else{
   tabList[i].className = "normal";
   document.getElementById(tabObj+"_Content"+i).style.display = "none";
  }
}
}
</script>
<div id="myTab0_Content0">
    <div class="yzd_title">打造园所品牌</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">家园桥通过家园互动的方式，让家长了解幼儿在幼儿园的一日生活，建立家园信任度，家长通过家园桥分享出去的照片，会署名幼儿园信息，无形中为幼儿园做了宣传，提升了园所影响力。</div>
 </div>

 <div id="myTab0_Content1" class="none">
    <div class="yzd_title">教师管理</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">随时随地掌握教师动态，轻松管理教师。指尖上的管理，让管理及时、有效、简单。</div>
 </div>
 <div id="myTab0_Content2" class="none">
    <div class="yzd_title">全园师生通讯录</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">群发、私聊沟通无极限</div>
 </div>
 <div id="myTab0_Content3" class="none">
    <div class="yzd_title">园务通知</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">发布园务信息，通知，让老师及时了解最新园所动态，不再错过园所重要通知。</div>
 </div>
 <div id="myTab0_Content4" class="none">
    <div class="yzd_title">园所网站，自动更新</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">通过家园桥发送的内容、照片会自动更新至网站，实现网站、手机客户端统一管理，自动更新，省时又省力！</div>
 </div>
 <div id="myTab0_Content5" class="none">
    <div class="yzd_title">家长教育</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">园长或老师可以将优秀文章、如育儿知识、家庭教育等精彩实用的文章分享给家长，加强家园沟通，强化家园共育！</div>
 </div>
 <div id="myTab0_Content6" class="none">
    <div class="yzd_title">精彩分享</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">随时记录精彩瞬间，分享给家长，加强家园互动。</div>
 </div>
 <div id="myTab0_Content7" class="none">
    <div class="yzd_title">点评孩子</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">宝宝月评价、学期总结，关心每一位宝宝，建立良好的家园共育。</div>
 </div>
 <div id="myTab0_Content8" class="none">
    <div class="yzd_title">贴心助手</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">随时倾听家长的声音，及时解决家长的问题，提升园所在家长心中的信任度，形成良好的口碑。</div>
 </div>
    <div class="jzyz_nb"><ul id="myTab0">
    <li class="active" onmouseover="nTabs(this,0);"><img class="shubiaoshou" src="images/yzd001.png" width="60" height="60" /></li>
    <li class="normal " onmouseover="nTabs(this,1);"><img class="shubiaoshou" src="images/yzd002.png" width="60" height="60" /></li>
    <li class="normal " onmouseover="nTabs(this,2);"><img class="shubiaoshou" src="images/yzd003.png" width="60" height="60" /></li>
    <li class="normal " onmouseover="nTabs(this,3);" style="margin-right:130px;"><img class="shubiaoshou" src="images/yzd004.png" width="60" height="60" /></li>
    <li class="normal " onmouseover="nTabs(this,4);"><img class="shubiaoshou" src="images/yzd005.png" width="60" height="60" /></li>
    <li class="normal " onmouseover="nTabs(this,5);"><img class="shubiaoshou" src="images/yzd006.png" width="60" height="60" /></li>
    <li class="normal " onmouseover="nTabs(this,6);"><img class="shubiaoshou" src="images/yzd007.png" width="60" height="60" /></li>
    <li class="normal " onmouseover="nTabs(this,7);"><img class="shubiaoshou" src="images/yzd008.png" width="60" height="60" /></li>
    <li class="normal " onmouseover="nTabs(this,8);"><img class="shubiaoshou" src="images/yzd009.png" width="60" height="60" /></li>
    </ul></div>


    </div>
	<div id=TabTab03Con2 style="display:none">





<script type="text/javascript">
function lnTabs(thisObjl,lNum){
if(thisObjl.className == "active")return;
var ltabObj = thisObjl.parentNode.id;
var ltabList = document.getElementById(ltabObj).getElementsByTagName("li");
for(i=0; i <ltabList.length; i++)
{
  if (i == lNum)
  {
   thisObjl.className = "active";
      document.getElementById(ltabObj+"_Content"+i).style.display = "block";
  }else{
   ltabList[i].className = "normal";
   document.getElementById(ltabObj+"_Content"+i).style.display = "none";
  }
}
}
</script>


 <div id="lmyTab1_Content0">
    <div class="yzd_title">宝宝月评价</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">随时了解宝宝当月在幼儿园的表现，每月一评价，看到宝宝进步的点滴。
教师通过宝宝月评价点评宝宝在幼儿园一月的表现，并将评价推送给家长，增强家园互动，家长可及时了解每月宝宝成长情况。
</div>
 </div>


<div id="lmyTab1_Content1" class="none">
    <div class="yzd_title">宝宝学期总结</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">宝宝一学期在幼儿园的表现，收获，通过宝宝学期总结及时查看，了解宝宝学期变化，加强家园互动，增加家长对幼儿园的信任度。</div>
 </div>

 <div id="lmyTab1_Content2" class="none">
   <div class="yzd_title">今天宝宝在幼儿园过得怎么样</div>
    <div class="hx"><img src="images/xian.gif" width="410" height="2" /></div>
    <div class="yzd_nr">家园桥，记录孩子成长的点点滴滴。随时随地关注宝宝在幼儿园一天的生活状态、学习情况，图文并茂，更加直观的关注宝宝的一日生活。消除宝宝不在身边的焦虑。查看宝宝在幼儿园的精彩瞬间，搭建家园信任平台。</div>
 </div>
 <div id="lmyTab1_Content3" class="none">
    <div class="yzd_title">成长历程</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">发宝宝每天的精彩瞬间、每月的成长记录、每学期的改变形成了时光轴，在这里，可以看到宝宝成长的脚步，是一本有爱的宝宝成长"日记"，记录点滴童年精彩。</div>
 </div>
 <div id="lmyTab1_Content4" class="none">
    <div class="yzd_title">直通车</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">家长的疑问、建议、意见可随时通过直通车与园长进行私密沟通，帮助您解决问题，更加密切的加强了家园的互动。</div>
 </div>
 <div id="lmyTab1_Content5" class="none">
    <div class="yzd_title">班级通知</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">随时查看班级通知，了解班级情况。不再错过重要的事情。</div>
 </div>
 <div id="lmyTab1_Content6" class="none">
    <div class="yzd_title">学习育儿、养儿、教儿的知识</div>
    <div class="hx"><img src="images/xian.gif" width="410" height="2" /></div>
    <div class="yzd_nr">随时学习教育宝宝的知识，解决在教育中的难题，助您培养优秀的宝宝。</div>
 </div>
 <div id="lmyTab1_Content7" class="none">
    <div class="yzd_title">一键分享</div>
    <div class="hx"><img src="images/xian.gif" /></div>
    <div class="yzd_nr">无论是看到精彩的文章，还是想要晒宝宝当天在幼儿园精彩的瞬间，都可以一键分享至微信朋友圈，一键分享，让分享无障碍！</div>
 </div>

    <div class="jzyz_nb">
    <ul id="lmyTab1">
    <li class="active" onmouseover="lnTabs(this,0);"><img class="shubiaoshou" src="images/jzd001.gif" width="60" height="60" /></li>
    <li class="normal" onmouseover="lnTabs(this,1);"><img class="shubiaoshou" src="images/jzd002.gif" width="60" height="60" /></li>
    <li class="normal" onmouseover="lnTabs(this,2);"><img class="shubiaoshou" src="images/jzd003.gif" width="60" height="60" /></li>
    <li class="normal" onmouseover="lnTabs(this,3);" style="margin-right:130px;"><img class="shubiaoshou" src="images/jzd004.gif" width="60" height="60" /></li>
    <li class="normal" onmouseover="lnTabs(this,4);"><img class="shubiaoshou" src="images/jzd005.gif" width="60" height="60" /></li>
    <li class="normal" onmouseover="lnTabs(this,5);"><img class="shubiaoshou" src="images/jzd006.gif" width="60" height="60" /></li>
    <li class="normal" onmouseover="lnTabs(this,6);"><img class="shubiaoshou" src="images/jzd007.gif" width="60" height="60" /></li>
    <li class="normal" onmouseover="lnTabs(this,7);"><img class="shubiaoshou" src="images/jzd008.gif" width="60" height="60" /></li>

    </ul>


    </div>
</div>

</div>
<div class="jzjz_r">
<!--<img src="images/shouji.jpg" width="239" height="382" />-->
<div class="bannerbox">
  <div id="focus">
        <ul>
            <li>
                <img src="images/shouji.jpg" alt="" width="239px" height="382px;" /></li>
            <li>
                <img src="images/shouji.jpg" alt=""width="239px" height="382px;" /></li>
            <li>
                <img src="images/shouji.jpg" alt=""width="239px" height="382px;" /></li>

        </ul>
    </div>
</div></div>

</div>
</div>
<div id="pyts">
<div class="pyts">
<div class="pyts_l"><img src="images/five.png" /></div>
<div class="pyts_r"><span class="pyts_title">与朋友、同事分享</span><br/>
<span style=" height:40px;"><img src="images/black_g.gif" /><br/></span>
<span class="pytj_c"><p>分享文章给指定家长或老师，让老师和家长共同进步。</p></span>
<span class="pytj_c"><p>随时捕捉孩子的精彩瞬间，直接上传到云端，家长随时查看。</p></span>
<span class="pytj_c"><p>照片一键分享到微信 微博，让每一个家长都成为幼儿园品牌的传播者。</p></span>
<span class="pytj_c"><p>家长与老师、园长直接沟通，意见反馈更精准。</p></span>
</div>
</div>
</div>
<div id="dn">
<div class="dn">
<div class="dn_l"><img src="images/bjb.jpg" /></div>
<div class="dn_r">
<div class="dn_title">十三项功能、让您轻松维护</div>
<div class="dn_c">班级管理、教师管理、家长管理、园所管理<br/>
食谱管理、照片标签、课程管理、待审图片<br/>
待审文章、导航管理、文章管理、添加文章<br/>
相册管理</div>
</div>
</div>
</div>
<div id="msjr">
<div class="msjr">
<script type="text/javascript">
function mouseOver()
{
document.getElementById('djjr').src ="/images/jr_over.gif"
}
function mouseOut()
{
document.getElementById('djjr').src ="/images/jr.gif"
}
</script>
<div class="msjr_top" ><a onmouseover="mouseOver()" onmouseout="mouseOut()" href=<?php echo SiteCom::$site_url."sqhz" ?>><img src="images/jr.gif" id="djjr" /></a></div>
<div class="msjr_bottom">
<div class="msjr_bottom_j">
<div class="msjr_bottom_l"><span class="sz">10000+<br/></span>
<span class="sz_b">10000名园长的选择</span>
</div>
<div class="msjr_bottom_r"><span class="sz">300万+<br/></span>
<span class="sz_b">300万家长已加入</span>
</div>
</div>
</div>
</div>
</div>
<div id="footer" style="background: #2d9a9b url(images/footer_bg.gif) top center no-repeat;height:530px;min-width:1004px;

width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1004?"1004px":"");"
>
<div class="footer">
<div class="footer_l">
<div class="footer_title">联系我们</div>
<div class="footer_c">公司名称：发现教育<br/>
地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：河南省安阳市文峰大道90号供销社大楼五楼<br/>
邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编：455000<br/>
电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话：0372-3682447 3682449<br/>
传&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;真：0372-3682441<br/>
<img style="margin-top:50px;" src="images/logo.png" />
</div>
</div>
<div class="footer_l">
<div class="footer_title">愿景</div>
<div class="footer_c">我们的愿景<br/>
&nbsp;&nbsp;&nbsp;&nbsp;成为中国幼儿教育行业的第一分享平台。<br/>
<p>家园桥的使命：成为园长的贴心助手、随身秘书；
让家长园长更方便沟通，记录孩子的成长。</p>
<br/>
家园桥的价值观：<br/>
&nbsp;&nbsp;&nbsp;• 以用户的需求为导向不懈创新<br/>
&nbsp;&nbsp;&nbsp;• 象重视生命一样重视每一个执行细节<br/>
&nbsp;&nbsp;&nbsp;• 象救火一样快速响应，搞定每一个问题<br/>

</div>
</div>
<div class="footer_r f_right">
<div class="footer_title">留言</div>
<div class="footer_ly"><table width="320" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td width="2"></td>
    <td width="125" style="line-height:20PX; padding-top:5px; padding-left:10px;">  <form id="form1" name="form1" method="post" action="">
      <label>
      <input name="textfield" type="text" id="textfield" value="姓名/园所名称" onFocus="if (value =='姓名/园所名称'){value =''}" onBlur="if (value ==''){value='姓名/园所名称'}"  style="background:#257c7d; border:0px; width:120px; height:25px; color:#FFFFFF; "/>
        </label>
    </form>  </td>
       <td width="155" style="padding-top:5px; padding-left:20px;"><form id="form1" name="form1" method="post" action="">
      <label>
          <input name="textfield" type="text" id="textfield" value="QQ" onFocus="if (value =='QQ'){value =''}" onBlur="if (value ==''){value='QQ'}"  style="background:#257c7d; border:0px; width:140px; height:25px; color:#FFFFFF;"/>
        </label>
    </form></td>
  </tr>
  <tr>
    <td colspan="4" style="padding-left:15px; padding-top:10px;"><form id="form1" name="form1" method="post" action="">
      <label>
          <input name="textfield" type="text" id="textfield" value="联系电话"  onFocus="if (value =='联系电话'){value =''}" onBlur="if (value ==''){value='联系电话'}" style="background:#257c7d; border:0px; width:270px; height:25px; color:#FFFFFF;"/>
        </label>
    </form></td>
    </tr>
  <tr>
    <td colspan="4" style="padding-left:10px; padding-top:25px;"><form id="form1" name="form1" method="post" action="">
      <label>
          <input name="textfield" type="text" id="textfield" value="正文留言"  onFocus="if (value =='正文留言'){value =''}" onBlur="if (value ==''){value='正文留言'}" style="background:#257c7d; border:0px; width:300px; height:120px; color:#FFFFFF; text-align:left;"/>
        </label>
    </form></td>
    </tr>
  <tr>
    <td colspan="3" style="padding-top:25px;"><input style="background:url(images/tjfooter.gif) top center no-repeat; border:0px; width:321px; height:50px;" name="" type="button" value=""/></td>
      </tr>
</table>
</div>
</div>
<br style="clear:both;"/>
</div>

<div id="footer_bottom">
<div class="footer_bottom"style="position:relative; "><div style="position:absolute; z-index:100;  bottom:-20px;"><a style="color:#3d8889;" href="index.php?r=Admin/admins/login" target="_blank">隐藏</a></div>
    <?= $this->render('foot') ?>
</div>
</div>
</div>

<div class="a_cc">
<table style=" background:#FFFFFF;cursor:pointer;border:#666666 1px solid; text-align:center;" width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="45" height="40" style="border-bottom::#666666 1px solid; line-height:12px; padding-top:5px;"><a onclick='window.scrollTo(0,0);'>返回<br/>顶部</a></td>
  </tr>
  <tr>
    <td style="border-top:#666666 1px solid;" width="45" height="45"><a href="tencent://message/?uin=2324887026&Site=在线QQ&Menu=yes"><img src="images/qq.jpg" /></a></td>
  </tr>
</table>

</div>

</body>
</html>