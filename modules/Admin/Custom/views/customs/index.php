<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Custom\models\CustomsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customs-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
