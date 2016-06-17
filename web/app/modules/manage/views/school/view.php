<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\model\Schools */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Schools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schools-view">

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
            'catalogue_des_id',
            'headmaster_id',
            'creater_id',
            'creater_name',
            'code',
            'name',
            'nickname',
            'logo',
            'tel',
            'phone',
            'createtime',
            'starttime',
            'endtime',
            'ispassed',
            'isdeleted',
            'isout',
            'zh_province_id',
            'zh_citie_id',
            'zh_district_id',
            'address',
        ],
    ]) ?>

</div>
