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
			<form id="search" method="get" action="index.php?r=Stats/prize-goods/index">
				<input type="hidden" name="r" value="Stats/prize-goods/index"></input>
				<div style="margin: 25px; width: 30%; height: 130px; float: left">
					<p><h4>获奖人信息</h4></p>
					<p>获奖人：<input id="name_zh" type="text" name="name_zh" value="<?= $params['name_zh']?>"></input></p>
					<p>手机号：<input id="phone" type="text" name="phone" value="<?= $params['phone']?>"></input></p>
				</div>

			  	<div id='goods_list' style="margin: 25px; width: 50%; height: 50px; float: left" >
			  		<select name="goods_name" >
			  			<option value ="">请选择奖品</option>
			  			
			  			<?php foreach ($params['goods_list'] as $goods) { ?>
			  				<option value ="<?= $goods['goods_name']?>" <?php echo $goods['goods_name'] == $params['goods_name'] ? 'selected' : '' ?> "><?= $goods['goods_name']?></option>
			  			<?php } ?> 		
					</select>
			  	</div>
			  		<input type="submit" style=" position: absolute; left:50%;margin-top: 100px; width: 60px; height: 30px;" value="搜索"></input>
			</form>
		</div>
	</br>

	<div style="padding-right:2.7em; margin-top: 140px ">

			<table class="table table-striped table-hover table-bordered">
				<tr style="background:#5bc0de;color:#ffffff;">
					<th class="text-center">图片</th>
					<th class="text-center">获奖人</th>
					<th class="text-center">手机号</th>
					<th class="text-center">奖品名称</th>
					<th class="text-center">品牌</th>
					<th class="text-center">用途</th>
					<th class="text-center">获奖时间</th>
					<th class="text-center">活动</th>
				</tr>
				<?php foreach($list as $item){ ?>
				<tr>
					<td class="text-center" ><?= $item['image']?></td>
					<td class="text-center" ><?= $item['name_zh']?></td>
					<td class="text-center" ><?= $item['phone']?></td>
					<td class="text-center" ><?= $item['goods_name']?></td>
					<td class="text-center" ><?= $item['brand']?></td>
					<td class="text-center" ><?= $item['purpose']?></td>
					<td class="text-center" ><?= date('Y年m月d日 H:i:s', $item['create_time']) ?></td>
					<td class="text-center" ><?= $item['description']?></td>
				</tr>
				<?php  } ?>
			</table>
			<div class="pull-right" id="pagination" >
				<?php
				echo LinkPager::widget([
				    'pagination' => $pages,
				]);
			?>
			</div>
	</div>

	</body>
</html>