<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\RedFl\models\RedFlSerach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Red Fls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="red-fl-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Red Fl', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'author_id',
            'author_tpye_id',
            'rd_type_id',
            'sub_type_id',
            // 'for_someone_id',
            // 'contents',
            // 'createtime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
