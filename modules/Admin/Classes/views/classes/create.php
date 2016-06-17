<?php

use app\modules\AppBase\base\HintConst;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Classes\models\Classes */

$this->title =HintConst::$CREAT.HintConst::$CLASS;
$this->params['breadcrumbs'][] = ['label' => 'Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'flag'=>$flag,
    ]) ?>

</div>
