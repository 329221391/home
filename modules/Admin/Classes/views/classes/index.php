<?php

use app\modules\AppBase\base\HintConst;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Classes\models\ClassesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = HintConst::$CLASS;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(HintConst::$CREAT.HintConst::$CLASS, ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
             'name',
             'code',
            'school_id',
            'teacher_id',
            'subteacher1_id',
            'subteacher2_id',
             'cat_default_id',
             'catalogue_des_id',
             'namenick',
             'logo',
             'ispassed',
             'isdeleted',
             'isgraduated',
             'isout',
             'createtime',
             'updatetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
