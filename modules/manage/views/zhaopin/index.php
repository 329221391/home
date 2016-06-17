<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$this->title = '招聘管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-info">
            <header class="panel-heading">
                <span>招聘列表</span>
            </header>
            <div class="panel-body">
                <form class="form-inline" action="" method="post" style="margin-bottom:15px;">
                    <input type="hidden" name="r" value="manage/class/index"/>
                    <div style="margin-left: 20px;">
                        <div class="form-group">
                            <a  href="index.php?r=manage/zhaopin/create" class="btn btn-info">添加</a>
                        </div>
                    </div>

                </form>
                <div class="wrapper">

                    <div class="col-sm-12">

                        <div class="adv-table editable-table">
                            <table class="table table-striped table-hover table-bordered" id="editable-sample"
                                   style="margin-top:15px;">
                                <tr style="background:royalblue ;color:#FFFFFF;">
                                    <th class="text-center" style="line-height:30px;width:60%">选择模板</th>

                                    <th class="text-center" style="line-height:30px;width:40%">操作</th>
                                </tr>

                                <tr class="text-center">
                                    <td>招聘模板</td>
                                    <td>

                                        <a style="color:#fff;" target="_blank" class="btn btn-xs btn-info"
                                           href="index.php?r=zhaopin/view&id=19">预览</a>
                                        <a style="color:#fff;" class="btn btn-xs btn-info"
                                           href="index.php?r=manage/zhaopin/create-by-template&id=19">应用</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- adv-table结束 -->
                    </div>

                    <div class="col-sm-12">

                        <div class="adv-table editable-table">
                            <table class="table table-striped table-hover table-bordered" id="editable-sample"
                                   style="margin-top:15px;">
                                <tr style="background:#f0ad4e;color:#FFFFFF;">
                                    <th class="text-center" style="line-height:30px;width:20%">招聘标题</th>
                                    <th class="text-center" style="line-height:30px;width:20%">预计人数</th>
                                    <th class="text-center" style="line-height:30px;width:20%">招聘电话</th>
                                    <th class="text-center" style="line-height:30px;width:20%">创建时间</th>
                                    <th class="text-center" style="line-height:30px;width:20%">操作</th>
                                </tr>
                                <?php foreach ($zhaopin_list as $kk => $vv) { ?>
                                    <tr class="text-center">
                                        <td><?= $vv['title'] ?></td>
                                        <td><?= $vv['prepare_count'] ?></td>
                                        <td><?= $vv['post_phone'] ?></td>
                                        <td><?= date('Y-m-d H:i',($vv['create_time'])) ?></td>
                                        <td>

                                            <a style="color:#fff;" class="btn btn-xs btn-info"
                                               href="index.php?r=manage/zhaopin/edit&id=<?= $vv['id'] ?>">编辑</a>
                                            <a style="color:#fff;" target="_blank" class="btn btn-xs btn-info"
                                               href="index.php?r=zhaopin/view&id=<?= $vv['id'] ?>">预览</a>
                                            <a style="color:#fff;" class="btn btn-xs btn-info"
                                               href="index.php?r=manage/zhaopin/post&id=<?= $vv['id'] ?>">详情</a>
                                            <a style="color:#fff;" class="btn btn-xs btn-danger"
                                               href="javascript:if(confirm('确定删除')){window.location.href='index.php?r=manage/zhaopin/delete&id=<?= $vv['id'] ?>';}">删除</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <!-- adv-table结束 -->

                                <span class="pull-right">总数：<span
                                        style="color:#428bca;font-size:15px;"><?= $pages->totalCount ?></span>&nbsp;条记录</span>


                    </div>
                    <!-- col-*结束 -->
                </div>
                <!-- panel-body结束 -->
                <div class="pull-right">
                    <?php
                    echo LinkPager::widget([
                        'pagination' => $pages,
                    ]);
                    ?>
                </div>
            </div>
    </div>
</div>
<!-- wrapper结束 -->