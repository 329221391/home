<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
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

<table class="gridtable">
	<tr>
		<th>订单号</th>
		<th>发货开始时间</th>
		<th>发货结束时间</th>
	</tr>
		<tr>
			<td><?= $list['id'] ?></td>
			<td><?= $list['shipping_start_time'] ?></td>
			<td><?= $list['shipping_end_time'] ?></td>
		</tr>

</table>