<?php
use yii\helpers\Html;

?>
<?= Html::cssFile('@web/css/bootstrap.css') ?>
<?= Html::cssFile('@web/css/main.css') ?>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>
<title>登录</title>
<script type="text/javascript">
    var userAgent = navigator.userAgent,
        rMsie = /(msie\s|trident.*rv:)([\w.]+)/,
        rFirefox = /(firefox)\/([\w.]+)/,
        rOpera = /(opera).+version\/([\w.]+)/,
        rChrome = /(chrome)\/([\w.]+)/,
        rSafari = /version\/([\w.]+).*(safari)/;
    var browser;
    var version;
    var ua = userAgent.toLowerCase();
    function uaMatch(ua) {
        var match = rMsie.exec(ua);
        if (match != null) {
            return {browser: "IE", version: match[2] || "0"};
        }
        var match = rFirefox.exec(ua);
        if (match != null) {
            return {browser: match[1] || "", version: match[2] || "0"};
        }
        var match = rOpera.exec(ua);
        if (match != null) {
            return {browser: match[1] || "", version: match[2] || "0"};
        }
        var match = rChrome.exec(ua);
        if (match != null) {
            return {browser: match[1] || "", version: match[2] || "0"};
        }
        var match = rSafari.exec(ua);
        if (match != null) {
            return {browser: match[2] || "", version: match[1] || "0"};
        }
        if (match != null) {
            return {browser: "", version: "0"};
        }
    }
    var browserMatch = uaMatch(userAgent.toLowerCase());
    if (browserMatch.browser) {
        browser = browserMatch.browser;
        version = browserMatch.version;
    }
    if (browser == "IE" && version != "11.0" && version != "12.0")
        alert("对不起，您的浏览器版本过低，会影响网页的正常浏览,为保证您的正常浏览,请用火狐浏览器，ie11.0以上浏览器或谷歌浏览器！");
</script>
</head>
<body class="login-body">
<div class="container">
    <?php if (isset($message)) { ?>
         <div class="alert alert-warning"><?= $message ?></div>
    <?php } else { ?>
         <?php } ?>
   <form class="form-signin" action="index.php?r=manage/default/login" method="post">
       <div class="form-signin-heading text-center">
           <h1 class="sign-title">园&nbsp;长&nbsp;登&nbsp;录</h1>
           <img src="images/login_logo.png" alt="">
       </div>
       <div class="login-wrap">
           <input name="user_name" type="text" class="form-control" placeholder="请输入手机号" autofocus>
           <input name="password" type="password" class="form-control" placeholder="请输入密码">

           <input type="hidden" name="r" value="Articles/articles/daily">
            <div class="remember-position">
              <label class="checkbox pull-left">
                <input type="checkbox" value="remember-me">记住我
              </label>
            </div>
             <div class="text-right">
               <a href="index.php?r=site/lxwm" title="请联系管理员">忘记密码？</a>|
               <a href="index.php?r=site/sqhz" title="申请合作">注册</a>
             </div>
           <button class="btn btn-block btn-lg btn-login1" type="submit">
              登&nbsp;录
           </button> 
       </div><!-- login-wrap结束 -->
   </form>
</div><!-- container结束 -->
</body>
</html>
