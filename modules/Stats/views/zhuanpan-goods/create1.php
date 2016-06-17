<?php
use \app\modules\AppBase\base\HintConst;
use \janisto\timepicker\TimePicker;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '活动管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-active/index'])];
$this->params['breadcrumbs'][] = "添加奖品";
?>
<div class="container" style="padding-right:3em;">
     <div style="padding:0.7em;">

        <form action="index.php?r=Stats/zhuanpan-active/create1" method="post">
        	<input type="hidden" name="zhuanpan_active_id" value="<?=$zhuanpan_active_id ?>" />
            <div class="form-group">
                <label for="description">选择商品</label>
                <select id="goods_id" name="goods_id" class="form-control">
                    <option value="0">请选择</option>
                    <?php foreach($zhuanpan_goods_list as $goods){ ?>
                    <option value="<?=$goods['id'] ?>"><?=$goods['goods_name'] ?></option>
                    <?php } ?>
                    
                </select>
            </div>

            <div class="form-group">
                <label for="active_start_time">机率值</label>
                <input class="form-control" id="v" name="v" placeholder="0-<?=$left_v ?>">
                <p class="help-block">目前可用的机率值:<?=$left_v ?></p>
                <p class="help-block">[100%=100000] [10%=10000] [1%=1000] [0.1%=100] [0.001%=10] [0.0001%=1]</p>
            </div>
            <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
<!-- <div style=" text-align: center; ">
       <img id="yuanpan" src="images/zhuanpan/1/yuanpan_.png" style="width: 200px;height: 200px " />
</div> -->




