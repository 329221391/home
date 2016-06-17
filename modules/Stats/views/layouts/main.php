<!DOCTYPE html>
<?php
use app\assets\AppAsset;
use app\modules\AppBase\base\CommonFun;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php $this->head() ?>
    <?= Html::cssFile('@web/css/main.css') ?>
    <?= Html::jsFile('@web/js/jquery.js') ?>
    <?= Html::jsFile('@web/js/bootstrap.min.js') ?>

</head>
<body class="horizontal-menu">
<?php

$this->beginBody()
?>

<div class="container">
    <div class="">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <a href="#" class="navbar-header">
                        <img src="images/logo.png">
                    </a>
                </button>
            </div><!-- navbar-header结束 -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown" style="border: 1px soild red;">
                        <a href="#stats" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-flag"></span>统计
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?r=Stats/school/index"><span class="glyphicon glyphicon-link"></span>注册学校</a></li>
                            <li><a href="index.php?r=Stats/province/index"><span class="glyphicon glyphicon-link"></span>注册省市</a></li>
                            <li><a href="index.php?r=Stats/info/index&school_id=0"><span class="glyphicon glyphicon-link"></span>使用情况</a></li>
                        </ul>
                    </li>
                    <li  id="goschool" <?php if ($this->context->id == 'goschool') echo 'class="active"'; ?> >
                        <a href="#goschool">
                        <span class="glyphicon glyphicon-book"></span>学校
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#club" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-list-alt"></span>俱乐部审核
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?r=Stats/club/index&pri_type_id=101"><span class="glyphicon glyphicon-link"></span>话题</a></li>
                            <li><a href="index.php?r=Stats/club/index&pri_type_id=102"><span class="glyphicon glyphicon-link"></span>求助</a></li>
                            <li><a href="index.php?r=Stats/club/index&pri_type_id=103"><span class="glyphicon glyphicon-link"></span>教师学习</a></li>
                            <li><a href="index.php?r=Stats/club/index&pri_type_id=104"><span class="glyphicon glyphicon-link"></span>家长学习</a></li>
                            <li><a href="index.php?r=Stats/club/index&pri_type_id=105"><span class="glyphicon glyphicon-link"></span>招生安全</a></li>
                            <li><a href="index.php?r=Stats/club/index&pri_type_id=106"><span class="glyphicon glyphicon-link"></span>政策趋势</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#club" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-list-alt"></span>大转盘
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?r=Stats/prize-goods/index"><span class="glyphicon glyphicon-link"></span>中奖信息查询</a></li>
                            <li><a href="index.php?r=Stats/shipping/index"><span class="glyphicon glyphicon-link"></span>奖品发货管理</a></li>
                            <li><a href="index.php?r=Stats/zhuanpan-active/index"><span class="glyphicon glyphicon-link"></span>活动管理</a></li>
                            <li><a href="index.php?r=Stats/zhuanpan-goods/index"><span class="glyphicon glyphicon-link"></span>奖品管理</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span><?= Yii::$app->session['admin_user']['nickname'] ?>管理员
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><span class="glyphicon glyphicon-home"></span>查看网站</a></li>
                            <li><a href="index.php?r=Stats/default/login-out"><span class="glyphicon glyphicon-log-out"></span>安全退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- collapse结束 -->
        </nav>

        <div>
            <input id="ontype" value="0" hidden>
            <input id="ss" value="<?= CommonFun::getCurrentDateTime() ?>" hidden>
            <input id="ee" value="0" hidden>
            <input id="ty" value="0" hidden>
        </div>
        <div class="alert alert-warning alert-dismissible" role="alert" hidden>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Warning!</strong> Better check yourself, you're not looking too good.
        </div>
        <div>
            <?= Breadcrumbs::widget(['itemTemplate' => "<li class='bread_li'>{link}</li>\n", 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
        </div>
        <div style="border-style:outset;">
            <?= $content ?>
        </div>
    </div>
</div><!-- container结束 -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<script language="javascript">
    var s = $("#ss").val();
    var e = $("#ee").val();
    $("#stats").click(function () {
        window.location.href = 'index.php?r=Stats/school/index';
    });
    $("#goschool").click(function () {
        window.location.href = 'index.php?r=Schools/schools';
    });
    $("#club").click(function () {
        window.location.href = 'index.php?r=Stats/club/index&pri_type_id=101';
    });
</script>
