<?php

use app\modules\AppBase\base\HintConst;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '图片列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script language="javascript">
    var edit_url = 'index.php?r=manage/pic/edit-pic';
</script>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-danger">
            <header class="panel-heading">
                <span>图片列表</span>
            </header>
            <div class="panel-body">
                <span><mark style="color:#900;">注意：审核一栏点击即可更改。</mark></span>

                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample"
                           style="margin-top:15px;">
                        <tr style="background:#5bc0de;color:#fff;">
                            <th class="text-center" style="line-height:30px;">图片</th>
                            <th class="text-center" style="line-height:30px;">作者</th>
                            <th class="text-center" style="line-height:30px;">班级</th>
                            <th class="text-center" style="line-height:30px;">类型</th>
                            <th class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= $shenhe ?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="index.php?r=manage/pic/index">全部</a></li>
                                        <li><a href="index.php?r=manage/pic/index&ispassed=211">是</a></li>
                                        <li><a href="index.php?r=manage/pic/index&ispassed=212">否</a></li>
                                    </ul>
                                </div>

                            </th>
                            <th class="text-center" style="line-height:30px;">创建时间</th>
                            <th class="text-center" style="line-height:30px;">操作</th>
                        </tr>

                        <?php foreach ($pic_list as $kk => $vv) { ?>
                            <tr class="text-center">
                                <td>
                                    <a href="<?= HintConst::$WEB_JYQ . $vv['url'] ?>" class="thumbnail" target="_blank">
                                        <?= Html::img(HintConst::$WEB_JYQ . $vv['url']) ?></a>
                                </td>
                                <td><?= $vv['author_name'] ?></td>
                                <td><?= $vv['class_name'] ?></td>
                                <td><?= $vv['type_name'] ?></td>
                                <td><?= Html::img('@web/images/' . $vv['ispassed'] . '.png', ['onclick' => "listTable.toggle(this, 'ispassed'," . $vv['id'] . ")"]) ?></td>
                                <td><?= $vv['createtime'] ?></td>
                                <td>
                                    <a style="color:#fff;" class="btn btn-xs btn-danger"
                                       href="javascript:if(confirm('确定删除')){window.location.href='index.php?r=manage/pic/delete&id=<?= $vv['id'] ?>';}">删除</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <!-- adv-table结束 -->

                <span class="pull-right">总数：<span style="color:#428bca;font-size:15px;"><?= $pages->totalCount ?></span>&nbsp;条记录</span>
            </div>
            <!-- panel-body结束 -->
            <div class="pull-right">
                <?php
                echo LinkPager::widget([
                    'pagination' => $pages,
                ]);
                ?>
            </div>
        </section>
    </div>
    <!-- col-*结束 -->
</div><!-- wrapper结束 -->