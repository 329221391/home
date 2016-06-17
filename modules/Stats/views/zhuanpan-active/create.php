<?php
use \app\modules\AppBase\base\HintConst;
use \janisto\timepicker\TimePicker;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '活动管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-active/index'])];
$this->params['breadcrumbs'][] = "新增活动";
?>
<div class="container" style="padding-right:3em;">


    <div style="padding:0.7em;">
        <form action="index.php?r=Stats/zhuanpan-active/create" method="post">
            <div class="form-group">
                <label for="description">描述</label>
                <input class="form-control" id="description" name="description" placeholder="描述">
            </div>

            <div class="form-group">
                <label for="active_start_time">开始时间</label>
                <?= TimePicker::widget([
                    'language' => 'zh-CN',
                    'id' => 's',
                    'name' => 'active_start_time',
                    'value' => '开始时间',
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
                    'value' => '结束时间',
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
                    <option value="0">请选择</option>
                    <option value="207">园长</option>
                    <option value="208">老师</option>
                    <option value="209">家长</option>
                </select>
            </div>
            <div class="form-group">
                <label for="role">滚动显示中奖用户信息</label>
                <textarea id="scroll_info" name="scroll_info" rows="5" class="form-control" ></textarea>
            </div>
            <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>

</div>



