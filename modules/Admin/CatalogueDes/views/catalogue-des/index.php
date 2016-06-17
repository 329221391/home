<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\CatalogueDes\models\CatalogueDesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catalogue Des';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogue-des-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Catalogue Des', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'school_id',
            'parent_id',
            'name_zh:ntext',
            'priority',
            // 'describe',
            // 'createtime',
            // 'updatetime',
            // 'last_admin_id',
            // 'ispassed',
            // 'isdeleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
