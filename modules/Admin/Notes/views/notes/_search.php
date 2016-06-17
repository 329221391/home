<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Notes\models\NotesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pri_type_id') ?>

    <?= $form->field($model, 'sub_type_id') ?>

    <?= $form->field($model, 'school_id') ?>

    <?= $form->field($model, 'class_id') ?>

    <?php // echo $form->field($model, 'custom_id') ?>

    <?php // echo $form->field($model, 'for_someone_id') ?>

    <?php // echo $form->field($model, 'user_tpye_id') ?>

    <?php // echo $form->field($model, 'author_id') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'contents') ?>

    <?php // echo $form->field($model, 'thumb') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'starttime') ?>

    <?php // echo $form->field($model, 'endtime') ?>

    <?php // echo $form->field($model, 'ispassed') ?>

    <?php // echo $form->field($model, 'issend') ?>

    <?php // echo $form->field($model, 'isdelete') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
