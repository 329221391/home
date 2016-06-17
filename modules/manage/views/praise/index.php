<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '鼓励列表';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '鼓励列表')];
?>
<script language="javascript">
    var edit_url = 'index.php?r=manage/praise/edit-article';
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
        <span><?= $this->title?></span>
      </header>
      <div class="panel-body">
<!--      <span><mark  style="color:#900;">注意：审核一栏点击即可更改。</mark></span>-->
        <div class="adv-table editable-table">
          <table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:15px;">
            <tr style="background:#f0ad4e;color:#FFFFFF;">
              <th class="text-center" style="line-height:30px;">鼓励标题</th>
              <th class="text-center" style="line-height:30px;">作者</th>
              <th class="text-center" style="line-height:30px;">创建时间</th>
              <th class="text-center" style="line-height:30px;">操作</th>
            </tr>

            <?php foreach ($article_list as $kk => $vv) { ?>
            <tr class="text-center">
              <td><?= $vv['title'] ?></td>
              <td><?= $vv['author_name'] ?></td>
              <td><?= $vv['createtime'] ?></td>
              <td>
                <a style="color:#fff;" class="btn btn-xs btn-danger" href="javascript:if(confirm('确定删除')){window.location.href='index.php?r=manage/praise/delete&id=<?= $vv['id']?>';}">删除</a>
                <a style="color:#fff;" class="btn btn-xs btn-info" href="index.php?r=manage/praise/view&id=<?= $vv['id'] ?>">详情</a>
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