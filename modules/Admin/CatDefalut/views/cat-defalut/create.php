<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Admin\CatDefalut\models\CatDefalut */

$this->title = 'Create Cat Defalut';
$this->params['breadcrumbs'][] = ['label' => 'Cat Defaluts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-defalut-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
