<?php
use yii\widgets\LinkPager;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '大转盘'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/shipping/index'])];
$this->params['breadcrumbs'][] = "奖品发货管理";
?>


<html>
	<head>
		<title>Custom List</title>
		<meta charset="UTF-8" />
		<script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	</head>

	<body>
		<div style="width: 92.5%; height: 150px; float: top;position: absolute; ">
			<form id="search" method="get" action="index.php?r=Stats/shipping/index">
				<input type="hidden" name="r" value="Stats/shipping/index">
				<div style="margin: 25px; width: 30%; height: 130px; float: left">
					<p><h4>获奖人信息</h4></p>
					<p>获奖人：<input id="name_zh" type="text" name="name_zh" value="<?= $params['name_zh'] ?>"></input></p>
					<p>手机号：<input id="mobile_phone" type="text" name="mobile_phone" value="<?= $params['mobile_phone'] ?>"></input></p>
				</div>

				<!--设置select元素显示-->
				
			  	<div id='goods_list' style="margin: 25px; width: 20%; height: 130px; float: right" >
			  		<select name="goods_name" >
			  			<option id="default" value="" >请选择奖品</option>
			  		<?php foreach ($goods_list as $goods) { ?>
			  			<option value ="<?= $goods['goods_name']?>" <?php echo $goods['goods_name'] == $goods_name ? 'selected' : ''  ?> ><?= $goods['goods_name']?></option>
			  		<?php } ?> 	 		
					</select>
			  	</div>

				<div style="margin: 25px; width: 30%; height: 130px; float: right">
					<p><h4>收货人信息</h4></p>
					<p>收货人：<input id="shipping_person_name" type="text" name="shipping_person_name" value="<?= $params['shipping_person_name'] ?>"></input></p>
					<p>手机号：<input id="shipping_mobile" type="text" name="shipping_mobile" value="<?= $params['shipping_mobile'] ?>"></input></p>
				</div>
			  		<input type="submit" style=" position: absolute; left:80%;margin-top: 100px; width: 60px; height: 30px;" value="搜索"></input>


			</form>
		</div>			
	</br>

	<div style="padding-right:2.7em; margin-top: 140px ">
<input type="button" value="批量发货" id="multi_change"></input></th>
			<table class="table table-striped table-hover table-bordered" >
				
				<tr style="background:#5bc0de;color:#ffffff;">
					<th><input type="checkbox" id="check_all">全选</input></th>
					<th class="text-center">获奖人</th>
					<th class="text-center">订单号</th>
					<th class="text-center">奖品</th>
					<th class="text-center">数量</th>
					<th class="text-center">收货人</th>
					<th class="text-center">收货电话</th>
					<th class="text-center">收货地址</th>
					<th class="text-center">发货类型</th>
					<th class="text-center">状态</th>
					<th class="text-center">操作</th>
				</tr>
				<?php foreach($list as $item){ ?>
				<tr>
					<td><input id="fahuo" class="check_ids" name="ids[]" type="checkbox" value="<?=$item['order_id'] ?>"></input></td>
					<td><?=$item['name_zh'] ?></td>
					<td><?=$item['order_id'] ?></td>
					<td><?=$item['goods_name'] ?></td>
					<td><?=$item['count'] ?></td>
					<td><?=$item['person_name'] ?></td>
					<td><?=$item['mobile'] ?></td>
					<td><?=$item['shipping_address'] ?></td>
					<td><?php echo $item['post_type'] == 1 ? '货到付款' : '使用邮费券' ?></td>
					<td style="background: <?php echo $item['status'] == 1 ? "#00ff00" : "gray" ?>; ">
					<span class="tbr_prize_status_<?=$item['order_id'] ?>"><?php if ($item['status'] == 0) {
						echo '未发货';
						} else echo '已发货'; ?>
					<span>
					</td>
					<td><a id=detail href="index.php?r=Stats/shipping/detail&id=<?=$item['id'] ?>" target="_blank" style="border-right: 1px solid gray">详情</a>
						<a id="closeBtn" href="index.php?r=Stats/shipping/close&id=<?=$item['id'] ?>" >关闭</a>
						</td>
				</tr>
				<?php  } ?>
			</table>
			<div class="pull-right" id="pagination" >
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
				$.post('index.php?r=Stats/shipping/change-state',{'ids':ids},function(serverData){
					if(serverData.ErrCode == 0){
						for(var i=0;i<ids.length;i++){
							$('.tbr_prize_status_'+ids[i]).text('已发货');
							$('.tbr_prize_status_'+ids[i]).parents('td').css('background','#00ff00');
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