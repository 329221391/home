<?php
/**
 * User: gjc
 *  2015/6/15 10:41
 */
use dosamigos\datepicker\DatePicker;
use janisto\timepicker\TimePicker;
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '统计'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/school', 's' => $pathinfo['s'], 'e' => $pathinfo['e']])];
$this->params['breadcrumbs'][] = "注册学校";
?>
<script language="javascript">
    var edit_url = 'index.php?r=Stats/school/edit';
</script>
<?= Html::jsFile('@web/js/listtable.js') ?>

<div class="container" style="padding-top:1em;">
    <div class="row">
        <div class="col-sm-3"><?= TimePicker::widget([
                'language' => 'zh-CN',
                'id' => 's',
                'name' => 'startdate',
                'value' => '开始时间',
                'mode' => 'datetime',
                'clientOptions' => [
                    'dateFormat' => 'yy-mm-dd',
                    'timeFormat' => 'HH:mm:ss',
                    'showSecond' => true,
                ]
            ]);
            ?></div>
        <div class="col-sm-3"><?= TimePicker::widget([
                'language' => 'zh-CN',
                'id' => 'e',
                'name' => 'enddate',
                'value' => '结束时间',
                'mode' => 'datetime',
                'clientOptions' => [
                    'dateFormat' => 'yy-mm-dd',
                    'timeFormat' => 'HH:mm:ss',
                    'showSecond' => true,
                ]
            ]);
            ?></div>
        <div class="col-sm-1">
            <button id="status" type="button" class="btn btn-success">统计</button>
        </div>
        
        <div class="col-sm-3 pull-right" style="margin-right:2.7em;">
            <div class="input-group">
                <input type="text" id="sch_name" class="form-control" placeholder="用户名或邮件地址">
                <span class="input-group-btn">
                    <button id="status2" class="btn btn-info" type="button">查询</button>
                </span>
            </div>
        </div>
    </div><!-- row结束 -->
    <div style="padding-right:2.7em;margin-bottom:1em;">
        <table class="table table-striped table-hover table-bordered" style="margin-top:1em;">
            <tr style="background:#f0ad4e;color:#fff;">
                <th class="text-center">ID</th>
                <th class="text-center">学校名称</th>
                <th class="text-center">省</th>
                <th class="text-center">市</th>
                <th class="text-center">地区</th>
                <th class="text-center">创建时间</th>
                <th class="text-center">审核</th>
                <th class="text-center">操作</th>
            </tr>

            <?php foreach ($status['data'] as $k => $v) { ?>
                <tr class="text-center">
                    <td><?= $v['id'] ?></td>
                    <td><?= $v['name'] ?></td>
                    <td><?= $v['province'] ?></td>
                    <td><?= $v['city'] ?></td>
                    <td><?= $v['district'] ?></td>
                    <td><?= $v['createtime'] ?></td>
                    <td><?= Html::img('@web/images/'.$v['ispassed'].'.png',['onclick'=>"listTable.toggle(this, 'ispassed',".$v['id'].")"])?></td>
                    <td>
                        <a class="btn btn-xs btn-success" href="index.php?r=Stats/class/index&school_id=<?= $v['id'] ?>&name=<?= $v['name'] ?>&s=<?= $pathinfo['s']; ?>&e=<?= $pathinfo['e']; ?>&school_id=<?= $v['id'] ?>">班级</a>
                        <a class="btn btn-xs btn-warning" href="index.php?r=Stats/custom/index&school_id=<?= $v['id'] ?>&name=<?= $v['name'] ?>&s=<?= $pathinfo['s']; ?>&e=<?= $pathinfo['e']; ?>&school_id=<?= $v['id'] ?>">用户</a>
                        <a class="btn btn-xs btn-info" href="index.php?r=Stats/info/index&school_id=<?= $v['id'] ?>&name=<?= $v['name'] ?>&s=<?= $pathinfo['s']; ?>&e=<?= $pathinfo['e']; ?>">详情</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <span style="font-weight:bold;letter-spacing:2px;"><mark style="color:#900;">注意：表格内审核一栏点击即可更改。</mark></span>
        <span class="pull-right">
            <?= LinkPager::widget([
                'pagination' => $status['pages'],
            ]);
            ?>
        </span>
    </div>
</div><!-- container结束 -->

<script language="javascript">
    var s = "<?=$pathinfo['s'];?>"
    var e = "<?=$pathinfo['e'];?>"
    var sch_name = "<?=$pathinfo['sch_name'];?>"
    if (s == '') s = '开始日期';
    if (e == '') e = '结束日期';
    $("#s").val(s);
    $("#e").val(e);
    $("#ss").val(s);
    $("#ee").val(e);
    $("#sch_name").val(sch_name);
    $("#status").click(function () {
        var s = $("#s").val();
        var e = $("#e").val();
        var sch_name = $("#sch_name").val();
        window.location.href = 'index.php?r=Stats/school/index&s=' + s + '&e=' + e+ '&sch_name=' + sch_name;
    });
    $("#status2").click(function () {
        var s = $("#s").val();
        var e = $("#e").val();
        var sch_name = $("#sch_name").val();
        window.location.href = 'index.php?r=Stats/school/index&s=' + s + '&e=' + e+ '&sch_name=' + sch_name;
    });
</script>



