<?php

use app\modules\Admin\CatDefalut\models\CatDefalut;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\HintConst;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Apkversion\models\Apkversion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apkversion-form">

    <?php
    $form = ActiveForm::begin([
        'id' => "apkversion-form",
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data'],
    ]);
    ?>

    <?= $form->field($model, 'cat_default_id')->dropDownList(ArrayHelper::map((new CatDefalut())->getRole(), HintConst::$Field_id, HintConst::$Field_name_zh)) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'describe')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'primary_version')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'sub_version')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'url')->fileInput() ?>

    <?= $form->field($model, 'times')->textInput() ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'isdeleted')->textInput() ?>

    <?= $form->field($model, 'ispassed')->textInput() ?>

    <?= $form->field($model, 'ismust_update')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
