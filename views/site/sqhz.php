<?php
use app\modules\AppBase\base\SiteCom;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="x-ua-compatible" content="IE=edge, chrome=1">
<title>申请合作 - 家园桥</title>
<meta name="keywords" content="家园桥，幼儿园，宝宝，园长，家长，幼儿教育，幼儿，管理教师，管理幼儿园，联系家长，联系老师，移动秘书,发现教育，图片分享，宝宝评价，园所宣传"/>
<meta Name="description" Content="家园桥，园长端，家长端，教师端，幼儿园，宝宝，今日动态，打电话，成长历程，吃饭情况，课程设置，园所信息" />
<script type="text/javascript" src="js/alert.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<script type="text/javascript">
    function banner() {
        var bn_id = 0;
        var bn_id2 = 1;
        var speed33 = 5000;
        var qhjg = 1;
        var MyMar33;
        $("#banner .d1").hide();
        $("#banner .d1").eq(0).fadeIn("slow");
        if ($("#banner .d1").length > 1) {
            $("#banner_id li").eq(0).addClass("nuw");
            function Marquee33() {
                bn_id2 = bn_id + 1;
                if (bn_id2 > $("#banner .d1").length - 1) {
                    bn_id2 = 0;
                }
                $("#banner .d1").eq(bn_id).css("z-index", "2");
                $("#banner .d1").eq(bn_id2).css("z-index", "1");
                $("#banner .d1").eq(bn_id2).show();
                $("#banner .d1").eq(bn_id).fadeOut("slow");
                $("#banner_id li").removeClass("nuw");
                $("#banner_id li").eq(bn_id2).addClass("nuw");
                bn_id = bn_id2;
            };
            MyMar33 = setInterval(Marquee33, speed33);
            $("#banner_id li").click(function () {
                var bn_id3 = $("#banner_id li").index(this);
                if (bn_id3 != bn_id && qhjg == 1) {
                    qhjg = 0;
                    $("#banner .d1").eq(bn_id).css("z-index", "2");
                    $("#banner .d1").eq(bn_id3).css("z-index", "1");
                    $("#banner .d1").eq(bn_id3).show();
                    $("#banner .d1").eq(bn_id).fadeOut("slow", function () {
                        qhjg = 1;
                    });
                    $("#banner_id li").removeClass("nuw");
                    $("#banner_id li").eq(bn_id3).addClass("nuw");
                    bn_id = bn_id3;
                }
            })
            $("#banner_id").hover(
                function () {
                    clearInterval(MyMar33);
                },
                function () {
                    MyMar33 = setInterval(Marquee33, speed33);
                }
            )
        }
        else {
            $("#banner_id").hide();
        }
    }
</script>
<style type="text/css">
* {
    margin: 0;
    padding: 0;
    list-style-type: none;
}

a, img {
    border: 0;
}

body {
    font: 12px/180% "微软雅黑", Arial, Helvetica, sans-serif;
    margin-top: -20px;
}

.li {
    list-style-type: none;
}

.clear {
    clear: both;
}

.nav {
    top: 0;
    width: 100%;
    background: #28cacc;
    height: 90px;
    min-width: 1008px;
    width: expression((document.documentElement.clientWidth||document.body.clientWidth)<1008?"1008px":"");
}

.nav_m {
    width: 1008px;
    margin: 0 auto;
}

.logo {
    float: left;
    display: inline;
    margin-top: 18px;
    margin-left: 5px;
}

.cpon {
    display: block;
}

.mbon {
    display: block;
}

.cpnone {
    display: none
}

.mbnone {
    display: none
}

.nav_f {
    margin-top: 40px;
    float: right;
    display: inline;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: bolder;
    margin-right: 20px;
}

.nav_f ul li {
    height: 40px;
    line-height: 40px;
    float: left;
    display: inline;
    width: 110px;
    text-align: center;
}

.nav_f ul li a {
    color: #FFFFFF;
    height: 40px;
    display: block;
    text-decoration: none;
}

