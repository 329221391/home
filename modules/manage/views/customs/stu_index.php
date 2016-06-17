<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Custom\models\CustomsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '学生管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<script language="javascript">
    var edit_url = 'index.php?r=manage/customs/edit-custom';
</script>
<?= Html::cssFile('@web/css/token-input.css') ?>
<?= Html::cssFile('@web/css/js_tree/default/style.min.css') ?>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true" style="color:#fff;">
                    &times;
                </button>
                <h5 class="modal-title text-center" id="myModalLabel">
                    当前积分:<span id="curpoints">1000</span>
                </h5>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <div class="radio-inline" style="margin-bottom:10px;"><input type="radio" name="optionsRadios"
                                                                                     id="radios1" value="1">加分
                        </div>
                        <div class="radio-inline" style="margin-bottom:10px;"><input type="radio" name="optionsRadios"
                                                                                     id="radios2" value="2" checked>减分
                        </div>
                        <input type="text" id="pointssize" class="form-control input-sm" size="10" min="1" max="100"
                               placeholder="输入要变更的积分">
                        <input type="text" id="curcustom_id" hidden>
                    </div>
                    <div class="form-group">
                        <textarea id="pointscontents" class="form-control input-sm" placeholder="变更原因(必填,不超过30字).."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                <button id="editpoints" type="button" class="btn btn-sm btn-info">保存</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal -->
