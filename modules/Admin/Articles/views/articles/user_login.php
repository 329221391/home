<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
use yii\helpers\Html;
?>
<?= Html::jsFile('@web/js/jquery.js') ?>
<title>登录</title>
</head>
<body>
<div class="container" style="margin-top:20em;">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">用户登录</h3>
        </div>
        <div class="panel-body">
          <form action="index.php?r=Articles/articles/daily" method="post">
            <div class="row">
              <div class="col-md-3" style="padding-top:0.2em;">
                <label for="user_name" class="control-label">用户名</label>
              </div>
              <div class="col-md-9" style="padding-top:0.2em;">
                <input type="text" name="user_name" class="form-control"/>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3" style="padding-top:0.2em;">
                <label for="user_name" class="control-label">密码</label>
              </div>
              <div class="col-md-9" style="padding-top:0.2em;">
                <input type="password" name="password" class="form-control"/>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3" style="padding-top:0.2em;"></div>
              <div class="col-md-9" style="padding-top:0.2em;">
                <input type="hidden" name="r" value="Articles/articles/daily"/>
                <input type="submit" class="btn btn-default" value="登录"/>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>
</body>
</html>