.nav_f ul li a:hover {
    text-decoration: none;
    background: url(images/navf_bg.gif) no-repeat center;
}

.shouye a {
    background: url(images/navf_bg.gif) center no-repeat;
}

.yzdl a {
    background: url(images/yzdl_bg.gif) center no-repeat;
}

#n_zt {
    width: 100 &;
    height: auto;
    background: #dcdcdc;
    min-width: 1008px;
    width: expression((document.documentElement.clientWidth||document.body.clientWidth)<1008?"1008px":"");
}

.n_zt {
    width: 1008px;
    margin: 0 auto;
    height: auto;
    padding-top: 15px;
    padding-bottom: 5px;
}

.n_ztjia {
    clear: both;
    float: left;
    display: inline;
    width: 1208px;
}

.n_zt_top {
    background: url(images/ntop_bg1.gif) top center no-repeat;
    height: 3px;
    width: 1008px;
}

.n_zt_middle {
    height: auto;
    background: url(images/nmiddle_bg1.gif) center repeat-y;
    width: 1008px;
    height: auto;
    float: left;
    display: inline;
}

.n_zt_bottom {
    background: url(images/nbottom_bg1.gif) center bottom no-repeat;
    width: 1008px;
    height: 18px;
}

#n_footer {
    width: 100%;
    height: 70px;
    background: #4b6364;
    min-width: 1008px;
    width: expression((document.documentElement.clientWidth||document.body.clientWidth)<1008?"1008px":"");
}

.n_footer {
    margin: 0 auto;
    width: 1008px;
    color: #FFFFFF;
    line-height: 70px;
}

.n_footer a {
    text-decoration: none;
    color: #FFFFFF;
}

.n_zt_middle_left {
    height: auto;
    width: 249px;
    float: left;
    display: inline;
    margin-left: 3px;
}

.n_zt_middle_left ul li {
    height: 80px;
    width: 249px;
    border-bottom: #dcdcdc 1px solid;
    line-height: 80px;
    text-align: left;
}

.n_zt_middle_left a {
    color: #a0a0a0;
    font-size: 20px;
    font-family: "微软雅黑";
    font-weight: lighter;
    text-decoration: none;
    height: 80px;
    width: 249px;
    display: block;
}

.n_hover a {
    color: #000000;
    font-weight: bolder;
    background: url(images/nnav_hover1.gif) no-repeat center;
}

.n_zt_middle_right {
    float: left;
    display: inline;
    height: auto;
    width: 748px;
    font-family: "微软雅黑";
}

.z_title {
    height: 80px;
    border-bottom: #dcdcdc 1px solid;
    width: 750px;
    line-height: 80px;
    font-size: 20px;
    font-weight: bolder;
}

.z_content {
    font-size: 16px;
    color: #000000;
    line-height: 25px;
    padding: 25px;
    height: auto;
    float: left;
    display: inline;
}

p {
    margin-top: 15px;
    margin-bottom: 15px;
}

.z_content_title {
    width: 100%;
    line-height: 40px;
    height: auto;
    width: auto;
    text-align: center;
}

.z_content_js {
    font-size: 16px;
    float: left;
    text-indent: 25px;
    width: 240px;
    display: inline;
    padding-left: 0px;
}

.z_content_bg {
    float: left;
    display: inline;
    width: 450px;
    background: url(images/n_bg_bg.gif) center top no-repeat;
    height: 500px;
    min-width: 450px;
}

.a_left {
    margin-left: 40px;
}

/*下面是手机版的样式*/
* {
    margin: 0;
    padding: 0;
    list-style-type: none;
}

a, img {
    border: 0;
}

body {
    font: 12px "微软雅黑", Arial, Helvetica, sans-serif;
    background: #fff;
}

.li {
    list-style-type: none;
}

.clear {
    clear: both;
}

.m_nav {
    line-height: 90px;
    height: 90px;
    text-align: center;
    background: #28cacc;
    width: 100%;
    min-width;
    400px;
}

