<?php
use \app\modules\AppBase\base\HintConst;
use \janisto\timepicker\TimePicker;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '活动管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-active/index'])];
$this->params['breadcrumbs'][] = "编辑活动";
?>
<div class="container" style="padding-right:3em;">

    <div style="padding:0.7em;">
        <form action="index.php?r=Stats/zhuanpan-active/edit" method="post">
            <input type="hidden" name="id" value="<?=$active['id'] ?>">
            <div class="form-group">
                <label for="description">描述</label>
                <input class="form-control" id="description" name="description" placeholder="描述" value="<?=$active['description'] ?>">
            </div>

            <div class="form-group">
                <label for="active_start_time">开始时间</label>
                <?= TimePicker::widget([
                    'language' => 'zh-CN',
                    'id' => 's',
                    'name' => 'active_start_time',
                    'value' => date('Y-m-d H:i:s',$active['active_start_time']),
                    'mode' => 'datetime',
                    'clientOptions' => [
                        'dateFormat' => 'yy-mm-dd',
                        'timeFormat' => 'HH:mm:ss',
                        'showSecond' => true,
                    ]
                ]);
                ?>
            </div>

            <div class="form-group">
                <label for="active_end_time">结束时间</label>
                <?= TimePicker::widget([
                    'language' => 'zh-CN',
                    'id' => 'e',
                    'name' => 'active_end_time',
                    'value' => date('Y-m-d H:i:s',$active['active_end_time']),
                    'mode' => 'datetime',
                    'clientOptions' => [
                        'dateFormat' => 'yy-mm-dd',
                        'timeFormat' => 'HH:mm:ss',
                        'showSecond' => true,
                    ]
                ]);
                ?>
            </div>
            <div class="form-group">
                <label for="role">角色</label>
                <select id="role" name="role" class="form-control">
                    <option value="207" <?= $active['role'] == HintConst::$ROLE_HEADMASTER ? 'selected' : '' ?>>园长</option>
                    <option value="208" <?= $active['role'] == HintConst::$ROLE_TEACHER ? 'selected' : '' ?>>老师</option>
                    <option value="209" <?= $active['role'] == HintConst::$ROLE_PARENT ? 'selected' : '' ?>>家长</option>
                </select>
            </div>
            <div class="form-group">
                <label for="role">滚动显示中奖用户信息</label>
                <textarea id="scroll_info" class="form-control" name="scroll_info" rows="5" placeholder="请输入中奖用户信息" ><?= $active['scroll_info'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>

</div>



