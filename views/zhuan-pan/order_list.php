<?php
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <table border="2">
        <?php foreach($order_list as $order){ ?>
        <tr>
            <td><?=$order['order_id'] ?></td>
            <td><?=$order['goods_name'] ?></td>
            <td><?=$order['person_name'] ?></td>
            <td><?=$order['mobile'] ?></td>
            <td><?=$order['shipping_address'] ?></td>
            <td><?=$order['status']==0 ? '未发货' : '已发货' ?></td>
            <td><?=date('Y-m-d H:i',$order['create_time']) ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>