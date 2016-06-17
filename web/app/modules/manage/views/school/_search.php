<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\model\SchoolsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schools-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cat_default_id') ?>

    <?= $form->field($model, 'catalogue_des_id') ?>

    <?= $form->field($model, 'headmaster_id') ?>

    <?= $form->field($model, 'creater_id') ?>

    <?php // echo $form->field($model, 'creater_name') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'starttime') ?>

    <?php // echo $form->field($model, 'endtime') ?>

    <?php // echo $form->field($model, 'ispassed') ?>

    <?php // echo $form->field($model, 'isdeleted') ?>

    <?php // echo $form->field($model, 'isout') ?>

    <?php // echo $form->field($model, 'zh_province_id') ?>

    <?php // echo $form->field($model, 'zh_citie_id') ?>

    <?php // echo $form->field($model, 'zh_district_id') ?>

    <?php // echo $form->field($model, 'address') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
