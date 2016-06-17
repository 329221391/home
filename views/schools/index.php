<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\School\models\SchoolsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schools';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schools-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Schools', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'headmaster_id',
            'code',
            'name',
            'nickname',
            'zh_province_id',
            'zh_citie_id',
            'zh_district_id',
            'cat_default_id',
            'catalogue_des_id',
            'creater_id',
            'creater_name',
            'logo',
            'tel',
            'phone',
            'createtime',
            'starttime',
            'endtime',
            'ispassed',
            'isdeleted',
            'isout',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
