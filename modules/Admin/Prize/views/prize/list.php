<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/css/bootstrap.min.css') ?>
<?= Html::cssFile('@web/css/mobile/base.css') ?>
<?= Html::cssFile('@web/css/mobile/prize.css') ?>
<script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

<div style="width:100%;height:40%; position: absolute; border: 3px solid gray; margin-top: 198px " ></div>

<div class="header-list" style="z-index: 9999">
    <span class="ready-shipping">待发货</span>

    <span class="title">中奖列表</span>

    <span class="delivered">已发货</span>
</div>    

<div class="container padding shipping" style=" display: block; ">
    <div style="height:80px;"></div>
    <?php foreach($ready_shipping as $order){ ?>
    <div class="prize_item">
        <div class="prize_panel">
            <div id='image_div' style=" width: 100px;height: 75px; background: red " >
                <img id="img" src="<?=$order['image'] ?>" style="height:auto; width:auto;max-width:100%;max-height:100%" ></img>
                    <span style="font-size:15px; color:green" >点击看大图</span>
            </div>
            

            <div class="info" style="margin-left:25px" >
                <div><b style="font-size:16px;">奖品名称：<?=$order['goods_name'] ?></b></div>
                <div><b style="font-size:13px;">品牌：<?=$order['brand'] ?></b></div>
                <div><b style="font-size:13px;">数量：<?=$order['count'] ?></b></div>
                <div><b style="font-size:13px;">描述：<?=$order['purpose'] ?></b></div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>



<div class="container padding deliver" style=" display: none; ">
    <div style="height:80px;"></div>
    <?php foreach($delivered_list as $order){ ?>
    <div class="prize_item">
        <div class="prize_panel">
            <div id='image_div' style=" width: 80px;height: 75px;" >
                <img id="img" src="<?=$order['image'] ?>" style="height:auto; width:auto;max-width:100%;max-height:100%" ></img>
                    <span style="font-size:15px; color:green" >点击看大图</span>
            </div>
            <div class="info">
                <div><b style="font-size:16px;">奖品名称：<?=$order['goods_name'] ?></b></div>
                <div><b style="font-size:13px;">品牌：<?=$order['brand'] ?></b></div>
                <div><b style="font-size:13px;">数量：<?=$order['count'] ?></b></div>
                <div><b style="font-size:13px;">描述：<?=$order['purpose'] ?></b></div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>


<div class="footer" style="z-index: 9999">
    <div id="post" >
        <p class="postage">
            邮费:<label class="postLabel"><?= $sumPostage?></label>
            <div id="owePostage">
                还需:<label class="postLabel"><?= $owePostage?></label>
                <a id="ExPostage" href="index.php?r=Prize/prize/exchange-postage" >换邮费</a>
            </div>
            <div class="daofu">
                <input type="checkbox"  id="checkbox" value="1" <?php echo $owePostage > 0 ? 'checked' : '' ?> name="post_type"></input><span style="width:70px" class="daofu"> 货到付款</span>
            </div>
            <input type="button" id="postOrder" value="通知发货"></input>
        </p>
    </div>
</div>

<script type="text/javascript">
    //待发货列表和发货列表
    $(function(){

        var window_height = $(window).height();
        var img_height = $("#img").height();
        alert(img_height);


        <?php if (empty($ready_shipping)) { ?>
            $(".title").html('待发货奖品为空');
            $(".footer").css('display','none');
        <?php } ?>
        //初始化header标签样式
        $(".ready-shipping").css('background','#337acf');
        $(".ready-shipping").css('box-shadow','3px 3px 5px #fff');
        $(".delivered").css('background','#337ab7');
        $(".delivered").css('box-shadow','0px 0px 0px 0');
        //$(".shipping").fadeIn(1000);
        //待发货分屏点击事件
        $(".ready-shipping").click(function(){
            $(".shipping").css('display','block');
            $(".deliver").css('display','none');
            $(".ready-shipping").css('background','#337adf');
            $(".ready-shipping").css('box-shadow','3px 3px 5px #fff');
            $(".delivered").css('background','#337ab7');
            $(".delivered").css('box-shadow','0px 0px 0px 0');
            $(".footer").css('display','block');
            <?php if (empty($ready_shipping)) { ?>
            $(".title").html('待发货奖品为空');
            $(".footer").css('display','none');
            <?php } else { ?> 
                $(".title").html('中奖列表');
                <?php } ?>
       });
       //已发货分屏点击事件
       $(".delivered").click(function(){
            $(".shipping").css('display','none');
            $(".deliver").css('display','block');
            $(".ready-shipping").css('background','#337ab7');
            $(".ready-shipping").css('box-shadow','0px 0px 0px 0');
            $(".delivered").css('background','#337adf');
            $(".delivered").css('box-shadow','3px 3px 5px #fff');
            $(".footer").css('display','none');
            <?php if (empty($delivered_list)) { ?>
            $(".title").html('已发货奖品为空');
            <?php } else { ?> 
                $(".title").html('中奖列表');

                <?php } ?>
       });
    });

    //设置邮费和是否货到付款方式代码块
    $(function(){
        //设置是否显示换邮费标签
       var showDiv = $("#owePostage");
       if ("<?= $owePostage?>" <= 0) {
            showDiv.css('display','none');
            //是否选择到付
            $("#postOrder").click(function(){
                if ($("#checkbox").prop("checked")) {
                    window.location.href='index.php?r=Prize/prize/deliver&post_type=1';
                } else {
                    window.location.href='index.php?r=Prize/prize/deliver&post_type=0';
                    }
            });
       } else if("<?= $owePostage?>" >= 0){
            $("#postOrder").click(function(){
                window.location.href='index.php?r=Prize/prize/deliver&post_type=1';
            });
            $("#checkbox").click(function(){
                if ($("#checkbox").prop("checked")) {
                    $("#postOrder").css('background','#eeeeee');
                    $("#postOrder").css('color','#337ab7');
                    $("#postOrder").click(function(){
                        window.location.href='index.php?r=Prize/prize/deliver&post_type=1';
                    }); 
                } else {
                    $("#postOrder").css('background','gray');
                    $("#postOrder").css('color','black');
                    $("#postOrder").unbind('click');
                    }
            });
        }
    });
</script>