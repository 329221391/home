<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\Classes\models\Classes */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classes-view">

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
            'teacher_id',
            'subteacher1_id',
            'subteacher2_id',
            'cat_default_id',
            'catalogue_des_id',
            'name',
            'namenick',
            'code',
            'logo',
            'ispassed',
            'isdeleted',
            'isgraduated',
            'isout',
            'createtime',
            'updatetime',
        ],
    ]) ?>

</div>
