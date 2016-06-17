<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>家园桥</title>
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
        function display_tips() {
            alert('asdasdas');
            document.getElementById('download_tips').style.display = 'block';
        }
        document.getElementById('download_tips').onClick = function () {
            this.style.display = 'none';
        };
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
    * {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
    a, img {
        border: 0;
    }
    body {
        font-family: "微软雅黑";
    }
    .a_jia a {
        color: #FFF;
        list-style-type: none;
        text-decoration: none;
    }
    .width_load {
        width: 60%; /*max-width:701px; width:expression((document.documentElement.clientWidth||document.body.clientWidth)>701?"701px":""*/
    );
        margin-top: 30px;
    }
    @media (min-width: 640px) {
        .tel {
            font-size: 30px;
            margin-right: 15%;
        }
        .b_lianjie {
            font-size: 16px;
        }
        .logo_left {
            margin-left: 15%;
            float: left;
            display: inline;
        }
    }
    @media (min-width: 460px) and (max-width: 639px) {
        .tel {
            font-size: 20px;
            margin-right: 15%;
        }
        .b_lianjie {
            font-size: 13px;
        }
        .logo_left {
            margin-left: 15%;
            float: left;
            display: inline;
        }
    }
    @media (min-width: 330px) and (max-width: 459px) {
        .tel {
            font-size: 12px;
            margin-right: 15%;
        }
        .b_lianjie {
            font-size: 10px;
        }
        .logo_left {
            margin-left: 15%;
            float: left;
            display: inline;
        }
    }
    @media (min-width: 200px) and (max-width: 329px) {
        .tel {
            font-size: 12px;
            margin-right: 5%;
        }
        .b_lianjie {
            font-size: 10px;
        }
        .logo_left {
            margin-left: 5%;
            float: left;
            display: inline;
        }
    }
</style>
<Div class="download_tips" id="download_tips">
    <div class="" style="float:left;width:70%;padding:1em 0 0 1em;">
        如果没有跳转到下载页面，您可能使用了新版本的微信.<p>
            点击右上角的跳转按钮，选择在浏览器中打开，然后即可下载
    </div>
    <div class="" style="float:right;"><img src="zhishi_xiazai.png"/></div>
    <div class="" style="float:right;"><img src="open_in_web.png"/></div>
</Div>
<div style="height:70px; line-height:70px; background:#28cacc; width:100%; text-align:center;><span class=" logo_left
"><a href="http://www.jyq365.com/"><img src="logo1.png"
                                                style="  margin-top:5px; line-height:80px;"/></a></span></div>
<div style="background:#7fcdec; text-align:center;">
    <a href="<?php if ($if_wx) { ?>javascript:display_tips();<?php } else { ?>/download/hbj.apk<?php } ?>"><img
            class="width_load" src="jz_zj.jpg"/></a>
    <a href="<?php if ($if_wx) { ?>javascript:display_tips()<?php } else { ?>/download/hbm.apk<?php } ?>"><img
            class="width_load" src="yz_zj.jpg"/></a>
    <a href="<?php if ($if_wx) { ?>javascript:display_tips()<?php } else { ?>/download/hbt.apk<?php } ?>"><img
            class="width_load" src="js_zj.jpg" style="margin-bottom:30px;"/></a>
</div>
<div><img src="jyq_zj.jpg" width="100%"/></div>
<div style="text-align:center; background:#e73462;"><a href="http://www.jyq365.com/index.php?r=site/sqhz"><img
            src="jrwm_zj.jpg" width="65%" style=" max-width:807px;  margin-top:35px; margin-bottom:35px;"/></a>
</div>
<div class="a_jia"
     style="text-align:center; background:#e73462; border-top:#FFF 2px dotted; color:#FFF; font-size:14px;">
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
