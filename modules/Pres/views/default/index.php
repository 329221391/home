<?php
use yii\helpers\Html;

?>
<head>
    <?= Html::cssFile('@web/css/res.css') ?>
    <?= Html::cssFile('@web/css/flexslider.css') ?>
    <title>资源库</title>
</head>

<body>
<!--banner start here-->
    <div class="banner">
        <div class="container">
            <div class="banner-bottom">
                <section>
                    <div class="flexslider">
                        <ul class="slides">
                            <li>
                                <div class="col-md-4 banner-left">
                                    <h3>麦兜<span class="bann-sli-text">&nbsp;我和妈妈</span></h3>
                                </div>
                                <div class="col-md-8 banner-right">
                                    <a href="http://v.youku.com/v_show/id_XODE1NDk3MzIw.html?from=y1.3-comic-gridtest-135-10061.100888.3-1">
                                        <img src="images/res-img/md.png" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="clearfix"> </div>
                            </li>
                            <li>
                                <div class="col-md-4 banner-left">
                                    <h3>哆啦A梦<span class="bann-sli-text">&nbsp;三态丸</span></h3>
                                </div>
                                <div class="col-md-8 banner-right">
                                    <a href="http://v.youku.com/v_show/id_XOTE1MjQ5MjA0.html?from=y1.3-child-index-10814-21764.212914-212912.4-1">
                                        <img src="images/res-img/big-a.png" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="clearfix"> </div>
                            </li>
                            <li>
                                <div class="col-md-4 banner-left">
                                    <h3>樱桃<span class="bann-sli-text">&nbsp;小丸子</span></h3>
                                </div>
                                <div class="col-md-8 banner-right">
                                    <a href="http://v.youku.com/v_show/id_XNTU3NTUzODQw.html">
                                        <img src="images/res-img/big-xwz.png" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="clearfix"> </div>
                            </li>
                        </ul>
                    </div><!-- flexslider end -->
                </section>
                <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script>

                <!-- FlexSlider -->
                <script defer src="js/jquery.flexslider.js"></script>
                <script type="text/javascript">
                    $(function(){

                    });
                    $(window).load(function(){
                        $('.flexslider').flexslider({
                            animation: "slide",
                            start: function(slider){
                                $('body').removeClass('loading');
                            }
                        });
                    });
                </script>
            </div><!-- banner-bottom end -->
        </div><!-- container end -->
    </div><!-- banner end -->
<!-- banner end here -->

<!-- banner-strip start here -->
<div class="bann-strip">
    <div class="container">
        <div class="bann-strip-main">
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XMTM4OTUyMDM4NA==.html?from=y1.3-child-index-10814-21764.212905-212900.4-1">
                    <img src="images/res-img/7zai.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XMTM4OTUyMDM4NA==.html?from=y1.3-child-index-10814-21764.212905-212900.4-1">长江7号之七仔爱地球</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XMjgzMDI3NjIw.html?from=y1.2-2-100.3.14-1.1-3-1-13-0">
                    <img src="images/res-img/big-head.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XMjgzMDI3NjIw.html?from=y1.2-2-100.3.14-1.1-3-1-13-0">大头儿子小头爸爸2</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.qq.com/cover/w/wbrvedar7aclm89.html?ptag=2345.movie">
                    <img src="images/res-img/pig-2.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.qq.com/cover/w/wbrvedar7aclm89.html?ptag=2345.movie">猪猪侠之囧囧危机</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XMjg3MTM4OTA4.html?from=y1.2-2-100.3.3-1.1-3-1-2-0">
                    <img src="images/res-img/dtutu.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XMjg3MTM4OTA4.html?from=y1.2-2-100.3.3-1.1-3-1-2-0">大耳朵图图</a></h4>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div><!-- bann-strip-main end -->

        <div class="bann-strip-main">
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XODI5NTQ5NTAw.html?from=y1.6-100.1.1.fb675d9461ad11e0bea1">
                    <img src="images/res-img/amduola.jpg" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XODI5NTQ5NTAw.html?from=y1.6-100.1.1.fb675d9461ad11e0bea1">爱冒险的朵拉</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XMjkwNTg0ODIw.html?from=y1.6-100.1.1.7cff704ebca811e0a046http://v.youku.com/v_show/id_XNTcwMTk4NDQ4.html?from=y1.6-100.1.1.a74cbf5a4f9811e0a046http://v.youku.com/v_show/id_XNzkxOTM1MDI0.html?from=y1.6-100.1.1.a1b4108813c711e4b8b7">
                    <img src="images/res-img/pingu.jpg" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XMjkwNTg0ODIw.html?from=y1.6-100.1.1.7cff704ebca811e0a046http://v.youku.com/v_show/id_XNTcwMTk4NDQ4.html?from=y1.6-100.1.1.a74cbf5a4f9811e0a046http://v.youku.com/v_show/id_XNzkxOTM1MDI0.html?from=y1.6-100.1.1.a1b4108813c711e4b8b7">淘气的PINGU</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XOTE1MjQ5MjA0.html?from=y1.3-child-index-10814-21764.212914-212912.4-1">
                    <img src="images/res-img/adl.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XOTE1MjQ5MjA0.html?from=y1.3-child-index-10814-21764.212914-212912.4-1">多啦A梦</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XOTQ0Mjg4NjE2.html?from=y1.3-child-index-10814-21764.213268.4-1">
                    <img src="images/res-img/elephant.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XOTQ0Mjg4NjE2.html?from=y1.3-child-index-10814-21764.213268.4-10">大象国王巴巴</a></h4>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div><!-- bann-strip-main end -->

        <div class="bann-strip-main">
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XMTM2NDM5MTA2OA==.html">
                    <img src="images/res-img/blackcat.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XMTM2NDM5MTA2OA==.html">黑猫警长之翡翠之星</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XMjQwOTM4NDQ4.html?from=s1.8-3-1.1">
                    <img src="images/res-img/atm.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XMjQwOTM4NDQ4.html?from=s1.8-3-1.1">迪迦奥特曼</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XODE1NDk3MzIw.html?from=y1.3-comic-gridtest-135-10061.100888.3-1">
                    <img src="images/res-img/smd.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XODE1NDk3MzIw.html?from=y1.3-comic-gridtest-135-10061.100888.3-1">麦兜 我和我妈妈</a></h4>
                </div>
            </div>
            <div class="col-md-3 bann-grid">
                <a href="http://v.youku.com/v_show/id_XNTU3NTUzODQw.html">
                    <img src="images/res-img/sxwz.png" alt="" class="img-responsive">
                </a>
                <div class="details">
                    <h4><a href="http://v.youku.com/v_show/id_XNTU3NTUzODQw.html">樱桃小丸子</a></h4>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div><!-- bann-strip-main end -->
    </div><!-- container end -->
</div><!-- bann-strip end -->
</body>
