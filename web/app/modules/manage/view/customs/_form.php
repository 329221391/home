<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\model\Customs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'school_id')->textInput() ?>

    <?= $form->field($model, 'class_id')->textInput() ?>

    <?= $form->field($model, 'cat_default_id')->textInput() ?>

    <?= $form->field($model, 'catalogue_des_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'name_zh')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'ip_last')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'ispassed')->textInput() ?>

    <?= $form->field($model, 'isdeleted')->textInput() ?>

    <?= $form->field($model, 'isout')->textInput() ?>

    <?= $form->field($model, 'isstar')->textInput() ?>

    <?= $form->field($model, 'iscansend')->textInput() ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'updatetime')->textInput() ?>

    <?= $form->field($model, 'starttime')->textInput() ?>

    <?= $form->field($model, 'endtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
