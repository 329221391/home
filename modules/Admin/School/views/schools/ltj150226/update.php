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
@media screen and (max-width: 1000px) {
.ltjsc_width{background:#e8f4f4;  width:100%;}!important:

}
@media screen and (min-width: 1001px) {

.ltjsc_width{background:#e8f4f4; min-width:1001px;width:1001px; margin:0 auto;_width: expression((document.documentElement.clientWidth||document.body.clientWidth)<1001?"1001px":"");}!important:
.schools-update{background:#e8f4f4;}

}
</style>
<div class="schools-update ltjsc_width">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'flag'=>$flag,
    ]) ?>

</div>
