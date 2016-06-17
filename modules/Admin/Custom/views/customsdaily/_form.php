<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Custom\models\Customsdaily */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customsdaily-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'custom_id')->textInput() ?>

    <?= $form->field($model, 'daily_type_id')->textInput() ?>

    <?= $form->field($model, 'daily_contents')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
