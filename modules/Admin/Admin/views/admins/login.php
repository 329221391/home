<?php

use app\modules\AppBase\base\HintConst;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Admin\models\AdminsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin';

?>
<?= Html::cssFile('@web/css/bootstrap.css') ?>
<?= Html::cssFile('@web/css/main.css') ?>
<body class="admin-body">
    <div class="container">
        <?php if (isset($message)) { ?>
            <div class="alert alert-warning"><?= $message ?></div>
        <?php } else { ?>

        <?php } ?>
        <form class="form-signin" action="index.php?r=Admin/admins/login" method="post">
            <div class="form-signin-heading text-center">

                <h1 class="sign-title">管&nbsp;理&nbsp;员&nbsp;登&nbsp;录</h1>
                <h3 style="color:#6bc5a4;"><span class="glyphicon glyphicon-user" style="color:#888;"></span>&nbsp;&nbsp;<?= $this->title ?>&nbsp;<span style="color:#15afce;">Login</span></h3>
            </div>
            <div class="login-wrap">
                <input name="user_name" type="text" class="form-control" placeholder="请输入手机号" autofocus>
                <input name="password" type="password" class="form-control" placeholder="请输入密码">

                <input type="hidden" name="r" value="Articles/articles/daily"/>
                <button class="btn btn-lg btn-login2 btn-block" type="submit" style="margin-top:40px;">登&nbsp;录</button>
            </div>
        </form>
    </div>
</body>