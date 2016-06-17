<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\RedFl\models\RedFlSerach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="red-fl-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'author_tpye_id') ?>

    <?= $form->field($model, 'rd_type_id') ?>

    <?= $form->field($model, 'sub_type_id') ?>

    <?php // echo $form->field($model, 'for_someone_id') ?>

    <?php // echo $form->field($model, 'contents') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
