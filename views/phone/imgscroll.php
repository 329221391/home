<?php

?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content=" initial-scale=1.0,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<link href="css/common.css" rel="stylesheet" type="text/css"/>
<link href="css/css_white.css" rel="stylesheet" type="text/css"/>
<title>家园桥家长端图片详情</title>
<style type="text/css">
    .index_img {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        text-align: center;
        font-size: 0;
    }
    .img_return {
        width: 100%;
        height: 3rem;
        background: url(images/img_bg.png);
        line-height: 3rem;
        color: #FFFFFF;
        text-align: center;
        font-size: 1.5rem;
        position: fixed;
        z-index: 5;
        top: 0;
    }
    .img_return a {
        color: #FFFFFF;
    }
    .img404 {
        border: 0;
        width: 100%;
        vertical-align: middle;
    }
    .verticalAlign {
        vertical-align: middle;
        display: inline-block;
        height: 100%;
        width: 1px;
        margin-left: -1px;
    }
</style>
<head></head>
<body style="background:#CCCCCC;">
<div class="img_return"><a href="javascript:history.go(-1);">点击返回</a></div>
<div class="index_img"><span class="verticalAlign"></span><img class="img404" src="<?= $img_url ?>"/></div>
</body>
</html>
