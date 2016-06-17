<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\model\Classes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="classes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'school_id')->textInput() ?>

    <?= $form->field($model, 'teacher_id')->textInput() ?>

    <?= $form->field($model, 'subteacher1_id')->textInput() ?>

    <?= $form->field($model, 'subteacher2_id')->textInput() ?>

    <?= $form->field($model, 'cat_default_id')->textInput() ?>

    <?= $form->field($model, 'catalogue_des_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'namenick')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'ispassed')->textInput() ?>

    <?= $form->field($model, 'isdeleted')->textInput() ?>

    <?= $form->field($model, 'isgraduated')->textInput() ?>

    <?= $form->field($model, 'isout')->textInput() ?>

    <?= $form->field($model, 'isstar')->textInput() ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'updatetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
