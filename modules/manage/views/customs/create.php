<?php

use app\modules\AppBase\base\HintConst;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Custom\models\Customs */

$this->title = HintConst::$CREAT.HintConst::$CUSTOM;
$this->params['breadcrumbs'][] = ['label' => 'Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'flag'=>$flag,
    ]) ?>

</div>
