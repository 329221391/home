<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Logs\models\LogsClasses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logs-classes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'before')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'after')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
