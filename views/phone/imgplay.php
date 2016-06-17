<?php
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\SiteCom;
$att_list = $today[0]->att_list;
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
				.index_img{width:100%; height:100%; position:absolute; left:0; top:0; text-align:center; font-size:0;}
			.img_return{ width:100%; height:9rem; background:url(images/img_bg.png); line-height:9rem; color:#FFFFFF; text-align:center; font-size:1.5rem; position:fixed; z-index:5; bottom:0;}
			.img_return {color:#FFFFFF;}
			.img404{ border:0; width:100%; vertical-align:middle;}        
		 .verticalAlign{ vertical-align:middle; display:inline-block; height:100%; width:1px; margin-left:-1px;}
		 </style>
<head></head>
<body style="background:#CCCCCC;">
<a href="javascript:history.go(-1);"><div class="img_return">点击返回</div></a>
<div class="index_img"> <span class="verticalAlign"></span>
<?php foreach ($att_list as $k => $v) {
                $host = str_replace('http://', '', Yii::$app->request->getHostInfo());
                $url = str_replace($host, '', $v->url);
                ?>
<img class="img404" src="<?=$img_url?>"  />
<?php
            }
?>
</div>
</body>
</html>
