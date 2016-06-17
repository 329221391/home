<!DOCTYPE html>
<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>
<?php $this->beginPage() ?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->head(); ?>
    <title><?= $this->title; ?></title>
    <?= Html::cssFile('@web/css/bootstrap.css') ?>
    <?= Html::cssFile('@web/css/main.css') ?>
    <?= Html::cssFile('@web/css/manage_style.css') ?>
    <?= Html::jsFile('@web/js/utils.js') ?>
</head>
<body class="horizontal-menu-page">

<?php if (isset(Yii::$app->session['admin_user'])) { ?>
    <div><a href="index.php?r=Stats/info/index">管理员</a></div>
<?php } ?>
<div class="container" style="padding-top:1em;padding-bottom:1em;">
    <div class="row">
        <div class="col-md-4"><a href="index.php?r=manage"><img src=""/></a></div>
        <div class="col-md-8"></div>
    </div>
</div>

<!-- visible-xs hidden-sm hidden-md hidden-lg -->
<div class="container">
    <div class="content-border">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-header">
                    <img src="images/logo.png">
                </a>
            </div><!-- navbar-header结束 -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown active1">
                        <a href="#school" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>院所管理
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?r=manage/school"><span class="glyphicon glyphicon-map-marker"></span>院所信息</a></li>
                            <li><a href="index.php?r=manage/class"><span class="glyphicon glyphicon-map-marker"></span>班级管理</a></li>
                            <li><a href="index.php?r=manage/customs&type=1"><span class="glyphicon glyphicon-map-marker"></span>教师管理</a></li>
                            <li><a href="index.php?r=manage/customs&type=2"><span class="glyphicon glyphicon-map-marker"></span>学生管理</a></li>
                            <li><a href="index.php?r=manage/cook-book"><span class="glyphicon glyphicon-map-marker"></span>食谱管理</a></li>
                            <li><a href="index.php?r=manage/tag"><span class="glyphicon glyphicon-map-marker"></span>标签管理</a></li>
                            <li><a href="index.php?r=manage/zhaopin"><span class="glyphicon glyphicon-map-marker"></span>招聘管理</a></li>
                            <li><a href="index.php?r=manage/zhaosheng"><span class="glyphicon glyphicon-map-marker"></span>招生管理</a></li>
                        </ul>
                    </li>
                    <li class="dropdown active2">
                        <a href="#article" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-list"></span>内容审核
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?r=manage/article/index"><span class="glyphicon glyphicon-map-marker"></span>文章列表</a></li>
                            <li><a href="index.php?r=manage/pic/index"><span class="glyphicon glyphicon-map-marker"></span>照片列表</a></li>
                            <li><a href="index.php?r=manage/pingjia/index"><span class="glyphicon glyphicon-map-marker"></span>评价列表</a></li>
                            <li><a href="index.php?r=manage/note/index"><span class="glyphicon glyphicon-map-marker"></span>通知列表</a></li>
                            <li><a href="index.php?r=manage/vote/index"><span class="glyphicon glyphicon-map-marker"></span>调查列表</a></li>
                            <li><a href="index.php?r=manage/praise/index"><span class="glyphicon glyphicon-map-marker"></span>鼓励列表</a></li>
                            <li><a href="index.php?r=manage/letter/index"><span class="glyphicon glyphicon-map-marker"></span>感谢信列表</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="index.php?r=manage/red-flower/index">
                            宝贝红花
                        </a>
                    </li>
                                        <li>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span><?= Yii::$app->session['manage_user']['name_zh'] ?>园长
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><span class="glyphicon glyphicon-home"></span>查看网站</a></li>
                            <li><a href="index.php?r=manage/default/login-out"><span class="glyphicon glyphicon-log-out"></span>安全退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- navbar-collapse结束 -->
        </nav>

        <?= Breadcrumbs::widget(['itemTemplate' => "<li class='bread_li'>{link}</li>\n", 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
        <?php echo $content ?>
        <div class="footer">
            <div class="" style="float:right;letter-spacing:1px;font-family:'微软雅黑';">发现教育科学研究所</div>
        </div>
    </div>
</div><!-- container结束 -->
</body>
</html>
<?php $this->endPage() ?>
<script language="javascript">
    $("#default").click(function () {
        window.location.href = 'index.php?r=manage';
    });
    $("#school").click(function () {
        window.location.href = 'index.php?r=manage/school';
    });
    $("#article").click(function () {
        window.location.href = 'index.php?r=manage/article/index';
    });
    $("#web").click(function () {
        window.location.href = 'index.php?r=manage';
    });
</script>