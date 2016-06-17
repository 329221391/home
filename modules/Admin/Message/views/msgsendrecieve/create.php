<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Message\models\Msgsendrecieve */

$this->title = 'Create Msgsendrecieve';
$this->params['breadcrumbs'][] = ['label' => 'Msgsendrecieves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msgsendrecieve-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
