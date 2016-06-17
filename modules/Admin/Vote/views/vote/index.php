<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Vote\models\VoteSerach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Votes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vote', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'author_id',
            'author_tpye_id',
            'pri_type_id',
            'sub_type_id',
            // 'school_id',
            // 'class_id',
            // 'title',
            // 'contents',
            // 'date',
            // 'createtime',
            // ' yes',
            // 'no',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
