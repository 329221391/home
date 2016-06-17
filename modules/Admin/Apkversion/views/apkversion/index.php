<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Apkversion\models\ApkversionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apkversions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apkversion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Apkversion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cat_default_id',
            'name',
            'describe',
            'primary_version',
             'sub_version',
             'url:url',
             'times:datetime',
             'createtime',
            // 'isdeleted',
            // 'ispassed',
            // 'ismust_update',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
