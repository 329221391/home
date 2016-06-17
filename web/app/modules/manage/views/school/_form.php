<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\model\Schools */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schools-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat_default_id')->textInput() ?>

    <?= $form->field($model, 'catalogue_des_id')->textInput() ?>

    <?= $form->field($model, 'headmaster_id')->textInput() ?>

    <?= $form->field($model, 'creater_id')->textInput() ?>

    <?= $form->field($model, 'creater_name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'starttime')->textInput() ?>

    <?= $form->field($model, 'endtime')->textInput() ?>

    <?= $form->field($model, 'ispassed')->textInput() ?>

    <?= $form->field($model, 'isdeleted')->textInput() ?>

    <?= $form->field($model, 'isout')->textInput() ?>

    <?= $form->field($model, 'zh_province_id')->textInput() ?>

    <?= $form->field($model, 'zh_citie_id')->textInput() ?>

    <?= $form->field($model, 'zh_district_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
