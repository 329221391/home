<?php
use yii\helpers\Html;
$this->context->layout='mobile_layout';
$this->title = '报名详情';
?>
<?= Html::cssFile('@web/css/mobile/zhaosheng.css') ?>
<div class="header">

    <div class="title">报名详情</div>
    <div class="btn-left">
        <a style="color:#ffffff;font-size: 25px;" href="javascript:history.go(-1)">＜</a>
    </div>
</div>
<div class="light_bg padding">
    <div style="height:50px;"></div>
    <table class="table table-striped">
        <tr>
            <th>姓名</th>
            <th>年龄</th>
            <th>联系电话</th>
        </tr>
        <?php  foreach($post_list as $key=>$post_item) {?>
            <tr>
                <td><?=$post_item['person_name']?></td>
                <td><?=$post_item['age']?></td>
                <td><?=$post_item['mobile']?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div style="height:80px;"></div>
