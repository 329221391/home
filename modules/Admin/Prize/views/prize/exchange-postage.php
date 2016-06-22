<?php
use yii\helpers\Html;
use app\modules\AppBase\base\HintConst;
?>
<?= Html::cssFile('@web/css/bootstrap.min.css') ?>
<?= Html::cssFile('@web/css/mobile/base.css') ?>
<?= Html::cssFile('@web/css/mobile/prize.css') ?>
<script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

<div class="header" style="z-index: 9999">
    <div class="title">兑换邮费</div>
</div>

<div class="container">
<div style="height: 100px;" ></div>
    <label style="margin-top: 5px; width: 100%; text-align: center;">兑换规则：10积分兑换1元邮费</label>
    <hr>
    <div id="sum" style="margin-top: 5px; width: 100%; text-align: center; color:#000; ">
        <?php  echo "$custom_name"; if ($cat_default_id == HintConst::$ROLE_HEADMASTER) {
            echo "园长";
        } elseif ($cat_default_id == HintConst::$ROLE_TEACHER) {
            echo "老师";
        } elseif ($cat_default_id == HintConst::$ROLE_PARENT) {
            echo "家长";
        } ?>: 您的积分总数为：<label id="score"><?= $score ?></label>
    </div>
    <div id="exchange" style="margin-top: 50px; width: 100%; text-align: center;">
        <form id="ExchangePostage" method="post" action="index.php?r=Prize/prize/exchange-postage" >
            请输入邮费：<input id="exPostage" name='exPostage' type="text" ></input>
            <input type="button" id='submit1' value="确认兑换"></input>
        </form>
    </div>
<script type="text/javascript">

       $(function(){
       var showDiv = $("#owePostage");
       if ("<?= $owePostage?>" <= 0) {
            showDiv.css('display','none');
       }

       $("#submit1").click(function(){
            var left = $("#exPostage").val();
            if(left > 0) {
                var str = "您输入的邮费为"+$("#exPostage").val()+"元，需扣"+$("#exPostage").val()*10+'积分。';
                /*$.ajax({
                    type: "post",
                    url: "http://homebridge/index.php?r=Prize/prize/exchange-postage",
                    cache: "false",
                    async: "false",
                    dataType: "json",
                    data: {"exPostage": $("#exPostage").val()},
                    success: function(data) {
                        console.log(data['ErrCode']);
                        alert(data.ErrCode);
                        $("#score").html(data.score); 
                        if(data['ErrCode'] == 0){
                            var score = parseInt($("#score").html());
                            score = score - left;
                            $("#score").html(score+'');
                            window.location.reload();
                            return;
                        } else if (data['ErrCode'] == 1) {
                            alert(data['Message']);
                            return;
                        }
                    }
                });*/
                if(confirm(str)){
                     $("#ExchangePostage").submit();
                } else {
                    return;
                };
            } else { alert('您输入的邮费不应为空！'); }
       });
    });
</script>

<div class="footer" style="z-index: 9999">
    <div id="post" >
        <p class="postage">
            邮费:<label class="postLabel"><?= $sumPostage?></label>
            <div id="owePostage">
                还需:<label class="postLabel"><?= $owePostage?></label>
                
            </div>
            
        </p>
    </div>
</div>