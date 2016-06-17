<?php
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\SiteCom;

$eat = $today[0]->eat;
$sleep = $today[0]->sleep;
$course = $today[0]->course;
$outdoor = $today[0]->outdoor;
$lessons = $today[0]->lessons;
$homework = $today[0]->homework;
$cook_book = $today[0]->cook_book;
$att_list = $today[0]->att_list;
?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content=" initial-scale=1.0,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<link href="css/common.css" rel="stylesheet" type="text/css"/>
<link href="css/css_white.css" rel="stylesheet" type="text/css"/>
<title>家园桥家长端首页</title>
<script type="text/javascript" src="js/date.js"></script>
<script type="text/javascript" src="js/iscroll.js"></script>
<script type="text/javascript" src="js/bottomgb.js"></script>
<script type="text/javascript">
    $(function () {
        $('#beginTime').date();
        $('#endTime').date({theme: "datetime"});
    });
</script>
<script language="javascript"> function op(c_url) {
        window.open(c_url, "_self")
    }</script>
<head>
</head>
<body style="display:block;">
<form id="form1" name="form1" method="post" action="">
    <div class="z_title">今日总结</div>
    <div id="ms_top"><a href=<?php echo SiteCom::$phone_url . "exit" ?>>
            <img class="f_sy" src="images/info_0.png">
        </a>
    </div>
    <div class="jz_title" style=" padding-bottom:0;  ">
        <div class="shang_jg"><img class="img_jie" src="images/60/icons_zj.png"><span
                class="jz"><?= $parentInfo['ParentInfo']->name_zh ?></span>家长您好<br> 这是<span
                class="jz"><?= $parentInfo['ClassInfo'][0][HintConst::$Field_name] ?></span><!--<input name="control_date" type="text" id="control_date" size="10" maxlength="10" readonly="readonly"  />-->
            <input id="beginTime" name="control_date" class="kbtn" style="width:100px;"/>的在校情况
            <div id="datePlugin"></div>
        </div>
        <?php if (!empty($cook_book)) { ?>
            <div class="xs_bq" style="">
                <ul>
                    <li><span class="can kuan">早餐：</span><span class="sw"><?= $cook_book->breakfast ?></span></li>
                    <li><span class="can kuan">加点：</span><span class="sw"><?= $cook_book->addone ?></span></li>
                    <li><span class="can kuan">中餐：</span><span class="sw"><?= $cook_book->lunch ?></span></li>
                    <li><span class="can kuan">加点：</span><span class="sw"><?= $cook_book->addtwo ?></span></li>
                    <li><span class="can kuan">晚餐：</span><span class="sw"><?= $cook_book->dinner ?></span></li>
                </ul>
            </div>
        <?php
        }
        if (!empty($eat)) {
            ?>
            <div class="eat_th"><span class="can">吃饭情况：</span><span class="sw"><?= $eat ?></span></div>
        <?php
        }
        if (!empty($outdoor)) {
            ?>
            <div class="act_th"><span class="can">户外活动：</span><span class="sw"><?= $outdoor ?></span></div>
        <?php
        }
        if (!empty($sleep)) {
            ?>
            <div class="sleep_th"><span class="can">午睡情况：</span><span class="sw"><?= $sleep ?></span></div>
        <?php
        }
        if (!empty($lessons)) {
            ?>
            <div class="learn_th"><span class="can">课程内容：</span><span class="sw"><?= $lessons ?></span></div>
        <?php
        }
        if (!empty($homework)) {
            ?>
            <div class="sleep_th"><span class="can">家庭练习：</span><span class="sw"><?= $homework ?></span></div>
        <?php
        }
        if (!empty($att_list)) {
            ?>
            <div class="sleep_th border_no"><span class="can">精彩瞬间：</span></div>
            <?php foreach ($att_list as $k => $v) {
                $host = str_replace('http://', '', Yii::$app->request->getHostInfo());
                $url = str_replace($host, '', $v->url);
                ?>
                <div class="sj_img"><a href=<?php echo SiteCom::$phone_url . "index_img&img_url=" . $url ?>><img
                            src=<?= $url ?>
                            ></a></div>
                <div class="sleep_th border_no"><span class="can">图片描述：</span><span class="sw"><?= $v->img_des ?></span>
                </div>
                <div class="store_share"><!--<input type="button" class="share" value="分享">-->
                    <input id="add_favor"
                           name="<?= $v->article_id . ',' . $v->id ?>"
                           type="button"
                           class="store"
                           value="收藏"><br style="clear:both;"/></div>
            <?php
            }
        } ?>
    </div>
    <?php include("fourbottom.php") ?>
</form>
</body>
</html>
<script language="javascript">
    <!--//    Begin
    window.onload = function () {
        document.form1.control_date.value = '<?= $date?>';
    }
    function recall() {
        var selcetdate = $("#beginTime").val()
        window.location.href = 'index.php?r=phone/index_all&date=' + selcetdate;
    }
    $("[id=add_favor]").each(function () {
        $(this).click(function () {
            var a = $(this).attr('name').split(',');
            $.post('index.php?r=Articles/articles/add-fav', {
                article_id: a[0],
                article_att_id: a[1]
            }, function (result) {
                if (result['ErrCode'] == "0") {
                    alert(result['Message']);
                } else {
                    alert(result['Message']);
                }
            }, "json");
        });
    });
    //  End -->
</script>