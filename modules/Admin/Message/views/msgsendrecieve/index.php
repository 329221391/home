<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Message\models\MsgsendrecieveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Msgsendrecieves';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msgsendrecieve-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Msgsendrecieve', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'message_id',
            'sender_id',
            'reciever_id',
            'isread',
            // 'createtime',
            // 'updatetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
