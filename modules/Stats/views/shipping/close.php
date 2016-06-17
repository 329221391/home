<?php
use yii\widgets\LinkPager;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '大转盘'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/shipping/index'])];
$this->params['breadcrumbs'][] = "关闭";
?>

<table class="table table-striped table-hover table-bordered">
	<tr style="background:#5bc0de;color:#ffffff;">
		<th class="text-center">订单号</th>
		<th class="text-center">发货开始时间</th>
		<th class="text-center">发货结束时间</th>
	</tr>
		<tr>
			<td class="text-center"><?= $list['id'] ?></td>
			<td class="text-center"><?= date('Y年m月d号 H点i分',$list['shipping_start_time']) ?></td>
			<td class="text-center"><?= date('Y年m月d号 H点i分', $list['shipping_end_time']) ?></td>
		</tr>

</table>