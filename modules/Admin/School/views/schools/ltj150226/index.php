<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\School\models\SchoolsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schools';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    table thead {
        background: #C0E4E4;
    }

    .ltj_a a {
        color: #337ab7;
    }

    .ltj_a a:hover {
        color: #23527c;
    }

    .ltjhid {
        display: none;
    }

    .ltjnohid {
        display: inline;
    }

    .ltjnodid1 {
        display: none;
    }

    .schools-index1 {
        display: none;
    }
</style>
<!--<script>
function ltjtz(){
url="index_more.php";window.location.href=url;}
</script>-->
<div style="position:relative;" class="schools-index" id="ltjhid">
    <div class="ltj_a"
         style="position:absolute; float:right; width:100%; display:inline; margin-top:125px;text-align:right;height:50px;z-indent:20;left:0;top:0; font-size:14px; padding-right:1%; ">

        <a style="cursor:pointer;"
           onclick="document.getElementById('ltjhid').className='schools-index1'; document.getElementById('ltjnohid').className='schools-index'">more>></a>
    </div>
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
            // 'id',
            // 'headmaster_id',
            'code',
            'name',
            ['label' => '园长姓名', 'attribute' => 'custom_name_zh', 'value' => 'customs.name_zh', 'filter' => Html::activeTextInput($searchModel, 'custom_name_zh', ['class' => 'form-control'])],
            ['label' => '园长手机', 'attribute' => 'custom_phone', 'value' => 'customs.phone', 'filter' => Html::activeTextInput($searchModel, 'custom_phone', ['class' => 'form-control'])],
            // 'nickname',
            // 'zh_province_id',
            // 'zh_citie_id',
            // 'zh_district_id',
            //  'cat_default_id',
            // 'catalogue_des_id',
            //  'creater_id',
            //  'creater_name',
            // 'logo',
            'tel',
            'phone',
            //  'createtime',
            //  'starttime',
            //  'endtime',
            //  'ispassed',
            //  'isdeleted',
            //  'isout',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<div id="ltjnohid" class="schools-index1" style="width: 2600px">
    <!--<div class="ltj_a" style="position:absolute; float:right; width:100%; display:inline; margin-top:125px;text-align:right;height:50px;z-indent:20;left:0;top:0; font-size:14px; padding-right:1%; ">
    <form name="welcomeform" method="post" action="index_more.php">
    <input type="hidden">
    </form>
    <a href="javascript:welcomeform.submit();" >more>></a></div>-->
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
            ['label' => '园长姓名', 'attribute' => 'custom_name_zh', 'value' => 'customs.name_zh', 'filter' => Html::activeTextInput($searchModel, 'custom_name_zh', ['class' => 'form-control'])],
            ['label' => '园长手机', 'attribute' => 'custom_phone', 'value' => 'customs.phone', 'filter' => Html::activeTextInput($searchModel, 'custom_phone', ['class' => 'form-control'])],
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
            ['class' => 'yii\grid\ActionColumn','header' => '操作',],
        ],
    ]); ?>
</div>
