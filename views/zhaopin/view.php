<?php
use yii\helpers\Html;
$this->context->layout='mobile_layout';
$this->title = '招聘详情';
?>
<?= Html::cssFile('@web/css/mobile/zhaosheng.css') ?>
<div class="header">
    <div class="title">招聘详情</div>
    <div class="btn-right">
        <a class="btn btn-success" href="index.php?r=zhaopin/post&id=<?=$id ?>">我要报名</a>
    </div>
</div>
<div class="light_bg padding">
    <div style="height:50px;"></div>
    <div>
        <h3><?= $zhaopin['title'] ?></h3>
        <div style="color:#9c9c9c;"><?=date('Y-m-d',$zhaopin['create_time']) ?> &nbsp;&nbsp;<span style="color:#5f80a4;"><?=$zhaopin['school_name'] ?></span></div>
        <div style="color:#9c9c9c;margin-top:10px;">地址 <?=$zhaopin['province'] ?><?=$zhaopin['city'] ?><?=$zhaopin['district'] ?><?=$zhaopin['address'] ?></div>
        <div style="color:#9c9c9c;">报名电话 <?=$zhaopin['post_phone']?></div>
    </div>
    <hr>
    <div class="content">
        <?= $zhaopin['content'] ?>
    </div>
    <!--<div style="color:#9c9c9c;margin-top:30px;">
        阅读 <?=$zhaopin['view_times']?> &nbsp;&nbsp;已报名 <?=$zhaopin['post_count']?>
    </div>-->

</div>
<div style="height:80px;"></div>
<div class="footer-pink">
    <div>
        <ul class="school_info">
            <li><?= $school['name']?></li>
            <li>电话:<a href="tel:<?= $zhaopin['post_phone']?>"><?= $zhaopin['post_phone']?></a></li>
        </ul>
    </div>
</div>