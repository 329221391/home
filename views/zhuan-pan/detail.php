<?php
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
    <title>奖品详情</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/mobile/base.css" rel="stylesheet">
    <link href="/css/mobile/zhaosheng.css" rel="stylesheet">
    <link href="/css/mobile/prize.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<div class="header" style="z-index: 9999">
    <div class="title">奖品详情</div>
</div>

<div class="padding">
    <div style="height:50px;"></div>

    <image id="origin_image" style="position: absolute; z-index: 1;display: none " >
    </image>

    <div style="padding:10px; ">
        <?php foreach($goods_list as $item){?>
            <div class="prize_item">
                <div class="prize_panel">
                    <div id='image_div' onclick=display_image('<?= $item['image']?>') style=" width: 100px;height: 75px" >
                        <!--显示缩略图-->
                        <img id="image" style="display:<?php $fileName = $item['image']; echo strlen($fileName) < 25 ? 'none' : 'block' ?>" src=
                            <?php 
                                $fileName = $item['image'];
                                if(strlen($fileName) > 25){
                                    $str=explode('.', $fileName);
                                    echo $str[0]."_thumb.".$str[1];
                                } else echo 0;
                            ?>
                        </img>
                <span style="font-size:15px; color:green" >点击看大图</span>
            </div>
                    <div class="info" style="margin-left:25px" >
                        <div><b style="font-size:16px;">奖品名称：<?=$item['goods_name'] ?></b></div>
                        <div><b style="font-size:13px;">品牌：<?=$item['brand'] ?></b></div>
                        <div><b style="font-size:13px;">数量：<?=$item['count'] ?></b></div>
                        <div><b style="font-size:13px;">描述：<?=$item['purpose'] ?></b></div>
                    </div>
                </div>
            </div>
    <?php } ?>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    //点击列表小图可以在屏幕中间显示大图
    //获得浏览器宽度和高度
    function display_image(addr){
        var $window_height = $(window).height();
        var $window_width = $(window).width();
        //定义大图的宽度和高度
        var $image_width;
        var $image_height;
        $("#origin_image").unbind();
        $("#origin_image").prop("src", addr).load(function(){
        $image_width = this.width;
        $image_height = this.height;
       if($image_width >= $window_width) {
            var $scale = $window_width/$image_width;
            $image_height = $image_height*$scale;
            $image_width = $image_width*$scale;
            var $top = ($window_height-$image_height)/2;
            $(this).css('top',$top).css('width',$image_width).css('height',$image_height);
            $(this).fadeIn(500);
            $(this).bind('click',function(){
                $(this).fadeOut(300);
            });

        } else if($image_width <= $window_width) {
            var $top = ($window_height-$image_height)/2;
            var $left = ($window_width-$image_width)/2;
            $(this).css('top',$top).css('left',$left).css('width',$image_width).css('height',$image_height);
            $(this).fadeIn(500);
            $(this).bind('click',function(){
                $(this).fadeOut(300);
            });
        }
        }); 
    }
</script>