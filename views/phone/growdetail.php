<?php
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\SiteCom;

?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content=" initial-scale=1.0,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<link href="css/css_white.css" rel="stylesheet" type="text/css">
<title>历程详情</title>
<head>
</head>
<body>
<div class="z_title">历程详情</div>
<div id="ms_top"><a href="javascript:history.go(-1);" target="_self"><img class="f_sy"
                                                                                        src="images/back_0.png"></a>
</div>
<div class="top_60"></div>
<div class="detail_title"><span class="title_blue"><?= Yii::$app->session['custominfo']->custom->name_zh ?></span>小朋友<span
        class="title_blue"><?= CommonFun::getsubdate($art_detail->createtime) ?></span>在校的情况
</div>
<div class="detail_colume">
    <div class="colume_title"><?= SiteCom::getArticleType($art_detail->article_type_id) ?></div>
    <?php foreach ($art_detail->att_list as $k => $v) {
        ?>
        <div class="colume_img"><img id="img" name="<?= $v->article_id . ',' . $v->id ?>"
                                     src="<?= SiteCom::getImgUrl($v->url) ?>"></div>
    <?php } ?>
    <div class="colume_col"><?= $art_detail->contents ?></div>
</div>
<div style="width:100%; height:50px;"></div>
<?php if ($art_detail->article_type_id == HintConst::$HIGHLIGHT_PATH_NEW) { ?>
    <input id="add_favor" type="button" class="growdtail_bm" value="收藏">
<?php } ?>
</body>
</html>
<script language="javascript">
    $("#add_favor").click(function () {
        var a = $("#img").attr('name').split(',');
        $.post('index.php?r=Articles/articles/add-fav', {
            article_id: a[0],
            article_att_id: a[1]
        }, function (result) {
            if (result['ErrCode'] == "0") {
                alert(result['Message']);
            } else {
                alert(result['Message']);
            }
        }, "json");
    });
</script>