<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Apkversion\models\ApkversionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apkversion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cat_default_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'describe') ?>

    <?= $form->field($model, 'primary_version') ?>

    <?php  echo $form->field($model, 'sub_version') ?>

    <?php  echo $form->field($model, 'url') ?>

    <?php  echo $form->field($model, 'times') ?>

    <?php  echo $form->field($model, 'createtime') ?>

    <?php  echo $form->field($model, 'isdeleted') ?>

    <?php  echo $form->field($model, 'ispassed') ?>

    <?php  echo $form->field($model, 'ismust_update') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
