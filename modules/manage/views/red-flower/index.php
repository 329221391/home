<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\modules\AppBase\base\HintConst;
use janisto\timepicker\TimePicker;
use app\assets\AppAsset;
$this->title = '宝贝红花';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '宝贝红花')];
AppAsset::register($this);
?>

<script language="javascript">
    var edit_url = 'index.php?r=manage/customs/edit-custom';
</script>


<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>
<link href="/js/jquery-ui/themes/smoothness/jquery-ui.css" rel="stylesheet">
<script src="/js/jquery-ui/jquery-ui.js"></script>
<script src="/js/jquery-ui/ui/i18n/datepicker-zh-CN.js"></script>
<link href="/js/jquery-ui-timepicker/jquery-ui-timepicker-addon.css" rel="stylesheet">
<script src="/js/jquery-ui-timepicker/jquery-ui-timepicker-addon.js"></script>
<script src="/js/jquery-ui-timepicker/i18n/jquery-ui-timepicker-zh-CN.js"></script>
<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-info">
            <header class="panel-heading">
                <span>宝贝红花</span>
            </header>
            <div class="panel-body">

                <form class="form-inline" action="index.php" method="get" style="margin-bottom:15px;">
                    <input type="hidden" name="r" value="manage/red-flower/index"/>
                    <div class="form-group">
                        <select id="f_type" name="f_type" class="form-control" style="font-size:13px;">
                            <option value="0">红花类型(未设置)</option>
                            <option value="249" <?= $queryString['f_type'] == '249' ? 'selected' : '' ?>>红花</option>
                            <option value="248" <?= $queryString['f_type'] == '248' ? 'selected' : '' ?>>金花</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select id="sender_id" name="sender_id" class="form-control" style="font-size:13px;">
                            <option value="0">发送人(未设置)</option>
                            <?php foreach ($sender_list as $kk => $vv) { ?>
                                <option value="<?= $vv['id'] ?>" <?= $vv['id'] == $queryString['sender_id'] ? 'selected' : '' ?> >
                                    <?= $vv['name_zh'] ?>
                                    <?= $vv['cat_default_id'] == HintConst::$ROLE_HEADMASTER ? '园长' : '老师'?>
                                </option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select id="class_id" name="class_id" class="form-control" style="font-size:13px;">
                            <option value="0">班级(未设置)</option>
                            <?php foreach ($class_list as $kk => $vv) { ?>
                                <option value="<?= $vv['id'] ?>" <?= $vv['id'] == $queryString['class_id'] ? 'selected' : '' ?> >
                                    <?= $vv['name'] ?>
                                </option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select id="receiver_id" name="receiver_id" class="form-control" style="font-size:13px;">
                            <option value="0" >接收人(未设置)</option>
                            <?php foreach ($receiver_list as $kk => $vv) { ?>
                                <option value="<?= $vv['id'] ?>" <?= $vv['id'] == $queryString['receiver_id'] ? 'selected' : '' ?> >
                                    <?= $vv['name_zh'] ?>
                                </option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <?= TimePicker::widget([
                            'language' => 'zh-CN',
                            'id' => 's_date',
                            'name' => 's_date',
                            'value' => $queryString['s_date'],
                            'mode' => 'date',
                            'clientOptions' => [
                                'dateFormat' => 'yy-mm-dd',
                                'timeFormat' => 'HH:mm:ss',
                                'showSecond' => false,
                            ]
                        ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <?= TimePicker::widget([
                            'language' => 'zh-CN',
                            'id' => 'e_date',
                            'name' => 'e_date',
                            'value' => $queryString['e_date'] == '' ? date('Y-m-d',time()) : $queryString['e_date'],
                            'mode' => 'date',
                            'clientOptions' => [
                                'dateFormat' => 'yy-mm-dd',
                                'timeFormat' => 'HH:mm:ss',
                                'showSecond' => false,
                            ]
                        ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">查找</button>
                    </div>



                </form>


                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:15px;">
                        <tr style="background:#f0ad4e;color:#FFFFFF;">
                            <th class="text-center" style="line-height:30px;">类型</th>
                            <th class="text-center" style="line-height:30px;">发送人</th>
                            <th class="text-center" style="line-height:30px;">接收人</th>
                            <th class="text-center" style="line-height:30px;">班级</th>
                            <th class="text-center" style="line-height:30px;">创建时间</th>
                            <th class="text-center" style="line-height:30px;">操作</th>
                        </tr>

                        <?php foreach ($redfl_list as $kk => $vv) { ?>
                            <tr class="text-center" id="_row_<?=$vv['id'] ?>">
                                <td>
                                    <?= $vv['pri_type_id'] == 249 ? '红花' : '金花' ?>
                                </td>
                                <td><?= $vv['author_name'] ?></td>
                                <td><?= $vv['receiver_name'] ?></td>
                                <td><?= $vv['class_name'] ?></td>

                                <td><?= $vv['createtime'] ?></td>
                                <td>
                                    <a style="color:#fff;" class="btn btn-xs btn-danger" href="javascript:deleteRow(<?=$vv['id'] ?>)">删除</a>
                                    <a style="color:#fff;" class="btn btn-xs btn-info" href="index.php?r=manage/red-flower/view&id=<?= $vv['id'] ?>">详情</a>
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
                    'pagination' => $pages
                ]);
                ?>
            </div>
        </section>
    </div><!-- col-*结束 -->
</div><!-- wrapper结束 -->
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#s_date').datetimepicker({"dateFormat":"yy-mm-dd","timeFormat":"HH:mm:ss","showSecond":false});
        jQuery('#e_date').datetimepicker({"dateFormat":"yy-mm-dd","timeFormat":"HH:mm:ss","showSecond":false});
    });</script>
<script>

    function getStudent(class_id,callback){
        $.get('index.php?r=manage/red-flower/get-student',{
            class_id:class_id
        },function(data){
            //alert(JSON.stringify(data));
            callback(data);
        },'json');
    }


    function deleteRow(id){
        if(!confirm('确认删除吗?')){
            return;
        }

        $.get('index.php?r=manage/red-flower/delete',{
            redfl_id:id
        },function(data){
            if(data.error == 0){
                $('#_row_'+id).fadeOut();
            }
        },'json');
    }

    $(function(){
        $('#class_id').change(function(){
            var sender_id = $('#class_id').val();

            $('#receiver_id').empty();
            var option = $("<option>").val(0).text("接收人(未设置)");
            $('#receiver_id').append(option);
            getStudent(sender_id,function(data){
                console.log(data);
                for(var i=0;i<data.length;i++){
                    var op = $('<option>').val(data[i].id).text(data[i].name_zh);
                    $('#receiver_id').append(op);
                }
            });
        });

        var s = "<?=$queryString['s_date'];?>"
        var e = "<?=$queryString['e_date'];?>"


        $("#s_date").attr('placeholder','开始时间');
        $("#e_date").attr('placeholder','结束时间');
    });
</script>