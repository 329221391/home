<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\model\CustomsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'school_id') ?>

    <?= $form->field($model, 'class_id') ?>

    <?= $form->field($model, 'cat_default_id') ?>

    <?= $form->field($model, 'catalogue_des_id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'name_zh') ?>

    <?php // echo $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'ip_last') ?>

    <?php // echo $form->field($model, 'ispassed') ?>

    <?php // echo $form->field($model, 'isdeleted') ?>

    <?php // echo $form->field($model, 'isout') ?>

    <?php // echo $form->field($model, 'isstar') ?>

    <?php // echo $form->field($model, 'iscansend') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'updatetime') ?>

    <?php // echo $form->field($model, 'starttime') ?>

    <?php // echo $form->field($model, 'endtime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
