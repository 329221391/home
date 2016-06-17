<?php
/**
 * User: gjc
 *  2015/6/15 10:41
 */
use yii\widgets\LinkPager;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '统计'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/school'])];
$this->params['breadcrumbs'][] = "注册省市";
?>

<div class="container" style="margin-top: 10px;">
    <div class="row">
        <div class="col-sm-2">
            <SELECT id="pro" name="pro" class="form-control" type="text">
                <OPTION value="" selected>所在省</OPTION>
            </SELECT>
        </div>
    </div>


    <div style="padding-right:2.7em;">
        <table class="table table-striped table-hover table-bordered" style="margin-top:10px;">
            <tr style="background:#5bc0de;color:#ffffff;"> 
                <th class="text-center">ID</th>
                <th class="text-center">学校名称</th>
                <th class="text-center">省</th>
                <th class="text-center">市</th>
                <th class="text-center">地区</th>
                <th class="text-center">创建时间</th>
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
                    <td>
                        <a class="btn btn-xs btn-success" href="index.php?r=Stats/class/index&school_id=<?= $v['id'] ?>">班级</a>
                        <a class="btn btn-xs btn-warning" href="index.php?r=Stats/custom/index&school_id=<?= $v['id'] ?>">用户</a>
                        <a class="btn btn-xs btn-info" href="index.php?r=Stats/info/index&name=<?= $v['name'] ?>&school_id=<?= $v['id'] ?>">详情</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <span class="pull-right">
            <?= LinkPager::widget([
                'pagination' => $status['pages'],
            ]);
            ?>
        </span>
    </div>
</div>
<script language="javascript">
    var provines_name = 'pro';
    $(document).ready(function () {
        $.getJSON('index.php?r=Schools/schools/provinceslist', function (data) {
            $("#" + provines_name + " option").remove();
            $.each(data, function (j, n) {
                $("#" + provines_name + "").append('<option value=' + n.id + '>' + n.name + '</option>');
            });
            var p = "<?=$pathinfo['p'];?>"
            $("#" + provines_name).val(p);
        });
        $("#" + provines_name + "").change(function () {
            var p = $("#" + provines_name).val();
            window.location.href = 'index.php?r=Stats/province/index&p=' + p;
        });
    });
</script>



