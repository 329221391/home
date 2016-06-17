<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/css/bootstrap.min.css') ?>
<?= Html::cssFile('@web/css/mobile/base.css') ?>


<div class="header">
    <div class="title">收货地址</div>
</div>
<div class="padding">
    <div style="height:50px;"></div>
</div>
<div style="padding:10px; background: #fff">
    <form class="form-horizontal" action="index.php?r=Prize/prize/save" method="post" onsubmit="return onSubmit()">
        <input type="hidden" name="prize_log_id" value="<?=$prize_log_id ?>">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">收货地址</label>
            <div class="col-sm-10">
                <input type="text" name="shipping_address" value="<?=$prize_log['shipping_address'] ?>" class="form-control" id="shipping_address" placeholder="如:北京市朝阳区xxxxx路xx号" style="height:45px !important;">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">收货人</label>
            <div class="col-sm-10">
                <input type="text" name="person_name" value="<?=$prize_log['person_name'] ?>" class="form-control" id="person_name" placeholder="真实的收货人姓名" style="height:45px !important;">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">电话</label>
            <div class="col-sm-10">
                <input type="text" name="mobile" value="<?=$prize_log['mobile'] ?>" class="form-control" id="mobile" placeholder="183xxxxxxxx" style="height:45px !important;">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">邮政编码</label>
            <div class="col-sm-10">
                <input type="text" name="zipcode" value="<?=$prize_log['zipcode'] ?>" class="form-control" id="zipcode" placeholder="000000" style="height:45px !important;">
            </div>
        </div>

        <div class="form-group">
            <div class=" col-sm-12">
                <button type="submit" class="btn btn-success btn-block" style="padding:12px !important;">确认提交</button>
            </div>
        </div>
    </form>
</div>

<script>
    function onSubmit(){

        var shipping_address = $('#shipping_address');
        var person_name = $('#person_name');
        var mobile = $('#mobile');
        var zipcode = $('#zipcode');
        if(shipping_address.val() == ''){
            alert('请填写收货地址');
            return false;
        }
        if(person_name.val() == ''){
            alert('请填写收货人姓名');
            return false;
        }
        if(mobile.val() == ''){
            alert('请填写电话号码');
            return false;
        }

        return true;
    }
</script>