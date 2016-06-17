<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\RedFl\models\RedFl */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Red Fls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="red-fl-view">

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
            'author_id',
            'author_tpye_id',
            'rd_type_id',
            'sub_type_id',
            'for_someone_id',
            'contents',
            'createtime',
        ],
    ]) ?>

</div>