.m_foot {
    background: #4b6364;
    height: 70px;
    text-align: center;
    line-height: 70px;
    width: 100%;
    color: #FFF;
    min-width;
    400px;
}

.m_z_content_title {
    width: 100%;
    line-height: 40px;
    height: auto;
    text-align: center;
    min-width;
    400px;
}

.m_z_content_js {
    font-size: 16px;
    text-align: left;
    text-indent: 25px;

    display: inline;
    margin: 0 auto;
    min-width;
    400px;
}

.m_content {
    height: auto;
    margin: 0 auto;
    text-align: center;
}

.m_z_content_bg {
    width: 100%;
    background: url(images/n_bg_bg_zengjia.gif) center top no-repeat;
    height: 500px;
    text-align: center;
    min-width;
    400px;
}

.m_z_content_bg_ctl {
    width: 100%;
    background: fff;
    height: 500px;
    text-align: center;
}

#cp {
    display: block;
}

#mb {
    display: none;
    width: 100%;
    min-width: 400px;
}

/*控制的样式*/
/*@media screen and (min-width: 1008px) {
 #mb {
 display: none;!important;
}
}
 @media screen and (max-width: 1007px) {
 #cp {
 display: none;!important;
}
}*/
</style>
<script language="javascript">
    function widthtext() {
        //平台、设备和操作系统   
var system ={  
win : false,  
mac : false,  
xll : false  
};  
//检测平台   
var p = navigator.platform;  
system.win = p.indexOf("Win") == 0;  
system.mac = p.indexOf("Mac") == 0;  
system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);  
//跳转语句   
if(system.win||system.mac||system.xll){ //转向电脑端 

document.getElementById('cp').style.display = "block";
document.getElementById('mb').style.display = "none";
}else{  
document.getElementById('cp').style.display = "none";
document.getElementById('mb').style.display = "block";
}
}
</script>
</head>
<body onload="widthtext();">
<!--电脑端-->
<div id="cp">
    <div class="nav">
        <div class="nav_m">
            <div class="logo"><img src="images/logo.png"/></div>
            <div class="nav_f">
                <ul>
                    <li><a href=<?php echo SiteCom::$site_url . "index" ?>>首&nbsp;&nbsp;&nbsp;页</a></li>
                    <li class="shouye"><a href=<?php echo SiteCom::$site_url . "sqhz" ?>>申请合作</a></li>
                    <li><a href=<?php echo SiteCom::$site_url . "sybz" ?>>使用帮助</a></li>
                    <li><a href=<?php echo SiteCom::$site_url . "gywm" ?>>关于我们</a></li>
                    <li><a href=<?php echo SiteCom::$site_url . "lxwm" ?>>联系我们</a></li>
                    <li><a href=<?php echo SiteCom::$site_url . "zxns" ?>>招贤纳士</a></li>
                    <li><a style="background:url(images/yzdu_fen_bg.gif) no-repeat center;width:120px;"
                           href="index.php?r=manage/class">园长登陆</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="n_zt">
        <div class="n_zt">
            <div class="n_zt_top"></div>
            <div class="n_zt_middle">
                <div class="n_zt_middle_left">
                    <ul>
                        <li class="n_hover"><a href=<?php echo SiteCom::$site_url . "sqhz" ?>><span
                                    class="a_left">申请合作</span></a></li>
                        <li><a href=<?php echo SiteCom::$site_url . "sybz" ?>><span class="a_left">使用帮助</span></a></li>
                        <li><a href=<?php echo SiteCom::$site_url . "gywm" ?>><span class="a_left">关于我们</span></a></li>
                        <li><a href=<?php echo SiteCom::$site_url . "lxwm" ?>><span class="a_left">联系我们</span></a></li>
                        <li><a href=<?php echo SiteCom::$site_url . "zxns" ?>><span class="a_left">招贤纳士</span></a></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <div class="n_zt_middle_right">
                    <div class="z_title"><span class="a_left">申请合作</span></div>
                    <div class="z_content">
                        <div class="z_content_title"><span
                                style="font-size:25px; font-weight:bolder;">新园所接入申请</span><br/>
              <span
                  style="font-size:14px; color:#999999;">审批流程(提交申请——安装使用)</span></div>
                        <div class="z_content_js">
                            <p>1，功能优势，行业领先幼教互动云平台，园长互联网思维，全力支持幼儿园移动信息化建设，助力园所品牌建设。</p>
                            <br/>

                            <p>2，团队优势。国内幼教行业领军品牌，幼儿园管理精英团队，全力帮您打造园所核心竞争力，塑造园所品牌。</p>
                            <br/>

                            <p>3，更新优势。产品研发团队深入园所管理一线，与幼儿园直接沟通，了解园所所需，有效及时更新，为新一轮教育信息化竞争加速！</p>
                        </div>
                        <div class="z_content_bg" style="background:url(images/n_bg_bglow.gif) no-repeat center top;">
                            <table style=" margin-left:50px; " width="400" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="382">
                                        <table width="0" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="160" height="70"><input id="school_name"
                                                                                   style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:160px; height:40px; line-height:40px;"
                                                                                   name="" type="text" value="园所名称"
                                                                                   onFocus="if (value =='园所名称'){value =''}"
                                                                                   onBlur="if (value ==''){value='园所名称'}"/>
                                                </td>
                                                <td width="35">&nbsp;</td>
                                                <td width="157"><input id="qq"
                                                                       style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:160px; height:40px; line-height:40px;"
                                                                       name="" type="text" value="QQ"
                                                                       onFocus="if (value =='QQ'){value =''}"
                                                                       onBlur="if (value ==''){value='QQ'}"/></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="400" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="127" height="49"><SELECT id=city1 name=city1 
                                                                                    style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:90px; height:40px; line-height:40px;"
                                                                                    type="text">
                                                        <OPTION value="" selected>所在省</OPTION>
                                                    </SELECT></td>
                                                <td width="125"><SELECT id=city2 name=city2 
                                                                        style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:95px; height:40px; line-height:40px;">
                                                        <OPTION value="" selected>所在市</OPTION>
                                                    </SELECT></td>
                                                <td width="148"><SELECT id=city3 name=city3 
                                                                        style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:95px; height:40px; line-height:40px;">
                                                        <OPTION value="" selected>所在县</OPTION>
                                                    </SELECT></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="75"><input id="address"
                                                           style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:350px; height:40px; line-height:40px;"
                                                           name="" type="text" value="街道地址"
                                                           onFocus="if (value =='街道地址'){value =''}"
                                                           onBlur="if (value ==''){value='街道地址'}"/></td>
                                </tr>
                               <tr>
                                    <td height="40"><input id="tel"
                                                           style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:350px; height:40px; line-height:40px;"
                                                           name="" type="text" value="园所电话"
                                                           onFocus="if (value =='园所电话'){value =''}"
                                                           onBlur="if (value ==''){value='园所电话'}"/></td>
                                </tr>
								<tr>
                                    <td style=" height:35px;"></td>
                                </tr>
                                <tr>
                                    <td><input id="headmast_name"
                                               style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:350px; height:40px; line-height:40px;"
                                               name="" type="text" value="园长姓名" onFocus="if (value =='园长姓名'){value =''}"
                                               onBlur="if (value ==''){value='园长姓名'}"/></td>
                                </tr>
                                <tr>
                                    <td height="77"><input id="headmast_phone"
                                                           style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:350px; height:40px; line-height:40px;"
                                                           name="" type="text" value="园长手机"
                                                           onFocus="if (value =='园长手机'){value =''}"
                                                           onBlur="if (value ==''){value='园长手机'}"/></td>
                                </tr>
                            </table>
                            <form style="margin-left:30px; margin-top:5px; display:inline;" id="form1" name="form1"
                                  method="post" action="">
                                <label><input id="submit" style="background:url(images/n_bg_tj.gif) top center no-repeat; border:0px; width:383px; height:53px;"type="button" /></label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both;" class="n_zt_bottom"></div>
            <br style="clear:both;"/>
        </div>
    </div>
    <?= $this->render('foot') ?>
    </div>
