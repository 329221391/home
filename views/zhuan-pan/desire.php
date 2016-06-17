<?php
    use app\modules\AppBase\base\HintConst;
    $this->context->layout='empty';
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="viewport" content="initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>幸运大转盘</title>
    <link href="/css/mobile/zhuanpan.css" rel="stylesheet">
</head>
<body style="margin:0;padding:0;">

<div class="zp" id="expect" style="position: absolute; width: 100%;height: 100%; z-index: 1; display :none; ">
    <img id="expect1" src="images/zhuanpan/1/desire.jpg" style="width:100%; display:block"/>
    </div>
    <span id="expect_time" style=" position: absolute; width: 100%; z-index: 1;font-size: 30px; font-family: '黑体'; font-weight:bold;text-align: center; color: #fff; margin-top: 20px;display: none; ">
        本期开奖时间<br>
        <span style="font-size: 20px">
            <?= $date_parse['year']?>年<?= $date_parse['month']?>月<?= $date_parse['day']?>号
            <?= $date_parse['hour']?>点<?= $date_parse['minute']?>分
            
        </span>
     </span>


<div class="userinfo">
    <div class="left">
        <div>
            <img class="avatar" src="http://user.jyq365.com/headpic/h<?=$custom_id ?>.png" onerror="javascript:this.src='/images/jztx48.png'" />
            <div class="name">
                <span style="color:#45c111;"><?=$custom_name ?></span>
                <?php
                if($cat_default_id == HintConst::$ROLE_HEADMASTER){
                    echo '园长';
                }elseif($cat_default_id == HintConst::$ROLE_TEACHER){
                    echo '老师';
                }elseif($cat_default_id == HintConst::$ROLE_PARENT){
                    echo '家长';
                }
                ?>
            </div>
            <div class="score">
                我的积分
                <span style="color:#45c111;" id="score"><?=$score ?></span>
            </div>
        </div>
    </div>
    <div class="right">
        <a href="index.php?r=zhuan-pan/details" style="color:#535353">奖品详细>></a>
    </div>
</div>
<div class="bg">
    <div id="zp" class="zp">
        <img id="yuanpan_cat_default_id" src="images/zhuanpan/1/yuanpan_<?= $cat_default_id?>.png" style="width:100%; display:none"/>
        <div id="pointer" style="position:absolute;">
            <img id="startBtn" src="images/zhuanpan/1/pointer.png" style="width:60px;display:none"/>
        </div>
    </div>
    <div id="prompt" style="background:blue;position: absolute" >
    </div>
</div>
<div class="footer">
    <marquee behavior="scroll" direction="left" ><?= $scroll_info['scroll_info'] ?></marquee>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/awardRotate.js"></script>
<script src="/js/jquery.easing.1.3.js"></script>
<script>

$(function(){
        if (<?= $active?> == 0) {
            $("#startBtn ,#prizeDetail").click(function(){
                $("#expect").fadeIn(1000);
                $("#expect_time").slideDown(2000);
            });
        }
    });



    $(function(){
        $(".bg").height($(window).height()-100);
        setTimeout(function(){
            //圆盘居中
            $('#yuanpan_cat_default_id').css('display','block');
            $('#startBtn').css('display','block');
            var zp = $('#zp');
            var left = ($(window).width() - zp.width()) / 2;
            var top = ($(window).height() - zp.height()) / 2 + 50;
            zp.css('left',left);
            zp.css('top',top);

            //指针居中
            var pointer = $('#pointer');
            var p_left = (zp.width() - pointer.width()) / 2;
            var p_height = (zp.height() - pointer.height()) / 2;
            pointer.css('left',p_left);
            pointer.css('top',p_height);
        },200);
    });
</script>
</body>
</html>