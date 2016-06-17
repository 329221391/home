<?php
	Yii::$app->request->get('list',0);
?>

<style type="text/css">
#goods{
	background: #adadad;
	width: 100%;
	height: 25px;
	text-align: center;
}
label{
		background: #adcdef;
		width: 120px;
		height: 25px;
		float: left;
		text-align: center;
	}

</style>
<div id="goods"><h3>奖品详情</h3></div>

	<ul>
		<li><label>订单号: </label><?=$list['order_id'] ?></li>
	</ul>
	<ul>
		<li><label>获奖人: </label><?=$list['name_zh'] ?></li>
	</ul>
	<ul>
		<li><label>获奖人电话: </label><?=$list['phone'] ?></li>
	</ul>
	<ul>
		<li><label>奖品: </label><?=$list['goods_name'] ?></li>
	</ul>
	<ul>
		<li><label>数量: </label><?=$list['count'] ?></li>
	</ul>
	<ul>
		<li><label>品牌: </label><?=$list['brand'] ?></li>
	</ul>
	<ul>
		<li><label>用途: </label><?=$list['purpose'] ?></li>
	</ul>
		<ul>
		<li><label>获奖时间: </label><?=$list['create_time'] ?></li>
	</ul>
	<ul>
		<li><label>奖品收货人: </label><?=$list['person_name'] ?></li>
	</ul>
		<ul>
		<li><label>收货电话: </label><?=$list['mobile'] ?></li>
	</ul>
	<ul>
		<li><label>状态: </label><?php if ($list['status'] == 0) {
						echo '未发货';
					} else echo '已发货';
					?></li>
	</ul>
	<ul>
		<li><label>收货地址: </label><?=$list['shipping_address'] ?></li>
	</ul>
	<ul>
		<li><label>邮编: </label><?=$list['zipcode'] ?></li>
	</ul>
	<ul>
		<li><label>抽奖活动: </label><?=$active_name['description'] ?></li>
	</ul>
	<ul>
		<li><label>发货开始时间: </label><?=$list['shipping_start_time'] ?></li>
	</ul>
	<ul>
		<li><label>发货结束时间: </label><?=$list['shipping_end_time'] ?></li>
	</ul>
