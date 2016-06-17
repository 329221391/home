<?php

use app\modules\AppBase\base\HintConst;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\School\models\Schools */

$this->title = HintConst::$CREAT.HintConst::$SCHOOL;
$this->params['breadcrumbs'][] = ['label' => 'Schools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schools-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'flag'=>$flag,
    ]) ?>

</div>
