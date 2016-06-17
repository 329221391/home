<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '文章列表')];
?>
<script language="javascript">
    var edit_url = 'index.php?r=manage/article/edit-article';
</script>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>


<div class="wrapper">
  <div class="col-sm-12">
    <section class="panel panel-info">
      <header class="panel-heading">
        <span>文章列表</span>
      </header>
      <div class="panel-body">
      <span><mark  style="color:#900;">注意：审核一栏点击即可更改。</mark></span>
        <div class="adv-table editable-table">
          <table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:15px;">
            <tr style="background:#f0ad4e;color:#FFFFFF;">
              <th class="text-center" style="line-height:30px;">文章标题</th>
              <th class="text-center" style="line-height:30px;">作者</th>
              <th class="text-center">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $shenhe ?>
                    <span class="caret"></span>
                  </button> 
                  <ul class="dropdown-menu">
                    <li><a href="index.php?r=manage/article/index">全部</a></li>
                    <li><a href="index.php?r=manage/article/index&ispassed=211">是</a></li>
                    <li><a href="index.php?r=manage/article/index&ispassed=212">否</a></li>
                  </ul>
                </div>
              </th>
              <th class="text-center" style="line-height:30px;">创建时间</th>
              <th class="text-center" style="line-height:30px;">操作</th>
            </tr>

            <?php foreach ($article_list as $kk => $vv) { ?>
            <tr class="text-center">
              <td><?= $vv['title'] ?></td>
              <td><?= $vv['author_name'] ?></td>
              <td><?= Html::img('@web/images/' . $vv['ispassed'] . '.png', ['onclick' => "listTable.toggle(this, 'ispassed'," . $vv['id'] . ")"]) ?></td>
              <td><?= $vv['createtime'] ?></td>
              <td>
                <a style="color:#fff;" class="btn btn-xs btn-danger" href="javascript:if(confirm('确定删除')){window.location.href='index.php?r=manage/article/delete&id=<?= $vv['id']?>';}">删除</a>
                <a style="color:#fff;" class="btn btn-xs btn-info" href="index.php?r=manage/article/view&id=<?= $vv['id'] ?>">详情</a>
              </td>
            </tr>
            <?php } ?>
          </table>
        </div><!-- adv-table结束 -->
        
        <span class="pull-right">总数：<span style="color:#428bca;font-size:15px;"><?= $pages->totalCount?></span>&nbsp;条记录</span>
      </div><!-- panel-body结束 -->
      <div class="pull-right">
        <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
      </div>
    </section>
  </div><!-- col-*结束 -->
</div><!-- wrapper结束 -->