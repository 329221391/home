<?php
use yii\widgets\LinkPager;
?>

<style type="text/css">
#goods_list{text-align: center;  margin: 25px; position: absolute;
	left: 350px; width: 300px; top: 30px; height: 200px}
#submit{position: absolute; left: 50%; top: 150px}
#pagination{
	position: absolute;
	margin-top: 440px;
	margin-left: 440px;
}
#table{
	width: 100%;
	height: 550px;
	background: #f0f0f0;
}
#multi_change{
	position: absolute;
	margin-top: 4px;
	margin-left: 150px;
}
table.gridtable {
	margin-top: 30px;
	margin-left: 150px;
	position: absolute;
	float: center;
	font-family: verdana,arial,sans-serif;
	font-size:15px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>

<html>
	<head>
		<title>Custom List</title>
		<meta charset="UTF-8" />
		<script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	</head>

	<body>
		<div style="background:#f0f0f0; width: 100%; height: 250px; float: top">
			<form id="search" method="get" action="Admin/shipping/index">
				<input type="hidden" name="r" value="Admin/shipping/index">
				<div style="margin: 25px; width: 30%; height: 200px; float: left">
					<p><h3>获奖人信息</h3></p>
					<p>获奖人：<input id="name_zh" type="text" name="name_zh" value="<?= $params['name_zh'] ?>"></input></p>
					<p>手机号：<input id="mobile_phone" type="text" name="mobile_phone" value="<?= $params['mobile_phone'] ?>"></input></p>
				</div>

				<!--设置select元素显示-->
				<script type="text/javascript">
					$(function(){
						var a="<?= $goods_name?>";
						if (!a) {
							$("#default").html('请选择奖品');
							return;
						}
					});
				</script>
			  	<div id='goods_list' >
			  		<select name="goods_name" >
			  			<option value ="" id="default"><?= $goods_name?></option>
			  			<option value ="iPad">iPad</option>
			  			<option value ="iPhone">iPhone</option>
			  			<option value ="Lenvo">Lenvo</option>
			  			<option value ="MP3">MP3</option>
			 	 		<option value="鼠标">鼠标</option>
			 	 		<option value="键盘">键盘</option>
						<option value="邮费">邮费</option>
			 	 		<option value="空奖">空奖</option>
			 	 		<option value="50积分">50积分</option>			 	 		
					</select>
			  	</div>

				<div style="margin: 25px; width: 30%; height: 200px; float: right">
					<p><h3>收货人信息</h3></p>
					<p>收货人：<input id="shipping_person_name" type="text" name="shipping_person_name" value="<?= $params['shipping_person_name'] ?>"></input></p>
					<p>手机号：<input id="shipping_mobile" type="text" name="shipping_mobile" value="<?= $params['shipping_mobile'] ?>"></input></p>
				</div>
			  	<div id="submit" >
			  		<input type="submit" style="width: 100px;height: 40px" value="搜索"></input>
			  	</div>
			</form>
			</div>
			<hr/>

		<div id="table">

			<table class="gridtable">
				<input type="button" value="批量发货" id="multi_change"></input></th>
				<tr>
					<th><input type="checkbox" id="check_all" >全选</input></th>
					<th>获奖人</th>
					<th>订单号</th>
					<th>奖品</th>
					<th>数量</th>
					<th>收货人</th>
					<th>收货电话</th>
					<th>收货地址</th>
					<th>状态</th>
					<th>获奖时间</th>
					<th>操作</th>
				</tr>
				<?php foreach($list as $item){ ?>
				<tr>
					<td><input id="fahuo" class="check_ids" name="ids[]" type="checkbox" value="<?=$item['id'] ?>"></input></td>
					<td><?=$item['name_zh'] ?></td>
					<td><?=$item['order_id'] ?></td>
					<td><?=$item['goods_name'] ?></td>
					<td><?=$item['count'] ?></td>
					<td><?=$item['person_name'] ?></td>
					<td><?=$item['mobile'] ?></td>
					<td><?=$item['shipping_address'] ?></td>

					<td><span class="tbr_prize_status_<?=$item['id'] ?>"><?php if ($item['status'] == 0) {
						echo '未发货';
					} else echo '已发货';
					?><span></td>

					<td><?= date('Y年m月d号 H点i分',$item['create_time']) ?></td>
					<td><a id=detail href="index.php?r=Admin/shipping/detail&id=<?=$item['id'] ?>" target="_blank" style="border-right: 1px solid gray">详情</a>
						<a id="closeBtn" href="index.php?r=Admin/shipping/close&id=<?=$item['id'] ?>" >关闭</a>
						</td>
				</tr>
				<?php  } ?>
			</table>
			<div id="pagination" >
				<?php
				echo LinkPager::widget([
				    'pagination' => $pages
				]);
			?>
			</div>
			
		</div>

	</body>

	<script>
		$(function(){
			$("#check_all").click(function(){  
			    $('.check_ids').prop("checked",$('#check_all').prop("checked"));
			});
		});
		
	</script>

	<script>
		$(function(){
			$('#multi_change').click(function(){
				var ids = Array();
				$('.check_ids:checked').each(function(){
					ids.push($(this).val());
				});
				if(ids.length == 0){
					return;
				}
				$.post('index.php?r=Admin/shipping/change-state',{'ids':ids},function(serverData){
					if(serverData.ErrCode == 0){
						for(var i=0;i<ids.length;i++){
							$('.tbr_prize_status_'+ids[i]).text('已发货');
						}
					}else{
						alert(serverData.Message);
						return;
					}
				},'json');
			});
		});
	</script>
</html>