<?php
use \app\modules\AppBase\base\HintConst;
use \janisto\timepicker\TimePicker;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '奖品管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-goods/index'])];
$this->params['breadcrumbs'][] = "编辑奖品";
?>
<div class="container" style="padding-right:3em;">
     <div style="padding-right:0.7em;">

        <table class="table table-striped table-hover table-bordered">
            <tr style="background:#5bc0de;color:#fff;">
                <th class="text-center">商品名称</th>
                <th class="text-center">值</th>
                <th class="text-center">状态</th>
                <th class="text-center">类型</th>
                <th class="text-center">品牌</th>
                <th class="text-center">数量</th>
                <th class="text-center">用途</th>
                <th class="text-center">选择图片</th>
                <th class="text-center">操作</th>
            </tr>
        <form method="post" action="index.php?r=Stats/zhuanpan-goods/edit" >
            <input type="hidden" name="id" value="<?= $good['id']?>">
            <tr class="text-center">
                <td><input type="text" name="goods_name" value="<?= $good['goods_name'] ?>" style=" width: 120px"></input></td>
                <td><input type="text" name="value" value="<?= $good['value']?>" style=" width: 30px"></input></td>

                <td>
                    <select name='used' >
                        <option value="0" <?= $good['used'] == 0 ? "selected" : "" ?> >启用</option>
                        <option value="1" <?= $good['used'] == 1 ? "selected" : "" ?> >禁用</option>
                    </select>
                </td>

               <td>
                    <select name='type'>
                        <option value= 0 <?= $good['type'] == 0 ? "selected" : "" ?> >商品</option>
                        <option value= 3 <?= $good['type'] == 3 ? "selected" : "" ?> >邮费</option>
                        <option value= 1 <?= $good['type'] == 1 ? "selected" : "" ?> >积分</option>
                        <option value= 2 <?= $good['type'] == 2 ? "selected" : "" ?> >空奖</option>
                    </select>
                </td>
                <td><input type="text" name="brand" value="<?= $good['brand']?>" style=" width: 50px"></input></td>
                <td><input type="text" name="count" value="<?= $good['count']?>" style=" width: 50px"></input></td>
                <td><input type="text" name="purpose" value="<?= $good['purpose']?>" style=" width: 150px"></input></td>

                <td>
                    <input id="image" type="file" class="file" name="image" accept="image/*" value="" style=" width: 150px">
                    </input>
                </td>
                
                <td>

                    <input class="btn btn-xs btn-success" id='save' type="button" name="save" style="width: 50px" value="保存"></input>
                    <input class="btn btn-xs btn-warning" id='clear' type="button" name="clear" style=" width: 50px" value="清空"></input>
                </td>

            </tr>
        </form>
    </table>
    </div>
</div>

<script type="text/javascript">

    $(function(){
        $(".btn-success").click(function(){
            $("form").submit();
            return;
        });

        $(".btn-warning").click(function(){

            $(':input').not(':button,:reset,:submit').val('');
            return;
        });
    });
</script>