</div>
<!--手机端-->
<div id="mb">
    <div class="m_nav"><a href=<?php echo SiteCom::$site_url . "index" ?>><img src="images/logo_zj.png"
                                                                               style="margin-top:10px;" width="160"
                                                                               height="55"/></a></div>
    <div class="m_content">
        <div class="m_z_content_title"><span style="font-size:25px; font-weight:bolder;">新园所接入申请</span><br/>
            <span style="font-size:14px; color:#999999;">审批流程(提交申请——安装使用)</span></div>
        <div class="m_z_content_js">
            <p>1，功能优势，行业领先幼教互动云平台，园长互联网思维，全力支持幼儿园移动信息化建设，助力园所品牌建设。</p>
            <br/>

            <p>2，团队优势。国内幼教行业领军品牌，幼儿园管理精英团队，全力帮您打造园所核心竞争力，塑造园所品牌。</p>
            <br/>

            <p>3，更新优势。产品研发团队深入园所管理一线，与幼儿园直接沟通，了解园所所需，有效及时更新，为新一轮教育信息化竞争加速！</p>
        </div>
        <div id="ctl_bg" class="m_z_content_bg" style="background:url(images/n_bg_bglow.gif) no-repeat center top;">
            <table style="margin:0 auto;" width="400" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="382">
                        <table width="0" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="160" height="70"><input id="school_name2"
                                                                   style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:160px; height:40px; line-height:40px; margin-left:25px;"
                                                                   name="" type="text" value="园所名称"
                                                                   onFocus="if (value =='园所名称'){value =''}"
                                                                   onBlur="if (value ==''){value='园所名称'}"/></td>
                                <td width="35">&nbsp;</td>
                                <td width="157"><input id="qq2"
                                                       style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:160px; height:40px; line-height:40px;"
                                                       name="" type="text" value="QQ"
                                                       onFocus="if (value =='QQ'){value =''}"
                                                       onBlur="if (value ==''){value='QQ'}"/></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="400" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="127" height="49"><SELECT id=city12
                                                                    name=city12
                                                                    style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:90px; height:40px; line-height:40px;"
                                                                    type="text">
                                        <OPTION value="" selected>所在省</OPTION>
                                    </SELECT></td>
                                <td width="125"><SELECT id=city22
                                                        name=city22
                                                        style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:95px; height:40px; line-height:40px;">
                                        <OPTION value="" selected>所在市</OPTION>
                                    </SELECT></td>
                                <td width="148"><SELECT id=city32 name=city32
                                                        style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:95px; height:40px; line-height:40px;">
                                        <OPTION value="" selected>所在县</OPTION>
                                    </SELECT></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="75"><input id="address2"
                                           style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:350px; height:40px; line-height:40px;"
                                           name="" type="text" value="街道地址" onFocus="if (value =='街道地址'){value =''}"
                                           onBlur="if (value ==''){value='街道地址'}"/></td>
                </tr>
                <tr>
                    <td height="40"><input id="tel2"
                                           style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:350px; height:40px; line-height:40px;"
                                           name="" type="text" value="园所电话" onFocus="if (value =='园所电话'){value =''}"
                                           onBlur="if (value ==''){value='园所电话'}"/></td>
                </tr>
