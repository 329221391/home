<?php
$this->context->layout='empty';
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="viewport" content="initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>积分兑换邮费</title>
    <link href="/assets/c54a4d26/css/bootstrap.css" rel="stylesheet">
    <link href="/css/mobile/base.css" rel="stylesheet">
</head>
<body>


	
	<label>兑换规则：100积分兑换1元邮费</label><br>
	<?=$custom_name?>园长的积分总数：<?= $score?><br>
	<?=$custom_name?>园长"获奖的邮费券"总数：<?= $prizePostage?><br>
	
	<?=$custom_name?>园长"输入的邮费"数为：<?= $exPostage?><br>
	<form id="exchangePostage" method="post" action="index.php?r=zhuan-pan/exchange-postage">
		<?=$custom_name?>要兑换的积分数<input id="coins" type="text" name="exPostage"></input><br>
		<input type="submit" value="提交"></input>
	</form>
</body>
</html>