<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Articles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'school_id',
            'class_id',
            'article_type_id',
            'sub_type_id',
             'title',
            // 'subtitle',
            // 'contents:ntext',
            // 'thumb',
            // 'date',
            // 'createtime',
            // 'updatetime',
            // 'praise_times:datetime',
            // 'share_times:datetime',
            // 'view_times:datetime',
            // 'ispassed',
            // 'isdelete',
            // 'isview',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
