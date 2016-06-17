<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Logs\models\Logs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'catalogue_id')->textInput() ?>

    <?= $form->field($model, 'describe')->textInput(['maxlength' => 225]) ?>

    <?= $form->field($model, 'action')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'table_name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'table_id')->textInput() ?>

    <?= $form->field($model, 'field')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'before')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'after')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'updatetime')->textInput() ?>

    <?= $form->field($model, 'ispassed')->textInput() ?>

    <?= $form->field($model, 'isdeleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
