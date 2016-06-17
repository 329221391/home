<?php
use yii\helpers\Html;

$this->title = '学校信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<script language="javascript">
    var edit_url = 'index.php?r=manage/school/edit-school';
    var edit_url2 = 'index.php?r=manage/school/edit-custom';
</script>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.js') ?>
<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-info">
            <header class="panel-heading">
                <span>学校信息</span>
                <!-- <span class="btn btn-info pull-right">
                    <a href="#">编辑</a>
                </span> -->
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table">
                    <!-- <div class="space15"></div> -->
                    <table class="table table-striped table-hover table-bordered" id="editable-sample"
                           style="margin-top:20px;">
                        <tr>
                            <th width="20%;">学校名称</th>
                            <td><span name="edit" title="编辑"
                                      onclick="listTable.edit(this, 'name', 12,edit_url)"><?= $school['name'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%;">学校码</th>
                            <td><?= $school['code'] ?></td>
                        </tr>
                        <tr>
                            <th width="20%;">联系电话</th>
                            <td><span name="edit" title="编辑"
                                      onclick="listTable.edit(this, 'tel', 12,edit_url)"><?= $school['tel'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%;">QQ</th>
                            <td><span name="edit" title="编辑"
                                      onclick="listTable.edit(this, 'qq', 12,edit_url)"><?= $school['qq'] ?></span></td>
                        </tr>
                        <tr>
                            <th width="20%;">邮箱</th>
                            <td><span name="edit" title="编辑"
                                      onclick="listTable.edit(this, 'email', 12,edit_url)"><?= $school['email'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%;">地址</th>
                            <td><span name="edit" title="编辑"
                                      onclick="listTable.edit(this, 'address', 12,edit_url)"><?= $school['address'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%;">创建时间</th>
                            <td><?= $school['createtime'] ?></td>
                        </tr>
                    </table>
                </div>
                <!-- adv-table结束 -->
                <span><mark style="color:#900;">注意：表格内部分数据点击即可编辑。</mark></span>
            </div>
            <!-- panel-body结束 -->
        </section>

        <section class="panel panel-warning">
            <header class="panel-heading">
                <span>园长信息</span>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample"
                           style="margin-top:20px;">
                        <tr>
                            <th width="20%;">园长姓名</th>
                            <td><span name="edit" title="编辑"
                                      onclick="listTable.edit(this, 'name_zh', 12,edit_url2)"><?= $master['name_zh'] ?>
                                    <!-- <span class="glyphicon glyphicon-edit"></span> -->
                            		</span></td>
                        </tr>
                        <tr>
                            <th width="20%;">园长电话</th>
                            <td><span name="edit" title="编辑"
                                      onclick="listTable.edit(this, 'phone', 12,edit_url2)"><?= $master['phone'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%;">修改密码</th>
                            <td><span name="edit" title="编辑" onclick="listTable.edit(this, 'password', 12,edit_url2)">点击修改密码</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- adv-table结束 -->
                <span><mark style="color:#900;">注意：表格内数据点击即可编辑。</mark></span>
            </div>
            <!-- panel-body结束 -->
        </section>
    </div>
    <!-- col-*结束 -->
</div><!-- wrapper结束 -->
<script language="javascript">
    $("span[name='edit']").each(function () {
        if (!$(this).text()) {
            $(this).text('没有信息哦!');
        }
    });
</script>