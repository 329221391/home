<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Catalogue\models\Catalogue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalogue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'school_id')->textInput() ?>

    <?= $form->field($model, 'cat_default_id')->textInput() ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'name_zh')->textInput(['maxlength' => 225]) ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model, 'describe')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'updatetime')->textInput() ?>

    <?= $form->field($model, 'last_admin_id')->textInput() ?>

    <?= $form->field($model, 'ispassed')->textInput() ?>

    <?= $form->field($model, 'isdelete')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
