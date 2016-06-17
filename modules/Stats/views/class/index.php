<?php
/**
 * User: gjc
 *  2015/6/15 10:41
 */
use yii\widgets\LinkPager;

$item = '注册班级';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '统计'), 'url' => Yii::$app->urlManager->createUrl(['Stats/school', 's' => $pathinfo['s'], 'e' => $pathinfo['e']])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '后退'), 'url' => Yii::$app->urlManager->createUrl(['Stats/usedsch', 'type' => $pathinfo['type'], 's' => $pathinfo['s'], 'e' => $pathinfo['e']])];
$this->params['breadcrumbs'][] = $item;
?>
<div class="container" style="padding-right:3em;">
    <h5><strong><?= $item ?>：<?= $pathinfo['name']; ?></strong></h5>
    <div style="padding-right:0.7em;">
        <table class="table table-striped table-hover table-bordered">
            <tr style="background:#5bc0de;color:#fff;">
                <th>ID</th>
                <th>班级名称</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>

            <?php foreach ($status['data'] as $k => $v) { ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?= $v['name'] ?></td>
                    <td><?= $v['createtime'] ?></td>
                    <td></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <span class="pull-right">
        <?= LinkPager::widget([
            'pagination' => $status['pages'],
        ]);
        ?>
    </span>
</div>
<script language="javascript">
    var s = "<?=$pathinfo['s'];?>"
    var e = "<?=$pathinfo['e'];?>"
    if (s == '') s = '开始日期';
    if (e == '') e = '结束日期';
    $("#ss").val(s);
    $("#ee").val(e);
</script>



