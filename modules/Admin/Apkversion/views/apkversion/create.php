<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Apkversion\models\Apkversion */

$this->title = 'Create Apkversion';
$this->params['breadcrumbs'][] = ['label' => 'Apkversions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apkversion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
