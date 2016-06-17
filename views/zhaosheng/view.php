<?php
use yii\helpers\Html;
$this->context->layout='mobile_layout';
$this->title = '招生详情';
?>
<?= Html::cssFile('@web/css/mobile/zhaosheng.css') ?>
<div class="header">
    <div class="title">招生详情</div>
    <div class="btn-right">
        <a class="btn btn-success" href="index.php?r=zhaosheng/post&id=<?=$id ?>">我要报名</a>
    </div>
</div>
<div class="light_bg padding">
    <div style="height:50px;"></div>
    <div>
        <h3><?= $zhaosheng['title'] ?></h3>
        <div style="color:#9c9c9c;"><?=date('Y-m-d',$zhaosheng['create_time']) ?> &nbsp;&nbsp;<span style="color:#5f80a4;"><?=$zhaosheng['school_name'] ?></span></div>
        <div style="color:#9c9c9c;margin-top:10px;">地址 <?=$zhaosheng['province'] ?><?=$zhaosheng['city'] ?><?=$zhaosheng['district'] ?><?=$zhaosheng['address'] ?></div>
        <div style="color:#9c9c9c;">报名电话 <?=$zhaosheng['post_phone']?></div>
    </div>
    <hr>
    <div class="content">
        <?= $zhaosheng['content'] ?>
    </div>
    <!--<div style="color:#9c9c9c;margin-top:30px;">
        阅读 <?=$zhaosheng['view_times']?> &nbsp;&nbsp;已报名 <?=$zhaosheng['post_count']?>
    </div>-->

</div>
<div style="height:80px;"></div>
<div class="footer-pink">
    <div>
        <ul class="school_info">
            <li><?= $school['name']?></li>
            <li>电话:<a href="tel:<?= $zhaosheng['post_phone']?>"><?= $zhaosheng['post_phone']?></a></li>
        </ul>
    </div>
</div>