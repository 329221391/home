<?php use app\modules\AppBase\base\SiteCom; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>联系我们 - 家园桥</title>
	<meta name="keywords" content="家园桥，幼儿园，宝宝，园长，家长，幼儿教育，幼儿，管理教师，管理幼儿园，联系家长，联系老师，移动秘书,发现教育，图片分享，宝宝评价，园所宣传"/>
<meta Name="description" Content="家园桥，园长端，家长端，教师端，幼儿园，宝宝，今日动态，打电话，成长历程，吃饭情况，课程设置，园所信息" />
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
<!--
    <script language="JavaScript">
        function correctPNG() // correctly handle PNG transparency in Win IE 5.5 & 6.
        {
            var arVersion = navigator.appVersion.split("MSIE")
            var version = parseFloat(arVersion[1])
            if ((version >= 5.5) && (document.body.filters)) {
                for (var j = 0; j < document.images.length; j++) {
                    var img = document.images[j]
                    var imgName = img.src.toUpperCase()
                    if (imgName.substring(imgName.length - 3, imgName.length) == "PNG") {
                        var imgID = (img.id) ? "id='" + img.id + "' " : ""
                        var imgClass = (img.className) ? "class='" + img.className + "' " : ""
                        var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
                        var imgStyle = "display:inline-block;" + img.style.cssText
                        if (img.align == "left") imgStyle = "float:left;" + imgStyle
                        if (img.align == "right") imgStyle = "float:right;" + imgStyle
                        if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
                        var strNewHTML = "<span " + imgID + imgClass + imgTitle
                            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
                            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
                            + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"
                        img.outerHTML = strNewHTML
                        j = j - 1
                    }
                }
            }
        }
        window.attachEvent("onload", correctPNG);
    </script>
