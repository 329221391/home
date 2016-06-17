<?php
/**
 * User: gjc
 *  2015/6/15 10:41
 */
use app\modules\AppBase\base\cat_def\CatDef;
use janisto\timepicker\TimePicker;
use yii\widgets\LinkPager;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '统计'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/school', 's' => $pathinfo['s'], 'e' => $pathinfo['e']])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '使用情况'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/info','school_id'=>0, 's' => $pathinfo['s'], 'e' => $pathinfo['e']])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', CatDef::getName($pathinfo['type'])), 'url' => ['index', 'type' => $pathinfo['type'], 's' => $pathinfo['s'], 'e' => $pathinfo['e']]];
?>
<div class="container" style="padding-top:1em;padding-bottom:1em;">
    <div class="row">
        <div class="col-md-3"><?= TimePicker::widget([
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
        <div class="col-md-3"><?= TimePicker::widget([
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
        <div class="col-md-2">
            <button id="status" type="button" class="btn btn-default">统计</button>
        </div>
    </div>
</div>
<div class="container" style="padding-right:3em;">
    <table class="table table-striped table-hover">
        <tr>
            <th>ID</th>
            <th>学校名称</th>
            <th>省</th>
            <th>市</th>
            <th>地区</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>

        <?php foreach ($status['data'] as $k => $v) { ?>
            <tr>
                <td><?= $v['id'] ?></td>
                <td><?= $v['name'] ?></td>
                <td><?= $v['province'] ?></td>
                <td><?= $v['city'] ?></td>
                <td><?= $v['district'] ?></td>
                <td><?= $v['createtime'] ?></td>
                <td>
                    <a href="index.php?r=Stats/class/index&school_id=<?= $v['id'] ?>&name=<?= $v['name'] ?>&type=<?= $pathinfo['type'] ?>&s=<?= $pathinfo['s']; ?>&e=<?= $pathinfo['e']; ?>&school_id=<?= $v['id'] ?>"><span
                            class="glyphicon glyphicon-eye-open"></span> 查看班级</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="index.php?r=Stats/custom/index&school_id=<?= $v['id'] ?>&name=<?= $v['name'] ?>&type=<?= $pathinfo['type'] ?>&s=<?= $pathinfo['s']; ?>&e=<?= $pathinfo['e']; ?>&school_id=<?= $v['id'] ?>"><span
                            class="glyphicon glyphicon-eye-open"></span> 查看用户</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="index.php?r=Stats/schinfo/index&school_id=<?= $v['id'] ?>&name=<?= $v['name'] ?>&type=<?= $pathinfo['type'] ?>&s=<?= $pathinfo['s']; ?>&e=<?= $pathinfo['e']; ?>"><span
                            class="glyphicon glyphicon-eye-open"></span> 使用情况</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?= LinkPager::widget([
        'pagination' => $status['pages'],
    ]);
    ?>
</div>
<script language="javascript">
    var type = "<?=$pathinfo['type'];?>"
    var s = "<?=$pathinfo['s'];?>"
    var e = "<?=$pathinfo['e'];?>"
    if (s == '') s = '开始日期';
    if (e == '') e = '结束日期';
    $("#ty").val(type);
    $("#s").val(s);
    $("#e").val(e);
    $("#ss").val(s);
    $("#ee").val(e);
    $("#status").click(function () {
        var s = $("#s").val();
        var e = $("#e").val();
        var type = $("#ty").val();
        window.location.href = 'index.php?r=Stats/usedsch/index&type=' + type + '&s=' + s + '&e=' + e;
    });
</script>



