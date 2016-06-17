<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\CatalogueDes\models\CatalogueDes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Catalogue Des', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogue-des-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'school_id',
            'parent_id',
            'name_zh:ntext',
            'priority',
            'describe',
            'createtime',
            'updatetime',
            'last_admin_id',
            'ispassed',
            'isdeleted',
        ],
    ]) ?>

</div>
