<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/css/bootstrap.min.css') ?>
<?= Html::cssFile('@web/css/mobile/base.css') ?>
<?= Html::cssFile('@web/css/mobile/prize.css') ?>
<script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

<div class="header" style="z-index: 9999">
    <div class="title">填写发货单</div>
</div>
<div class="container padding">
    <div style="height:50px;"></div>

    <form action="index.php?r=Prize/prize/deliver" id="shippingInfo" method="post">
    <input type="hidden" name="post_type" value="<?= $post_type ?>"></input>
    	
    		<div class="form-group">
		    <label for="shipping_address">收货地址</label>
		    <input type="text" class="form-control" id="shipping_address" name="shipping_address" value="<?= $shipping['shipping_address']?>" placeholder="请输入收货地址">
		  </div>
		  <div class="form-group">
		    <label for="person_name">用户名</label>
		    <input type="text" class="form-control" id="person_name" name="person_name" value="<?= $shipping['username']?>" placeholder="请输入用户名">
		  </div>
		  <div class="form-group">
		    <label for="mobile">手机号码</label>
		    <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $shipping['mobile']?>" placeholder="请输入手机号">
		  </div>
		  <div class="form-group">
		    <label for="zipcode">邮编</label>
		    <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?= $shipping['zipcode']?>" placeholder="请输入数字">
		  </div>
		  <button type="button" id="submit1" class="btn btn-default"><lacel>提交收货信息</lacel></button>
	</form>

	<script type="text/javascript">
	/*function sleep(ms){
		var now = new Date().gitTime();
		var exitTime = now + ms;
		while()
	}*/

		$(function(){
			$("#submit1").click(function(){

				if($("#shipping_address").val()=='') {
					alert('收货地址不能为空！');
					return;
				}else if ($("#person_name").val()=='') {
					alert("用户名不应为空！");
					return;
				}else if($("#mobile").val()==''){
					alert('手机号码不应为空！')
					return;
				}else if ($("#zipcode").val()=='' || isNaN($("#zipcode").val())) {
					alert('您输入的邮编格式不正确');
					return;
				} else {
					if (<?= $save_shipping_flag?> == 1) {
						if (confirm('是否保存当地址？')) {
							$.ajax({
								url: "index.php?r=Prize/prize/save",
								type: 'POST',
								data: {
									shipping_address:$("#shipping_address").val(),
									username:$("#person_name").val(),
									mobile:$("#mobile").val(),
									zipcode:$("#zipcode").val(),
								},
								async: false,
								cache: false,
								dataType: 'json',
								success: function(data){
								}
							});



							$("#shippingInfo").submit();
						}
					} $("#shippingInfo").submit();
				}
			});
		});
	</script>
	</div>
</div>