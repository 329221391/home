<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Custom\models\CustomsdailySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customsdailies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customsdaily-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customsdaily', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'custom_id',
            'daily_type_id',
            'daily_contents',
            'createtime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
