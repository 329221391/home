<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>幼儿园图片分享</title>
    <style type="text/css">
        <!--
        .share_title {
            background-color: #28cacc;
            line-height: 2em;
            color: #FFFFFF;
            text-indent: 1em;
            padding-top: 0.5em;
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
        .limit_width {
            max-width: 600px;
            min-width: 300px;
        }
        .pic_title {
            width: 95%;
            margin-top: 0px;
            margin-right: auto;
            margin-bottom: 0px;
            margin-left: auto;
        }
        .school_info {
            font-size: 0.7em;
            line-height: 2em;

        }
        .pic_content {
            width: 95%;
            margin-top: 0px;
            margin-right: auto;
            margin-bottom: 6em;
            margin-left: auto;
            padding-top: 2em;
        }
        .tel_btn {
            position: fixed;
            width: 100%;
            background-color: #28cacc;
            color: #FFFFFF;
            bottom: 0px;
            font-size: 0.8em;
            text-align: center;
            padding: 0.5em 0px;
        }
        .outer {
            position: relative;
        }
        .deal_num {
            position: fixed;
            background-color: #28cacc;
            color: #FFFFFF;
            bottom: 0.5em;
            right: 1em;
            font-size: 0.8em;
            text-align: center;
        }
        -->
    </style>
</head>
<body>
<div class="outer">
    <div class="share_title"> 这是我家孩子的照片
        <div class="school_info">
            <?= $school_info['name'] ?>
            >>
            <?= $article['createtime'] ?>
        </div>
    </div>
    <div class="pic_title limit_width">
        <div class="pic_content limit_width">
            <div class=""><img src="<?= $article['url'] ?>" style="width:100%;"/></div>
        </div>
    </div>
    <div class="tel_btn">
        <?= $school_info['name'] ?><br/>
        电话：<?= $school_info['phone'] ?><br/>
        地址：<?= $school_info['address'] ?><br/>
    </div>
    <div class="deal_num">
        <a href="tel:<?= $school_info['tel'] ?>"><img src="images/share_tel.png"/></a>
    </div>
</body>
</html>
