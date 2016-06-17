<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\RedFl\models\RedFl */

$this->title = 'Create Red Fl';
$this->params['breadcrumbs'][] = ['label' => 'Red Fls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="red-fl-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
