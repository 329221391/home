<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Custom\models\CustomsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '教师管理';
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
        <section class="panel panel-danger">
            <header class="panel-heading">
                <span>教师管理</span>
            </header>
            <div class="panel-body">
                <form class="form-inline" action="" method="post" style="margin-bottom:15px;">
                    <div class="form-group">
                        <label class="sr-only" for="name_zh"></label>
                        <input type="text" class="form-control" name="name_zh" placeholder="教师名称">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password"></label>
                        <input type="password" class="form-control" name="password" placeholder="密码">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="phone"></label>
                        <input type="text" class="form-control" name="phone" placeholder="手机号">
                    </div>
                    <input type="hidden" name="r" value="manage/class/index"/>
                    <button id="addT" type="submit" class="btn btn-info">添加老师</button>
                    <button type="reset" class="btn btn-warning">重&nbsp;置</button>
                    <div class="pull-right">
                        <div class="form-group">
                            <select id="field_type" name="field_type" class="form-control" style="font-size:13px;">
                            </select>
                            <input type="text" class="form-control" name="field" id="field" placeholder="查找..">
                            <input type="hidden" name="r" value="manage/class/index">
                            <button type="submit" class="btn btn-success">查找</button>
                        </div>
                    </div>

                </form>

                <form id="teacher" class="form-inline" style="margin-bottom:15px;"
                      action="index.php?r=manage/customs/uploadexcel"
                      method="post" enctype="multipart/form-data" onsubmit="return check()">
                    <div class="form-group">
                        <input id="myname" type="file" name="myname" class="form-control" accept=".xlsx">
                        <input type="text" name="role" hidden value="<?= $params['role'] ?>">
                        <input type="text" name="class_id" hidden value="<?= $params['class_id'] ?>">
                        <button type="submit" class="btn btn-success">通过电子表格添加</button>
                        <a href="download/老师信息模板.zip">
                            <button id="downexcel" type="button" class="btn btn-danger">下载用户信息模板</button>
                        </a>
                    </div>
                </form>

                <span><mark style="color:#900;">注意：表格内部分数据点击即可编辑。</mark></span>

                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample"
                           style="margin-top:15px;">
                        <tr style="background:#1caf9a;color:#fff;">
                            <th class="text-center">教师名称</th>
                            <th class="text-center">修改密码</th>
                            <th class="text-center">电话号码</th>
                            <th class="text-center">管理班级</th>
                            <th class="text-center">是否有效</th>
                            <th class="text-center">是否直发</th>
                            <th class="text-center">创建时间</th>
                            <th class="text-center">积分</th>
                            <th class="text-center">操作</th>
                        </tr>
                        <?php foreach ($models as $kk => $vv) { ?>
                            <tr class="text-center">
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
                                <td><?= Html::img('@web/images/' . $vv['iscansend'] . '.png', ['onclick' => "listTable.toggle(this, 'iscansend'," . $vv['id'] . ")"]) ?></td>
                                <td><?= $vv['createtime'] ?></td>
                                <td><?= $vv['points'] ?></td>
                                <td>
                                    <a style="color:#fff;" class="btn btn-xs btn-danger"
                                       href="javascript:if(confirm('确定删除')){window.location.href='index.php?r=manage/customs/delete&id=<?= $vv['id'] ?>';}">删除</a>
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
    <!-- col-sm-12结束 -->
</div><!-- wrapper结束 -->


<?php
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>
<script language="javascript">
    var isadmin = "<?=$params['isadmin']?>";
    if (isadmin) {
        $('#teacher').show();
    }
    function check() {
        if (!$('#myname').val()) {
            alert("请选择电子表格类文件!");
            return false;
        }
        return true;
    }
    var field_type = 'field_type';
    function update(obj, custom_id) {
        var tds = $(obj).parent().parent().find('td');
        $('#curpoints').html(tds.eq(7).text());
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

        var message = "<?=$message?>";
        if(message!="") {
            alert(message);
        }
        $("#addT").on('click',function(e){
            var passWord = $("input[name='password']").val();
            var name_zh=$("input[name='name_zh']").val();
            var phone = $("input[name='phone']").val();
            if(name_zh==""){
                alert("姓名不能为空")
                return false;

            }
            if(passWord==""){
                alert("密码不能为空")
                return false;
            }
            if(passWord.length<6){
                alert("密码至少六位");
                return false;
            }
            if(phone==""){
                alert("电话不能为空")
                return false;
            }
            if(phone.length!=11){
                alert("电话号码位数不对")
                return false;
            }
            if(isNaN(phone)){
                alert("电话号码必须是阿拉伯数字")
                return false;
            }
        })
    });
 </script>
