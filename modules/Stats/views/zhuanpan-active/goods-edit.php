<?php
use \app\modules\AppBase\base\HintConst;
use \janisto\timepicker\TimePicker;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '活动管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-active/index'])];
$this->params['breadcrumbs'][] = "添加奖品";
?>
<div class="container" style="padding-right:3em;">
     <div style="padding:0.7em;">

        <form action="index.php?r=Stats/zhuanpan-active/edit-goods" method="post">
        	<input type="hidden" name="goods_active_id" value="<?=$zhuanpan_goods_active['goods_active_id'] ?>">
            <div class="form-group">
                <label for="description">选择商品</label>
                <select id="goods_id" name="goods_id" class="form-control">
                    <?php foreach($zhuanpan_goods_list as $goods){ ?>
                    <option <?= $goods['id'] == $zhuanpan_goods_active['goods_id'] ? 'selected' : '' ?> value="<?=$goods['id'] ?>"><?=$goods['goods_name'] ?></option>
                    <?php } ?>
                    
                </select>
            </div>

            <div class="form-group">
                <label for="active_start_time">机率值</label>
                <input class="form-control" id="v" name="v" placeholder="0-<?=$left_v ?>" value="<?=$zhuanpan_goods_active['v'] ?>">
                <p class="help-block">目前可用的机率值:<?=$left_v ?></p>
                <p class="help-block">[100%=100000] [10%=10000] [1%=1000] [0.1%=100] [0.001%=10] [0.0001%=1]</p>
            </div>

            <div class="form-group">
                <label for="description">位置</label>
                <select id="position" name="position" class="form-control">
                    <option value="<?= $zhuanpan_goods_active['position'] ?>" selected >位置<?= $zhuanpan_goods_active['position'] ?></option>
                    
                    <?php foreach ($position_arr as $key => $value) { ?>
                        <option value="<?=$value?>" <?= $value==$zhuanpan_goods_active['position'] ? 'selected' : '' ?> >位置<?=$value?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="active_start_time">数量</label>
                <input class="form-control" id="count" name="count" value="<?=$zhuanpan_goods_active['count'] ?>" placeholder="请输入数量">
            </div>

            <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
<!-- <div style=" text-align: center; ">
       <img id="yuanpan" src="images/zhuanpan/1/yuanpan_.png" style="width: 200px;height: 200px " />
</div> -->




