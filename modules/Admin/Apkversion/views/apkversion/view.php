<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Apkversion\models\Apkversion */

$this->title = $model->name;
echo $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Apkversions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apkversion-view">

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
            'cat_default_id',
            'name',
            'describe',
            'primary_version',
            'sub_version',
            'url',
            'times:datetime',
            'createtime',
            'isdeleted',
            'ispassed',
            'ismust_update',
        ],
    ]) ?>

</div>
