<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Logs\models\LogsClasses */

$this->title = 'Create Logs Classes';
$this->params['breadcrumbs'][] = ['label' => 'Logs Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-classes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
