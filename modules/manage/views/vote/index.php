<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '调查列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script language="javascript">
    var edit_url = 'index.php?r=manage/note/edit-note';
</script>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-success">
            <header class="panel-heading">
                <span>调查列表</span>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:20px;">
                        <tr style="background:#d9534f;color:#fff;">
                            <th class="text-center">调查标题</th>
                            <th class="text-center">作者</th>
                            <th class="text-center">创建时间</th>
                            <th class="text-center">操作</th>
                        </tr>

                        <?php foreach ($note_list as $kk => $vv) { ?>
                        <tr class="text-center">
                            <td><?= $vv['title'] ?></td>
                            <td><?= $vv['author_name'] ?></td>
                            <td><?= $vv['createtime'] ?></td>
                            <td>
                                <a style="color:#fff;" class="btn btn-xs btn-danger" href="javascript:if(confirm('确定删除')){window.location.href='index.php?r=manage/vote/delete&id=<?= $vv['id'] ?>';}">删除</a>
                                <a style="color:#fff;" class="btn btn-xs btn-info" href="index.php?r=manage/vote/view&id=<?= $vv['id'] ?>">详情</a>
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