<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Catalogue\models\CatalogueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catalogues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogue-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Catalogue', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'school_id',
            'cat_default_id',
            'parent_id',
            'path',
            // 'name',
            // 'name_zh',
            // 'priority',
            // 'describe',
            // 'createtime',
            // 'updatetime',
            // 'last_admin_id',
            // 'ispassed',
            // 'isdelete',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
