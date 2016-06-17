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
    <form action="index.php?r=zhaopin/post" method="post" class="form-horizontal" onsubmit="return checkForm()">
        <input type="hidden" name="zhaopin_id" value="<?= $zhaopin_id ?>">
        <div class="form-group">
            <label class="col-sm-2 control-label">姓名</label>
            <div class="col-sm-10">
                <input id="person_name" name="person_name" class="form-control" placeholder="输入姓名">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">年龄</label>
            <div class="col-sm-10">
                <input id="age" name="age" class="form-control"  placeholder="输入年龄">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">电话</label>
            <div class="col-sm-10">
                <input id="mobile" name="mobile" class="form-control"  placeholder="请输入手机号码" max="11">
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
        var person_name = $('#person_name').val();
        var mobile = $('#mobile').val();
        var age = $('#age').val();

        if(person_name == ''){
            alert('姓名不能为空');
            return false;
        }
        if(mobile == ''){
            alert('手机号码不能为空');
            return false;
        }
        if(isNaN(mobile)){
            alert('手机号码不合法');
            return false;
        }
        if(isNaN(age)){
            alert('年龄不合法');
            return false;
        }
        return true;
    }
</script>



