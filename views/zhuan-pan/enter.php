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
    <script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <title>幸运大转盘</title>
    <link href="/css/mobile/zhuanpan.css" rel="stylesheet">

    <style type="text/css">
        
        .ns-effect-jelly {
            }
        #again{
            border:1px solid white;
            color: #00ff00;
            position: absolute;
            left: 30px;
            bottom: 30px;
        }
        #notTry{
             border:1px solid white;
            color: #ff9900;
            position: absolute;
            right: 30px;
            bottom: 30px;
            
        }

    </style>
</head>
<body style="margin:0;padding:0;">
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
                积分总数为
                <span style="color:#45c111;" id="game_points"><?=$game_points ?></span>

            </div>
        </div>
    </div>
    <div class="right">
        <a href="index.php?r=zhuan-pan/details" style="color:#535353">奖品详细>></a>
    </div>
</div>
<div class="bg">
    <input type="hidden" id="active_id" name="active_id" value="<?= $ret[0]['id'] ?>" />
    <div id="zp" class="zp">
        <img id="yuanpan_cat_default_id" src="images/zhuanpan/1/yuanpan_<?= $cat_default_id ?>.png" style="width:100%; display:none"/>
        <div id="pointer" style="position:absolute;">
            <img id="startBtn" src="images/zhuanpan/1/pointer.png" style="width:60px;display:none"/>
        </div>
    </div>

</div>
<div class="footer">
    <marquee behavior="scroll" direction="left" ><?= $scroll_info['scroll_info'] ?></marquee>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/awardRotate.js"></script>
<script src="/js/jquery.easing.1.3.js"></script>

<link rel="stylesheet" type="text/css" href="/css/ns-default.css" />
<link rel="stylesheet" type="text/css" href="/css/ns-style-growl.css" />
<script src="/js/classie.js"></script>
<script src="/js/modernizr.custom.js"></script>
<script src="/js/notificationFx.js"></script>
<script>

    $(function(){

    function tanKuangCenter(notification){
        var windowWidth = document.documentElement.clientWidth;   
        var windowHeight = document.documentElement.clientHeight;
        var width = windowWidth-100;
        var height = windowHeight/4;
        var top = windowHeight/3+55;
        var left = (windowWidth - width)/4;
        $('.ns-effect-jelly').css('position', 'absolute');
        $('.ns-effect-jelly').css('width', width);
        $('.ns-effect-jelly').css('height', height);
        $('.ns-effect-jelly').css('top',top);
        $('.ns-effect-jelly').css('left',left);
        $('.ns-effect-jelly').css('text-align','center');
        $('.ns-effect-jelly').css('vertical-align','center');

        notification.show();
    }
        //得到窗口的宽度和高度
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

        var startBtnClick = function(){
            $(this).unbind('click',startBtnClick);
            var self = $(this);
            var active_id = $('#active_id').val();
            $.ajax({
                url:'index.php?r=zhuan-pan/lottery&cache='+new Date(),
                dataType:'json',
                method:'POST',
                cache:false,
                data:{active_id:active_id},
                error:function(err){
                    alert('error');
                    console.log(err);
                },
                success:function(serverData){
                    //console.log(serverData);
                    //return;
                    console.log(serverData);
                    if(serverData.ErrCode == 7109){
                        alert('转一次需要<?=HintConst::$GAME_SUB_GAMEPOINTS ?>积分不足，无法继续');
                        return;
                    }
                    if(serverData.ErrCode != 0){
                        alert('Message is :'+serverData.Message);
                        return;
                    }
                    //角度
                    var angle = serverData.Content.angle;
                    //奖品名称
                    var prize = serverData.Content.prize;
                    //是否是虚拟商品
                    var type = serverData.Content.type;
                    //中奖记录的id
                    var prize_log_id = serverData.prize_log_id;
                    //最新的用户积分
                    var game_points = serverData.game_points;
                    $("#yuanpan_cat_default_id").rotate({
                        duration:5000, //转动时间
                        angle: 0,
                        animateTo:1800+angle,  //转动角度
                        callback:function(){
                            $('#game_points').text(game_points);
                            //$("#startBtn").click(startBtnClick);
                            if(type == 2){
                                var notification = new NotificationFx({
                                    message : "<h1>"+prize+"！</h1>"+'<h3><span id="again">再抽一次</span><span id="notTry">下次再抽</span></h3>',
                                    layout : 'growl',
                                    effect : 'jelly',
                                    type : 'notice', // notice, warning, error or success
                                    onClose : function() {
                                    }
                                });
                                tanKuangCenter(notification);   
                                
                                $("#notTry").click(function(){
                                    notification.dismiss();
                                });
                                $("#again").click(function(){
                                    notification.dismiss();
                                    self.trigger('click');
                                    
                                });
                                $("#startBtn").click(startBtnClick);
                                //alert('继续努力，下次一定能抽到哦');
                                return;
                            }else{
                                var msg = '<h2>恭喜您,抽中了<h3><h2>'+prize+'！ <h1></h1><h3><span id="again">再抽一次&nbsp&nbsp&nbsp</span><span id="notTry">  下次再抽</span></h3>';
                                var notification = new NotificationFx({
                                    message : msg,
                                    layout : 'growl',
                                    effect : 'jelly',
                                    type : 'notice', // notice, warning, error or success
                                    onClose : function() {
                                    }
                                });
                                tanKuangCenter(notification);
                                

                                $("#notTry").click(function(){
                                    notification.dismiss();
                                });
                                $("#again").click(function(){
                                    notification.dismiss();
                                    self.trigger('click');
                                });
                                $("#startBtn").click(startBtnClick);
                            }
                        }
                    });
                }
            });
        }
        $("#startBtn").click(startBtnClick);
    });
</script>
</body>
</html>