<tr>
<td style=" height:35px;"></td>
</tr>
                <tr>
                    <td><input id="headmast_name2"
                               style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:350px; height:40px; line-height:40px;"
                               name="" type="text" value="园长姓名" onFocus="if (value =='园长姓名'){value =''}"
                               onBlur="if (value ==''){value='园长姓名'}"/></td>
                </tr>
                <tr>
                    <td height="77"><input id="headmast_phone2"
                                           style="background:#eeeeee; border:0px; color:#666666; font-size:16px; width:350px; height:40px; line-height:40px;"
                                           name="" type="text" value="园长手机" onFocus="if (value =='园长手机'){value =''}"
                                           onBlur="if (value ==''){value='园长手机'}"/></td>
                </tr>
            </table>
            <form style="margin-left:-10px; margin-top:5px;" id="form1" name="form1" method="post" action="">
                <label>
                    <input id="submit2"
                           style="background:url(images/n_bg_tj_zj.gif) top center no-repeat; border:0px; width:383px; height:53px;"
                           name="" type="button" value=""/>
                </label>
            </form>
        </div>
        <br style="clear:both;"/>
    </div>
    <div class="m_foot">Allrights Reserved</div>
</div>
</body>
</html>
<script language="javascript">
$(document).ready(function(){
    var zh_provines_id, zh_city_id;
    var provines_name = 'city1';
    var city_name = 'city2';
    var district_name = 'city3';
    $.getJSON('index.php?r=Schools/schools/provinceslist', function (data) {
        $("#" + provines_name + " option").remove();
        $.each(data, function (j, n) {
            $("#" + provines_name + "").append('<option value=' + n.id + '>' + n.name + '</option>');
        })
    });
    $("#" + provines_name + "").change(function () {
        zh_provines_id = $("#" + provines_name).val();
        $.getJSON('index.php?r=Schools/schools/citieslist&zh_provines_id=' + zh_provines_id, function (data1) {
            $("#" + city_name + " option").remove();
           // $("#" + city_name + "").append('<option value=0>所在市</option>');
            $.each(data1, function (i, m) {
                $("#" + city_name + "").append('<option value=' + m.id + '>' + m.name + '</option>');
            })
        });
        $("#" + city_name).change(function () {
            zh_city_id = $('#' + city_name).val();
            $.getJSON('index.php?r=Schools/schools/districtslist&zh_city_id=' + zh_city_id, function (data2) {
                $("#" + district_name + " option").remove();
             //   $("#" + district_name + "").append('<option value=0>所在县</option>');
                $.each(data2, function (ii, mm) {
                    $("#" + district_name + "").append('<option value=' + mm.id + '>' + mm.name + '</option>');
                })
            });
        });
    });
    $("#submit").click(function () {
        var name = $("#school_name").val();
        name = $.trim(name);
        var qq = $("#qq").val();
        qq = $.trim(qq);
        var zh_province_id = $("#city1").val();
        zh_province_id = $.trim(zh_province_id);
        var zh_citie_id = $("#city2").val();
        zh_citie_id = $.trim(zh_citie_id);
        var zh_district_id = $("#city3").val();
        zh_district_id = $.trim(zh_district_id);
/*        var email = $("#email").val();
        email = $.trim(email);*/
		var email = qq + "@qq.com";
        var tel = $("#tel").val();
        tel = $.trim(tel);
        var name_zh = $("#headmast_name").val();
        name_zh = $.trim(name_zh);
        var phone = $("#headmast_phone").val();
        phone = $.trim(phone);
        var address = $("#address").val();
        address = $.trim(address);
        var ltjqq = /^[1-9]\d{4,9}$/;
        var ltjmail = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/;
        var ltjtel = /^\d{6,15}$/;
		var ltjtell =/^0\d{2,3}-?\d{7,8}$/;
        var ltjphone = /^1\d{10}$/;
        if (name == "" || name == "园所名称") {
            alert("园所名称不能为空")
        }
        else if (name.length > 100) {
            alert("园所名称过长")
        }
        else if (qq == "" || qq == "QQ") {
            alert("QQ不能为空")
        }
        else if (!ltjqq.test(qq)) {
            alert("请输入正确的QQ号");

        }


        else if (zh_province_id == "" || zh_province_id == 0) {
            alert("所在省不能为空")
        } else if (zh_citie_id == "" || zh_citie_id == 0) {
            alert("所在市不能为空")
        } else if (zh_district_id == "" || zh_district_id == 0) {
            alert("所在县不能为空")
        }
        else if (address == "" || address == "街道地址") {
            alert("街道地址不能为空")
        }

        else if (address.length > 100) {
            alert("街道地址过长")
        }
/*        else if (email == "" || email == "Email") {
            alert("Email不能为空")
        }
        else if (!ltjmail.test(email)) {
            alert("请输入正确的Email号");

        }*/
        else if (tel == "" || tel == "园所电话") {
            alert("园所电话不能为空")
        }
        else if (!(ltjtel.test(tel) || ltjtell.test(tel))) {
            alert("请输入正确的园所电话号");
        }
        else if (phone == "" || phone == "园长手机") {
            alert("园长手机不能为空,申请成功无法通知到您")
        }
        else if (!ltjphone.test(phone)) {
            alert("请输入正确的园长手机号");
        }
        else if (name_zh == "" || name_zh == "园长姓名") {
            alert("园长姓名不能为空")
        }
        else if (name_zh.length > 100) {
            alert("请正确填写园长姓名")
        }
        else {document.getElementById("submit").style.backgroundImage="url(images/n_bg_tj1.gif)";
            $.get('index.php?r=Schools/schools/apply', {
                name: name,
                qq: qq,
                zh_province_id: zh_province_id,
                zh_citie_id: zh_citie_id,
                zh_district_id: zh_district_id,
                email: email,
                tel: tel,
                name_zh: name_zh,
                phone: phone,
                address: address
            }, function (result) {
				document.getElementById("submit").style.backgroundImage="url(images/n_bg_tj_zj.gif)";
                if (result == "对不起,您已经注册过了") {
				alert("您已经成功注册,请到首页下载客户端使用,开始使用吧!");}
           else if(result == "1")
		   {
			   //alert("感谢您注册家园桥，注册信息成功提交，我们会尽快进行审核！会在1个工作日内电话通知您。请保持手机畅通。客服qq：2324887026.感谢您的选择！")
			    sAlert("");
		   }

            }, "text");
        }
    });
	});
