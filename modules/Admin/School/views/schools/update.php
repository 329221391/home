<?php

use app\modules\AppBase\base\HintConst;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\School\models\Schools */

$this->title = HintConst::$UPDATE . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Schools', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<style>
@media screen and (max-width: 1109px) and (min-width: 500px){
.ltjsc_width{background:#e8f4f4;  width:80%; margin:0 auto;}!important;

}
@media screen and (min-width: 1200px) {

.ltjsc_width{background:#e8f4f4; min-width:1200px;width:1200px; margin:0 auto;_width: expression((document.documentElement.clientWidth||document.body.clientWidth)<1200?"1200px":"");}!important;
.schools-update{background:#e8f4f4;}

}
@media screen and (max-width: 499px) {
.ltjsc_width{background:#e8f4f4;  width:100%;}!important:

}
</style>
<div class="schools-update ltjsc_width">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'flag'=>$flag,
    ]) ?>

</div>
