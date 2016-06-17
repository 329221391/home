<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Logs\models\LogsClassesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logs-classes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'catalogue_id') ?>

    <?= $form->field($model, 'describe') ?>

    <?= $form->field($model, 'action') ?>

    <?= $form->field($model, 'table_name') ?>

    <?php // echo $form->field($model, 'table_id') ?>

    <?php // echo $form->field($model, 'field') ?>

    <?php // echo $form->field($model, 'before') ?>

    <?php // echo $form->field($model, 'after') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'updatetime') ?>

    <?php // echo $form->field($model, 'ispassed') ?>

    <?php // echo $form->field($model, 'isdeleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
