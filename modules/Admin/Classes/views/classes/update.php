<?php

use app\modules\AppBase\base\HintConst;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Classes\models\Classes */

$this->title = HintConst::$UPDATE . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="classes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'flag'=>$flag,
    ]) ?>

</div>
