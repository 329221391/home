<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\manage\model\Customs */

$this->title = 'Create Customs';
$this->params['breadcrumbs'][] = ['label' => 'Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
