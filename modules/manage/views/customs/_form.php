<?php

use app\modules\Admin\CatDefalut\models\CatDefalut;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\HintConst;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Custom\models\Customs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customs-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat_default_id')->dropDownList(ArrayHelper::map((new CatDefalut())->getRole(), HintConst::$Field_id, HintConst::$Field_name_zh)) ?>
    <?= $form->field($model, 'school_id')->dropDownList(ArrayHelper::map(Schools::getSchoolList(), HintConst::$Field_id, HintConst::$Field_name)) ?>
    <?= $form->field($model, 'class_id')->textInput() ?>
    <?= $form->field($model, 'name_zh')->textInput(['maxlength' => 45]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => 11]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 45]) ?>
    <?php if ($flag == HintConst::$UPDATE) { ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>
        <?= $form->field($model, 'nickname')->textInput(['maxlength' => 45]) ?>
        <?= $form->field($model, 'catalogue_des_id')->textInput() ?>
        <?= $form->field($model, 'logo')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'token')->textInput(['maxlength' => 45]) ?>
        <?= $form->field($model, 'tel')->textInput(['maxlength' => 45]) ?>
        <?= $form->field($model, 'ip')->textInput(['maxlength' => 20]) ?>
        <?= $form->field($model, 'ip_last')->textInput(['maxlength' => 20]) ?>
        <?= $form->field($model, 'ispassed')->textInput() ?>
        <?= $form->field($model, 'isdeleted')->textInput() ?>
        <?= $form->field($model, 'isout')->textInput() ?>
        <?= $form->field($model, 'createtime')->textInput() ?>
        <?= $form->field($model, 'starttime')->textInput() ?>
        <?= $form->field($model, 'endtime')->textInput() ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
