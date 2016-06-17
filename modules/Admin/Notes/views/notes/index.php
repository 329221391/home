<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Notes\models\NotesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Notes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pri_type_id',
            'sub_type_id',
            'school_id',
            'class_id',
            // 'custom_id',
            // 'for_someone_id',
            // 'user_tpye_id',
            // 'author_id',
            // 'title',
            // 'contents:ntext',
            // 'thumb',
            // 'createtime',
            // 'starttime',
            // 'endtime',
            // 'ispassed',
            // 'issend',
            // 'isdelete',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
