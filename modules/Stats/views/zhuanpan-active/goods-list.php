<?php
use \app\modules\AppBase\base\HintConst;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '活动管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-active/index'])];
$this->params['breadcrumbs'][] = "管理奖品";
?>
<div class="container" style="padding-right:3em;">

    <div>
        <a href="index.php?r=Stats/zhuanpan-active/add-goods&zhuanpan_active_id=<?= $zhuanpan_active_id ?>" class="btn btn-success">新增奖品</a>
    </div>

    <div style="padding-right:0.7em;">
        <table class="table table-striped table-hover table-bordered">
            <tr style="background:#5bc0de;color:#fff;">
                <th>商品名称</th>
                <th>值</th>
                <th>位置</th>
                <th>状态</th>
                <th>类型</th>
                <th>品牌</th>
                <th>概率</th>
                <th>数量</th>
                <th>操作</th>
            </tr>

            <?php foreach ($zhuanpan_goods as $k => $v) { ?>
                <tr>
                    <td><?= $v['goods_name'] ?></td>
                    <td><?= $v['value'] ?></td>
                    <td>位置<?= $v['position'] ?></td>
                    <td>
                        <?php
                        switch($v['used']){
                            case 0:
                                echo '启用';
                                break;
                            case 1:
                                echo '禁用';
                                break;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        switch($v['type']){
                            case 0:
                                echo '实物';
                                break;
                            case 1:
                                echo '积分';
                                break;
                            case 2:
                                echo '空奖';
                                break;
                            case 3:
                                echo '邮费';
                                break;
                        }
                        ?>
                    </td>
                    <td><?=$v['brand'] ?></td>
                    <td><?= sprintf('%2.2f',($v['v']/$base_num) * 100) ?>%</td>
                    <td><?= $v['count'] ?></td>

                    <td><a href="index.php?r=Stats/zhuanpan-active/edit-goods&goods_active_id=<?=$v['goods_active_id']?>">编辑</a> | 
                        <a href="index.php?r=Stats/zhuanpan-active/delete-goods&goods_active_id=<?=$v['goods_active_id']?>">删除</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>
