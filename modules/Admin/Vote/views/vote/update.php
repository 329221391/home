<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Vote\models\Vote */

$this->title = 'Update Vote: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vote-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>