-->
    <!--<style type="text/css">
    *{margin:0;padding:0;list-style-type:none;}
    a,img{border:0;}
    body{font:12px/180% Arial, Helvetica, sans-serif, "新宋体";}
    .li{ list-style-type:none;}
    .clear{ clear:both;}
    .nav{top:0; width:100%; background:#28cacc;  height:90px;}
    .nav_m{ width:1208px; margin:0 auto;}
    .logo{ float:left; display:inline; margin-top:18px; margin-left:25px;}
    .nav_f{ margin-top:40px; float:right; display:inline; color:#FFFFFF; font-size:16px; font-weight:bolder; margin-right:20px;}
    .nav_f ul li{ height:40px; line-height:40px; float:left; display:inline; width:120px; text-align:center;}
    .nav_f ul li a{ color:#FFFFFF; height:40px;  display:block; text-decoration:none;}
    .nav_f ul li a:hover{ text-decoration:none; background:url(images/navf_bg.gif) no-repeat center;}
    .shouye a{ background:url(images/navf_bg.gif) center no-repeat;}
    .yzdl a{ background:url(images/yzdl_bg.gif) center no-repeat;}
    #n_zt{ width:100&; height:auto; background:#dcdcdc;}
    .n_zt{width:1208px; margin:0 auto; height:auto; padding-top:15px; padding-bottom:15px;}
    .n_ztjia{ clear:both; float:left; display:inline; width:1208px;}
    .n_zt_top{  background:url(images/ntop_bg.gif) top center no-repeat; height:5px; width:1208px;}
    .n_zt_middle{ height:auto; background:url(images/nmiddle_bg.gif) center repeat-y; width:1200px; height:auto;padding:0px 3px 0px 5px; float:left; display:inline;}
    .n_zt_bottom{ background:url(images/nbottom_bg.gif) center bottom no-repeat; width:1208px; height:25px; }
    #n_footer{ width:100%; height:70px; background:#4b6364;}
    .n_footer{ margin:0 auto; width:1208px; color:#FFFFFF; line-height:70px;}
    .n_footer a{ text-decoration:none; color:#FFFFFF;}
    .n_zt_middle_left{ height:auto; width:280px; float:left; display:inline;}
    .n_zt_middle_left ul li{ height:80px; width:280px; border-bottom:#dcdcdc 1px solid; line-height:80px; text-align:left; }
    .n_zt_middle_left a{ color:#a0a0a0; font-size:20px; font-family:"新宋体"; font-weight:lighter; text-decoration:none; height:80px; width:240px; display:block; padding-left:40px;}
    .n_hover a{color:#000000; font-weight:bolder; background:url(images/nnav_hover.gif) no-repeat center;}
    .n_zt_middle_right{float:left; display:inline; height:auto; width:919px; font-family:"新宋体";}
    .z_title{ height:80px; border-bottom:#dcdcdc 1px solid; width:879px; line-height:80px; font-size:20px; font-weight:bolder; padding-left:40px;}
    .z_content{ font-size:16px; color:#000000; line-height:25px; padding:25px; height:auto; float:left; display:inline;}
    p{ margin-top:15px; margin-bottom:15px;}
    </style>-->
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
margin-top:-20px;
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
        .a_left {
            margin-left: 40px;
        }
    </style>
</head>
<body>
<div class="nav">
    <div class="nav_m">
        <div class="logo"><img src="images/logo.png"/></div>
        <div class="nav_f">
            <ul>
                <li><a href=<?php echo SiteCom::$site_url . "index" ?>>首&nbsp;&nbsp;&nbsp;页</a></li>
                <li><a href=<?php echo SiteCom::$site_url . "sqhz" ?>>申请合作</a></li>
                <li><a href=<?php echo SiteCom::$site_url . "sybz" ?>>使用帮助</a></li>
                <li><a href=<?php echo SiteCom::$site_url . "gywm" ?>>关于我们</a></li>
                <li class="shouye"><a href=<?php echo SiteCom::$site_url . "lxwm" ?>>联系我们</a></li>
                <li><a href=<?php echo SiteCom::$site_url . "zxns" ?>>招贤纳士</a></li>
                <li><a style="background:url(images/yzdu_fen_bg.gif) no-repeat center;width:120px;" href="index.php?r=manage/class">园长登陆</a>
                </li>
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
                    <li><a href=<?php echo SiteCom::$site_url . "sqhz" ?>><span class="a_left">申请合作</span></a></li>
                    <li><a href=<?php echo SiteCom::$site_url . "sybz" ?>><span class="a_left">使用帮助</span></a></li>
                    <li><a href=<?php echo SiteCom::$site_url . "gywm" ?>><span class="a_left">关于我们</span></a></li>
                    <li class="n_hover"><a href=<?php echo SiteCom::$site_url . "lxwm" ?>><span
                                class="a_left">联系我们</span></a></li>
                    <li><a href=<?php echo SiteCom::$site_url . "zxns" ?>><span class="a_left">招贤纳士</span></a></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
            <div class="n_zt_middle_right">
                <div class="z_title"><span class="a_left">联系我们</span></div>
                <div class="z_content">
                    <table width="0" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="2">地　　址：文峰大道90号供销社大楼五楼<br/>
                                邮　　编：455000<br/>
                                传　　真：0372-3682441<br/>
                                客服电话：0372-3682447 3682449<br/>
                                客服QQ：2324887026<br/>
                                E-mail：1361202195@qq.com
                            </td>
                        </tr>
                        <tr>
                            <td width="447"><p>北京<br/>
                                    电话： 010-58679035<br/>
                                    地址： 北京市朝阳区劲松桥富顿中心d座1605 
</p>

                                <p>安阳<br/>
                                    电话： 0372-3682447 3682449<br/>
                                    地址： 文峰大道90号供销社大楼五楼
</p>

                                <p>郑州<br/>
                                    电话： 0371-55658442<br/>
                                    地址： 郑州市经三路与农科路交叉口向西20米路南金城国际商务309室
</p></td>
                            <td width="293"><p>&nbsp;</p>

                                <p>济南<br/>
                                    地址： 山东省济南市天桥区翡翠郡南区30号楼1707
</p>

                                <p>长沙<br/>
                                    电话： 0731-84729023<br/>
                                    地址：湖南省长沙市芙蓉区五一大道98号省商务厅二号楼4楼412室
</p></td>
                        </tr>
                    </table>
                    <p><br/>
                    </p>
                </div>
            </div>
        </div>
        <div style="clear:both;" class="n_zt_bottom"></div>
        <br style="clear:both;"/>
    </div>
</div>
<?= $this->render('foot') ?>
</body>
</html>