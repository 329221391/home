<?php
use yii\helpers\Html;
$this->context->layout='mobile_layout';
$this->title = '提交成功';
?>
<?= Html::cssFile('@web/css/mobile/zhaosheng.css') ?>
<style>

</style>
<div class="header">
    <div class="title">提交成功</div>
</div>

<div class="padding">
    <div style="height:50px;"></div>
    <div class="success">
        <div>完成</div>
    </div>
    <div style="text-align: center;color:#5e5e5e">
        感谢您的提交
    </div>
</div>