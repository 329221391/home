<?php
use \app\modules\AppBase\base\HintConst;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '活动管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-active/index'])];
$this->params['breadcrumbs'][] = "活动管理";

?>
<div class="container" style="padding-right:3em;">

    <div>
        <a href="index.php?r=Stats/zhuanpan-active/create" class="btn btn-success">新增活动</a>
    </div>

    <div style="padding-right:0.7em;">
        <table class="table table-striped table-hover table-bordered">
            <tr style="background:#5bc0de;color:#fff;">
                <th>描述</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>状态</th>
                <th>角色</th>
                <th>操作</th>
            </tr>

            <?php foreach ($active_list as $k => $v) { ?>
                <tr>
                    <td><?= $v['description'] ?></td>
                    <td><?= date('Y-m-d H:i:s',$v['active_start_time']) ?></td>
                    <td><?= date('Y-m-d H:i:s',$v['active_end_time']) ?></td>
                    <td>
                         <?php
                            if ($current_time <= $v['active_start_time']) {
                                echo "活动尚未开始";
                            } else if ($current_time >= $v['active_start_time'] && $current_time <= $v['active_end_time']) {
                                echo "活动正在进行";
                            } elseif ($current_time >= $v['active_end_time']) {
                                echo "活动已经结束";
                            }
                         ?>
                    </td>
                    <td><?php
                        switch($v['role']){
                            case HintConst::$ROLE_HEADMASTER:
                                echo '园长';
                                break;
                            case HintConst::$ROLE_TEACHER:
                                echo '老师';
                                break;
                            case HintConst::$ROLE_PARENT:
                                echo '家长';
                                break;
                            default:
                                echo '未指定';
                                break;
                        }
                        ?></td>
                    <td><a href="index.php?r=Stats/zhuanpan-active/goods-list&id=<?=$v['id']?>">管理商品</a> | <a href="index.php?r=Stats/zhuanpan-active/edit&id=<?=$v['id'] ?>">编辑</a> | <a href="index.php?r=Stats/zhuanpan-active/delete&id=<?= $v['id'] ?>">删除</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>



