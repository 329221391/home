<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Custom\models\Customs */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customs-view">
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
            'class_id',
            'cat_default_id',
            'catalogue_des_id',
            'name',
            'name_zh',
            'nickname',
            'logo',
            'password',
            'token',
            'tel',
            'phone',
            'ip',
            'ip_last',
            'ispassed',
            'isdeleted',
            'isout',
            'createtime',
            'starttime',
            'endtime',
        ],
    ]) ?>
</div>
