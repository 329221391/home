<?php
use \app\modules\AppBase\base\HintConst;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '奖品管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-goods/index'])];
$this->params['breadcrumbs'][] = "奖品管理";
?>
<div class="container" style="padding-right:3em;">

    <div>
        <a href="index.php?r=Stats/zhuanpan-goods/create" class="btn btn-success">新增奖品</a>
    </div>

    <div style="padding-right:0.7em;">
        <table class="table table-striped table-hover table-bordered">
            <tr style="background:#5bc0de;color:#fff;">
                <th class="text-center">图片</th>
                <th class="text-center">商品名称</th>
                <th class="text-center">值</th>
                <th class="text-center">状态</th>
                <th class="text-center">类型</th>
                <th class="text-center">品牌</th>
                <th class="text-center">数量</th>
                <th class="text-center">用途</th>
                <th class="text-center">操作</th>
            </tr>

            <?php foreach ($zhuanpan_goods as $k => $v) { ?>
                <tr class="text-center">
                    <td><img src=<?= $v['image']?>  ></img></td>
                    <td><?= $v['goods_name'] ?></td>
                    <td><?= $v['value'] ?></td>
                    
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
                    <td><?= $v['count'] ?></td>
                    <td><?= $v['purpose'] ?></td>
                    <td><a href="index.php?r=Stats/zhuanpan-goods/edit&id=<?=$v['id']?>">编辑</a> | <a href="index.php?r=Stats/zhuanpan-goods/delete&id=<?=$v['id'] ?>">删除</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>