</div>
<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-warning">
            <header class="panel-heading">
                <span>学生管理</span>
            </header>
            <div class="panel-body">
                <form class="form-inline" action="" method="post" style="margin-bottom:10px;">
                    <div class="pull-right" style="margin-bottom:20px;">
                        <div class="form-group">
                            <select id="field_type" name="field_type" class="form-control"
                                    style="font-size:13px;"></select>
                            <input type="text" class="form-control" name="field" id="field" placeholder="查找..">
                            <input type="hidden" name="r" value="manage/class/index">
                            <button type="submit" class="btn btn-success">查找</button>
                        </div>
                    </div>
                </form>
                <?php if (isset(Yii::$app->session['manage_user'])) { ?>
                    <form id="students" class="form-inline" style="margin-bottom:15px;"
                          action="index.php?r=manage/customs/uploadexcel"
                          method="post" enctype="multipart/form-data" onsubmit="return check()">
                        <div class="form-group">
                            <select class="form-control"  id="checkclass" name="class_id">
                                <option value="">请选择班级</option>
                                <?php foreach($class_list as $v) {?>
                                    <option value="<?php echo $v['id'] ?>" >
                                        <?php echo $v['name']?>
                                    </option>
                                <?php }?>
                            </select>
                            <input id="myname" type="file" name="myname" class="form-control" accept=".xlsx">
                            <input type="text" name="role" hidden value="<?= $params['role'] ?>">
                            <button type="submit" class="btn btn-success">通过电子表格添加</button>
                            <a href="download/学生信息模板.zip">
                                <button id="downexcel" type="button" class="btn btn-danger">下载用户信息模板</button>
                            </a>
                        </div>
                    </form>
                <?php } ?>
                <span><mark style="color:#900;">注意：表格内部分数据点击即可编辑。</mark></span>

                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample"
                           style="margin-top:15px;">
                        <tr style="background:#5bc0de;color:#fff;" class="stu_th">
                            <th class="text-center">学生名称</th>
                            <th class="text-center">修改密码</th>
                            <th class="text-center">电话号码</th>
                            <th class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        所属班级(全部)
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php foreach($class_list as $v) {?>
                                            <li >
                                                <a href = "index.php?r=manage/customs&type=2&class_id=<?php echo $v['id']?>"><?php echo $v['name']?> </a >
                                            </li >
                                        <?php } ?>
                                    </ul>
                                </div>
                            </th>
                            <th class="text-center">是否有效</th>
                            <th class="text-center">创建时间</th>
                            <th class="text-center">积分</th>
                            <th class="text-center">红花绑定</th>
                            <th class="text-center">操作</th>
                        </tr>
                        <?php foreach ($models as $kk => $vv) { ?>
                            <tr class="text-center stu_tr" id="<?php echo $vv['id']?>">
                                <td><span title="编辑"
                                          onclick="listTable.edit(this, 'name', <?= $vv['id'] ?>)"><?= $vv['name_zh'] ?></span>
                                </td>
                                <td><span title="编辑"
                                          onclick="listTable.edit(this, 'password', <?= $vv['id'] ?>)">点击修改密码</span>
                                </td>
                                <td><span title="编辑"
                                          onclick="listTable.edit(this, 'phone', <?= $vv['id'] ?>)"><?= $vv['phone'] ?></span>
                                </td>
                                <td><?= $vv['class_name'] ?></td>
                                <td><?= Html::img('@web/images/' . $vv['ispassed'] . '.png', ['onclick' => "listTable.toggle(this, 'ispassed'," . $vv['id'] . ")"]) ?></td>
                                <td><?= $vv['createtime'] ?></td>
                                <td><?= $vv['points'] ?></td>
                                <td><?= $vv['rftoken']!=""?"已绑定":"未绑定"?></td>
                                <td><a style="color:#fff;" class="btn btn-xs btn-danger"
                                       href="javascript:if(confirm('确定删除')){window.location.href='index.php?r=manage/customs/delete&id=<?= $vv['id'] ?>';}">删除</a>

                                    <a style="color:#fff;" class="btn btn-xs btn-danger change" data-toggle="modal"
                                       data-target="#classModal">换班</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <!-- adv-table结束 -->

                <span class="pull-right">总数：<span style="color:#428bca;font-size:15px;"><?= $pages->totalCount ?></span>&nbsp;条记录</span>
            </div>
            <!-- panel-body结束 -->
        </section>
    </div>
    <!-- col-*结束 -->
    <!-- 模态框（Modal） -->
    <div class="modal fade bs-modal-sm" id="classModal" tabindex="-1" role="dialog"
         aria-labelledby="classModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="classModalLabel">

                    </h4>
                </div>
                <div class="modal-body">
                    调换至：
                    <select class="select"  id="ok">
                        <?php foreach($class_list as $v) {?>
                            <option value="<?php echo $v['id'] ?>">
                                <?php echo $v['name']?>
                            </option>
                        <?php }?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal" id="ggg">关闭
                    </button>
                    <button type="button" class="btn btn-primary" id="definite">
                        提交更改
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
</div><!-- wrapper结束 -->
<?php
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>
<script language="javascript">
    var class_id = "<?=$params['class_id']?>";
    var isadmin = "<?=$params['isadmin']?>";
    if (class_id && isadmin) {
        $('#students').show();
    }
    function check() {
        if (!$('#myname').val()) {
            alert("请选择电子表格类文件!");
            return false;
        }
        if(!$("#checkclass").find("option:selected").val()){
            alert("请选择班级")
            return false;
        }
        return true;
    }
    var field_type = 'field_type';
    function update(obj, custom_id) {
        var tds = $(obj).parent().parent().find('td');
        $('#curpoints').html(tds.eq(6).text());
        $('#curcustom_id').val(custom_id);
        $('#myModal').modal('show');
    }
    $(document).ready(function () {
        $("#" + field_type + " option").remove();
        $("#" + field_type + "").append('<option value=0>请选择</option>');
        $("#" + field_type + "").append('<option value=1>姓名</option>');
        $("#" + field_type + "").append('<option value=2>手机</option>');
        $("#" + field_type + "").val("<?=$params['field_type']?>");
        $("#field").val("<?=$params['field']?>");
        $('#editpoints').click(function () {
            var size = $('#pointssize').val();
            var contents = $('#pointscontents').val();
            if (!isNaN(size) && contents) {
                var num = $('#pointssize').val();
                var boolCheck = $('#radios2').is(":checked");
                if (boolCheck) {
                    num = 0 - num;
                }
                $.post('index.php?r=Score/score/editscorebyhead', {
                    pri_type_id: 7,
                    sub_type_id: 7,
                    num: num,
                    custom_id: $('#curcustom_id').val(),
                    contents: $('#pointscontents').val()
                }, function (data) {
                    $('#myModal').modal('hide');
                    history.go(0);
                }, 'json');
            } else {
                alert("请输入相关内容!");
            }
        });

        $(".change").on('click',function(){
            var st_id =$(this).parents("tr").attr('id');
            var id ="#"+st_id;
            var st_name = $(id).children("td").eq(0).text();
            var st_class = $(id).children("td").eq(3).text();
            $("#classModalLabel").text(st_name+"由"+st_class);
            $("#definite").on('click',function(){
                var new_class_id = $("#ok").find("option:selected").val();
                var new_class_name =$("#ok").find("option:selected").text();
                //这里进行异步更改数据库内容
                $.post("index.php?r=manage/customs/changeclass",
                    { st_id:st_id,class_id:new_class_id,st_name:st_name,class_name:new_class_name },
                    function(data){
                        alert("换班成功");
                        $("#definite").unbind();
                        $("#classModal").modal('hide');
                        $(id).children("td").eq(3).text(new_class_name).css("color","blue");

                    });
            })
            $("#ggg").on('click',function() {
                $("#definite").unbind();

            })
        });

        //红花绑定统计
        var total = "<?=$params['total']?>";
        var count="<?=$params['rftoken']?>";
        $(".stu_th").children("th").eq(7).text("红花绑定"+"("+count+"/"+total  +")")

    });
</script>
