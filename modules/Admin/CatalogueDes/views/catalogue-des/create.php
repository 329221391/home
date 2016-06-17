<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\CatalogueDes\models\CatalogueDes */

$this->title = 'Create Catalogue Des';
$this->params['breadcrumbs'][] = ['label' => 'Catalogue Des', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogue-des-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
