<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Classes\models\ClassesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="classes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'school_id') ?>

    <?= $form->field($model, 'teacher_id') ?>

    <?= $form->field($model, 'subteacher1_id') ?>

    <?= $form->field($model, 'subteacher2_id') ?>

    <?php // echo $form->field($model, 'cat_default_id') ?>

    <?php // echo $form->field($model, 'catalogue_des_id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'namenick') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'ispassed') ?>

    <?php // echo $form->field($model, 'isdeleted') ?>

    <?php // echo $form->field($model, 'isgraduated') ?>

    <?php // echo $form->field($model, 'isout') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'updatetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
