<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Catalogue\models\Catalogue */

$this->title = 'Create Catalogue';
$this->params['breadcrumbs'][] = ['label' => 'Catalogues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
