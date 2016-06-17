<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$this->title = '报名列表';
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
                <span>报名列表</span>
            </header>
            <div class="panel-body">
                <form class="form-inline" action="index.php" method="get" style="margin-bottom:15px;margin-left:20px;">
                    <div class="pull-right">
                        <div class="form-group">
                            <input type="hidden" name="r" value="manage/zhaosheng/post" />
                            <input type="hidden" name="id" value="<?= $id ?>"  />
                            <input type="text" class="form-control" name="keyword" value="<?= $keyword ?>" placeholder="关键字">
                            <button type="submit" class="btn btn-success">查找</button>
                        </div>
                    </div>

                </form>
                <div class="wrapper">
                    <div class="col-sm-12">
                        <div class="adv-table editable-table">
                            <table class="table table-striped table-hover table-bordered" id="editable-sample"
                                   style="margin-top:15px;">
                                <tr style="background:#f0ad4e;color:#FFFFFF;">
                                    <th class="text-center" style="line-height:30px;width:20%">家长姓名</th>
                                    <th class="text-center" style="line-height:30px;width:20%">家长电话</th>
                                    <th class="text-center" style="line-height:30px;width:20%">宝宝姓名</th>
                                    <th class="text-center" style="line-height:30px;width:20%">宝宝年龄</th>
                                    <th class="text-center" style="line-height:30px;width:20%">报名时间</th>

                                </tr>
                                <?php foreach ($post_list as $kk => $vv) { ?>
                                    <tr class="text-center">
                                        <td><?= $vv['parent_name'] ?></td>
                                        <td><?= $vv['parent_mobile'] ?></td>
                                        <td><?= $vv['baby_name'] ?></td>
                                        <td><?= $vv['baby_age'] ?></td>
                                        <td><?= date('Y-m-d H:i',$vv['create_time']) ?></td>

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