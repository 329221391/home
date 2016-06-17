<?php
use app\modules\AppBase\base\HintConst;
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>家长端</title>
    <script language="JavaScript"> 
    function display_tips(){
         document.getElementById('download_tips').style.display= 'block';
         document.getElementById('download_tips2').style.display= 'block';
    }
    </script>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        html {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
            font-size: 14px;
            height: 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        ul, li, dl, dt, dd {
            margin: 0;
            padding: 0;
            font-weight: normal;
            list-style: none;
        }

        .clearfix {
            overflow: hidden;
        }

        .main {
            width: 100%;
            position: relative;
        }

        .top {
            width: 100%;
            position: relative;
        }

        .head {
            background-color: #f74877;
            width: 100%;
            /*max-width: 720px ;*/
            height: 54px;
            min-height: 54px;
            padding-top: 4px;
            padding-bottom: 0;
        }

        .info {
            width: 320px;
            height: 50px;
            margin: 0 auto;

        }

        .icon {
            width: 320px;
            height: 50px;
            margin: 0 auto;
        }

        .icon img {
            width: 320px;
            height: 50px;

        }

        footer {
            /*position: absolute;*/
            position: relative;
            margin: 0 auto;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            background-color: #28cacc;
        }
        .download{
        	position: relative;
            margin: 0 auto;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            background-color: #28cacc;
        }
        .footerdiv1 {
            position: relative;
            width: 100%;
            height: auto;
            text-align: center;
        }

        /*a.test {
            margin: 0 auto;
            text-align: center;
            width: 60%;
            height: auto;
        }*/

        img.test {
            width: 80%;
            height: auto;
            margin: auto auto 5% auto;
        }


        .intros {
            width: 100%;
            height: auto;
            z-index: -1;
        }

        .intros img {
            width: 100%;
            height: auto;
        }

        .btg {
            width: 100%;
            height: auto;
            position: relative;
        }

        .btg_jz {
            background-color: #28cacc;
            width: 100%;
            height: auto;
            padding-top: 1px;
            padding-bottom: 20px;
        }

        .btg_js {
            background-color: #ff99b3;
            width: 100%;
            height: auto;
            padding-top: 1px;
            padding-bottom: 20px;
        }

        .btg_yz {
            background-color: #f74877;
            width: 100%;
            height: auto;
            padding-top: 1px;
            padding-bottom: 20px;
        }

        .bgm img {
            width: 100%;
            height: auto;
            position: relative;
        }

        .button img{
            width: 100px;
            height: 107px;
            margin: 20px;
        }

        .login {
            min-width: 22%;
            max-width: 22%;
            height: 100%;
            margin: -155% auto 126% auto;
            margin-left: 38.2%;
        }

        .login img {
            width: 100%;
            height: auto;
        }

        li {
            padding: 15px 10px;
            line-height: 1.5em;
            border-bottom: #e8e8e8 1px solid;
            color: #333;
        }

        input {
            position: inherit;
            top: 10px;
            left: 20px;
        }

        .download_tips {
            background-color: #FFFFFF;
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            width: 100%;
            padding-bottom: 1em;
            padding-left: 1em;
            display: none;
        }

        .alpha_bg {
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
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
    </style>
</head>
<body>
<Div class="download_tips" id="download_tips" style="z-index:1000;position:fixed;">
    <div class="" style="float:left;width:70%;padding:1em 0 0 1em;">
        如果没有跳转到下载页面，您可能使用了新版本的微信.<p>
        点击右上角的跳转按钮，选择在浏览器中打开，然后即可下载
    </div>
    <div class="" style="float:right;"><img src="images/img/zhishi_xiazai.png"/></div>
    <div class="" style="float:right;"><img src="images/img/open_in_web.png"/></div>
</Div>
<Div class="alpha_bg" id="download_tips2"
     onClick="this.style.display='none';document.getElementById('download_tips').style.display= 'none';document.getElementById('download_tips').style.display= 'none';"></Div>
<div style="width:100%; float:right; display:inline; position:fixed; top:60px; right:8px; z-index:50; text-align:right;">
    <a href="javascript:void(0);"
       onclick="javascript:document.getElementsByTagName('BODY')[0].scrollTop=document.getElementsByTagName('BODY')[0].scrollHeight;"><img
            style="width:50px;" src="images/img/down.png"/></a></div>
<div class="main">
    <div class="top">
        <div class="head">
            <div class="info clearfix">
                <div class="icon">
                    <a href="<?=HintConst::$WEB_JYQ?>"> <img src="images/img/icon.png"></a>
                </div>
            </div>
        </div><!-- head结束 -->
        <div class="download">
	        <div class="footerdiv1 clearfix">
		        <div class="button">
		            <a href="<?php if($if_wx){?>javascript:display_tips();<?php }else{ ?>/download/hbj.apk<?php }?>"><img class="test" src="images/img/btn_part_a.png"></a>
		            <a href="<?php if($if_wx){?>javascript:display_tips();<?php }else{ ?>https://itunes.apple.com/us/app/jia-yuan-qiao-jia-zhang-ban/id1054312332?l=zh&ls=1&mt=8<?php }?>"><img class="test" src="images/img/btn_part_i.png"></a>
		        </div>
	    	</div>
        </div>
        <div class="btg_jz">
            <div id="intros1" class="intros">
                <img src="images/img/bbmjz.jpg">

                <div class="login">
                    <a href="javascript:void(0);"
                        onclick="javascript:document.getElementsByTagName('BODY')[0].scrollTop=document.getElementsByTagName('BODY')[0].scrollHeight;"><img src="images/img/butten01.png"></a>
                </div>
            </div><!-- intros结束 -->
        </div><!-- btg_jz结束 -->
    </div><!-- top结束 -->
</div><!-- main结束 -->


</body>
</html>