</script>
<script language="javascript">
    var zh_provines_id2, zh_city_id2;
    var provines_name2 = 'city12';
    var city_name2 = 'city22';
    var district_name2 = 'city32';
    $.getJSON('index.php?r=Schools/schools/provinceslist', function (data2) {
        $("#" + provines_name2 + " option").remove();
        $.each(data2, function (j, n) {
            $("#" + provines_name2 + "").append('<option value=' + n.id + '>' + n.name + '</option>');
        })
    });
    $("#" + provines_name2 + "").change(function () {
        zh_provines_id2 = $("#" + provines_name2).val();
        $.getJSON('index.php?r=Schools/schools/citieslist&zh_provines_id=' + zh_provines_id2, function (data1) {
            $("#" + city_name2 + " option").remove();
//            $("#" + city_name + "").append('<option value=0>所在市</option>');
            $.each(data1, function (i, m) {
                $("#" + city_name2 + "").append('<option value=' + m.id + '>' + m.name + '</option>');
            })
        });
        $("#" + city_name2).change(function () {
            zh_city_id2 = $('#' + city_name2).val();
            $.getJSON('index.php?r=Schools/schools/districtslist&zh_city_id=' + zh_city_id2, function (data2) {
                $("#" + district_name2 + " option").remove();
//                $("#" + district_name + "").append('<option value=0>所在县</option>');
                $.each(data2, function (ii, mm) {
                    $("#" + district_name2 + "").append('<option value=' + mm.id + '>' + mm.name + '</option>');
                })
            });
        });
    });
    $("#submit2").click(function () {
        var name2 = $("#school_name2").val();
        name2 = $.trim(name2);
        var qq2 = $("#qq2").val();
        qq2 = $.trim(qq2);
        var zh_province_id2 = $("#city12").val();
        zh_province_id2 = $.trim(zh_province_id2);
        var zh_citie_id2 = $("#city22").val().trim();
        zh_citie_id2 = $.trim(zh_citie_id2);
        var zh_district_id2 = $("#city32").val();
        zh_district_id2 = $.trim(zh_district_id2);
/*        var email2 = $("#email2").val();
        email2 = $.trim(email2);*/
		var email2 = qq2 + "@qq.com";
        var tel2 = $("#tel2").val();
        tel2 = $.trim(tel2);
        var name_zh2 = $("#headmast_name2").val();
        name_zh2 = $.trim(name_zh2);
        var phone2 = $("#headmast_phone2").val();
        phone2 = $.trim(phone2);
        var address2 = $("#address2").val();
        var ltjqq2 = /^[1-9]\d{4,9}$/;
        var ltjmail2 = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/;
        var ltjtel2 = /^\d{6,15}$/;
		var ltjtell2 = /^0\d{2,3}-?\d{7,8}$/;
        var ltjphone2 = /^1\d{10}$/;
        address2 = $.trim(address2);
        if (name2 == "" || name2 == "园所名称") {
            alert("园所名称不能为空")
        }
        else if (name2.length > 100) {
            alert("园所名称过长")
        }
        else if (qq2 == "" || qq2 == "QQ") {
            alert("QQ不能为空")
        }

        else if (!ltjqq2.test(qq2)) {
            alert("请输入正确的QQ号");

        }

        else if (zh_province_id2 == "" || zh_province_id2 == 0) {
            alert("所在省不能为空")
        } else if (zh_citie_id2 == "" || zh_citie_id2 == 0) {
            alert("所在市不能为空")
        } else if (zh_district_id2 == "" || zh_district_id2 == 0) {
            alert("所在县不能为空")
        }
        else if (address2 == "" || address2 == "街道地址") {
            alert("街道地址不能为空")
        }
        else if (address2.length > 100) {
            alert("街道地址过长")
        }
/*        else if (email2 == "" || email2 == "Email") {
            alert("Email不能为空")
        }

        else if (!ltjmail2.test(email2)) {
            alert("请输入正确的Email号");
        }*/
        else if (tel2 == "" || tel2 == "园所电话") {
            alert("园所电话不能为空")
        }
        else if (!(ltjtel2.test(tel2) || ltjtell2.test(tel2))) {
            alert("请输入正确的园所电话");
        }
        else if (phone2 == "" || phone2 == "园长手机") {
            alert("园长手机不能为空,申请成功无法通知到您")
        }
        else if (!ltjphone2.test(phone2)) {
            alert("请输入正确的园长手机号");
        }
        else if (name_zh2 == "" || name_zh2 == "园长姓名") {
            alert("园长姓名不能为空")
        }
        else if (name_zh2.length > 100) {
            alert("请正确填写园长姓名")
        }
        else {
		document.getElementById("submit").style.backgroundImage="url(images/n_bg_tj1.gif)";
            $.get('index.php?r=Schools/schools/apply', {
                name: name2,
                qq: qq2,
                zh_province_id: zh_province_id2,
                zh_citie_id: zh_citie_id2,
                zh_district_id: zh_district_id2,
                email: email2,
                tel: tel2,
                name_zh: name_zh2,
                phone: phone2,
                address: address2
            }, function (result) {
				document.getElementById("submit").style.backgroundImage="url(images/n_bg_tj_zj.gif)";
//			if (result != "") {
//                    alert(result);
//                }
if (result == "对不起,您已经注册过了") {
				alert("您已经成功注册,请到首页下载客户端使用,开始使用吧!");}
           else if(result == "1")
		   {
			   alert("感谢您注册家园桥，注册信息成功提交，您现在可以到首页下载客户端使用。客服qq：2324887026.感谢您的选择！")
			    //sAlert('');  
		   }

            }, "text");
        }
    });
</script>
