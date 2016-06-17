<?php

use app\modules\Admin\CatDefalut\models\CatDefalut;
use app\modules\AppBase\base\HintConst;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Classes\models\Classes */
/* @var $form yii\widgets\ActiveForm */
$yesno = (new CatDefalut())->getYesOrNoList();
?>

<div class="classes-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'school_id')->textInput() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>
    <?php if ($flag == HintConst::$UPDATE) { ?>
        <?= $form->field($model, 'teacher_id')->textInput() ?>
        <?= $form->field($model, 'subteacher1_id')->textInput() ?>
        <?= $form->field($model, 'subteacher2_id')->textInput() ?>
        <?= $form->field($model, 'cat_default_id')->textInput() ?>
        <?= $form->field($model, 'catalogue_des_id')->textInput() ?>
        <?= $form->field($model, 'namenick')->textInput(['maxlength' => 45]) ?>
        <?= $form->field($model, 'code')->textInput(['maxlength' => 50]) ?>
        <?= $form->field($model, 'logo')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'ispassed')->dropDownList(ArrayHelper::map($yesno, 'id', 'name_zh')) ?>
        <?= $form->field($model, 'isdeleted')->dropDownList(ArrayHelper::map($yesno, 'id', 'name_zh')) ?>
        <?= $form->field($model, 'isout')->dropDownList(ArrayHelper::map($yesno, 'id', 'name_zh')) ?>
        <?= $form->field($model, 'isgraduated')->dropDownList(ArrayHelper::map($yesno, 'id', 'name_zh')) ?>
        <?php //= $form->field($model, 'createtime')->textInput() ?>
        <?php //= $form->field($model, 'updatetime')->textInput() ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
