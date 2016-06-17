<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\Articles\models\Articles */
$model->title= '评价列表';
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '评价列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<div class="wrapper">
  <div class="col-sm-12">
    <section class="panel panel-info">
      <header class="panel-heading">
        <span><?= Html::encode($this->title) ?></span>
      </header>
      <div class="panel-body">
      <div class="adv-table editable-table">
        <table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:20px;">
          <tr style="background:#f0ad4e;color:#fff;">
             <th class="text-center">标题</th>
             <th class="text-center">内容</th>
             <th>&nbsp;</th>
          </tr>

          <tr class="text-center">
             <td><?= $model->title?></td>
             <td><?php echo htmlspecialchars($model->contents); ?></td>
             <td></td>
          </tr>
        </table>
      </div>
      </div>
    </section>
  </div>
</div>

<!-- <h1><?= Html::encode($this->title) ?></h1>
<form action="" method="post">
<table width="100%" class="table">
  <tr>
    <th>标题</th>
    <td><?= $model->title?></td>
  </tr>
  <tr>
    <th>内容</th>
    <td><?php echo htmlspecialchars($model->contents); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
  </tr>
</table>
</form> -->
