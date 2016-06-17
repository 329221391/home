<?php
use yii\helpers\Html;
$this->context->layout='mobile_layout';
$this->title = '报名';
?>
<?= Html::cssFile('@web/css/mobile/zhaosheng.css') ?>
<div class="header">
    <div class="title">报名</div>
</div>

<div class="padding">
    <div style="height:50px;"></div>
    <form action="index.php?r=zhaosheng/post" method="post" class="form-horizontal" onsubmit="return checkForm()">
        <input type="hidden" name="zhaosheng_id" value="<?= $zhaosheng_id ?>">
        <div class="form-group">
            <label class="col-sm-2 control-label">宝宝姓名</label>
            <div class="col-sm-10">
                <input id="baby_name" name="baby_name" class="form-control" placeholder="输入姓名">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">宝宝年龄</label>
            <div class="col-sm-10">
                <input id="baby_age" name="baby_age" class="form-control"  placeholder="输入年龄">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">家长姓名</label>
            <div class="col-sm-10">
                <input id="parent_name" name="parent_name" class="form-control"  placeholder="输入姓名">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">家长号码</label>
            <div class="col-sm-10">
                <input id="parent_mobile" name="parent_mobile" class="form-control"  placeholder="输入号码" maxlength="11">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success btn-block">提交报名</button>
            </div>
        </div>
    </form>
</div>
<script>
    function checkForm(){
        var baby_name = $('#baby_name').val();
        var baby_age = $('#baby_age').val();
        var parent_name = $('#parent_name').val();
        var parent_mobile = $('#parent_mobile').val();
        if(baby_name == ''){
            alert('宝宝姓名不能为空');
            return false;
        }
        if(isNaN(baby_age)){
            alert('宝宝年龄必须是数字');
            return false;
        }
        if(baby_age > 10 || baby_age < 0){
            alert('宝宝年龄必须是1到10岁');
            return false;
        }
        if(parent_name == ''){
            alert('家长姓名不能为空');
            return false;
        }
        if(parent_mobile == ''){
            alert('手机号码不能为空');
            return false;
        }
        if(isNaN(parent_mobile)){
            alert('手机号码不合法');
            return false;
        }
        return true;
    }
</script>



