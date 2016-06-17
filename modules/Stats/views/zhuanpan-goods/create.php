<?php
use \app\modules\AppBase\base\HintConst;
use \janisto\timepicker\TimePicker;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '奖品管理'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/zhuanpan-goods/index'])];
$this->params['breadcrumbs'][] = "添加奖品";
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
        <form method="post" action="index.php?r=Stats/zhuanpan-goods/create" enctype="multipart/form-data>
            <tr class="text-center">
                <td><input type="text" name="goods_name" style=" width: 120px"></input></td>
                <td><input type="text" name="value" style=" width: 30px"></input></td>

                

                <td>
                    <select name='used' >
                        <option value="0">启用</option>
                        <option value="1">禁用</option>
                    </select>
                </td>

               <td>
                    <select name='type'>
                        <option value= 0 >商品</option>
                        <option value= 3 >邮费</option>
                        <option value= 1 >积分</option>
                        <option value= 2 >空奖</option>
                    </select>
                </td>
                <td><input type="text" name="brand" style=" width: 50px"></input></td>
                <td><input type="text" name="count" style=" width: 50px"></input></td>
                <td><input type="text" name="purpose" style=" width: 150px"></input></td>
                <td>
                    <input id="image" type="file" class="file" name="file" accept="image/*" style=" width: 150px">
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

        /*var path = $("#image").value;
        
        $("#image1").click(function(){
            alert(path); return;

        });*/
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


