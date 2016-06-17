<?php
$this->context->layout='empty';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="viewport" content="initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>奖品详情</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/mobile/base.css" rel="stylesheet">
    <link href="/css/mobile/zhaosheng.css" rel="stylesheet">
    <link href="/css/mobile/prize.css" rel="stylesheet">
</head>
<body>
<div class="header" style="z-index: 9999">
    <div class="title">奖品详情</div>
</div>

<div class="padding">
    <div style="height:50px;"></div>

    <div style="padding:10px; ">
        <?php foreach($goods_list as $item){?>
            <div class="prize_item" style="background: #fff; margin-bottom:10px;">
                <div class="prize_panel">
                    <img src="<?=$item['image'] ?>" style="height:75px;width:75px;" />
                    <div class="info">
                        <div><b style="font-size:16px;"><?=$item['goods_name'] ?></b></div>
                        <div>品牌:<?=$item['brand'] ?></div>
                        <div>用途:<?=$item['purpose'] ?></div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>
</body>
</html>