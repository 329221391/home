<?php
use app\modules\AppBase\base\SiteCom;

?>
<!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content=" initial-scale=1.0,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<link href="css/css_white.css" rel="stylesheet" type="text/css">
<title>修改密码</title>
<script type="text/javascript" src="js/md5.js"></script>
<head>
</head>
<body>
<div class="z_title">修改密码</div>
<div id="ms_top"><a href=<?php echo SiteCom::$phone_url . "exit" ?> target="_self"><img class="f_sy"
                                                                                        src="images/back_0.png"></a>
</div>
<div class="x_mes top_60"><span class="mes_left">原始密码：</span><span class="mes_right"><input id="former_pd" type="password"
                                                                                            value=""></span>
</div>
<div class="x_mes"><span class="mes_left">新的密码：</span><span class="mes_right"><input id="new_pd" type="password"
                                                                                     value=""></span></div>
<div class="x_mes" style="border-bottom:#999999 solid 1px;"><span class="mes_left">再次确认：</span><span
        class="mes_right"><input id="renew_pd" type="password" value=""></span></div>
<div class="x_bottom"><a><span id="resetpd" class="x_bottom_left">重置密码</span></a><a><span id="editpd"
                                                                                          class="x_bottom_right">修改密码</span></a>
</div>
</body>
</html>
<script language="javascript">
    $("#resetpd").click(function () {
        $.post('index.php?r=Customs/customs/updatepassword-a', {
            id: "<?= $myid?>",
            password: hex_md5("123456")
        }, function (result) {
            if (result['ErrCode'] == "0") {
                alert('密码重置成功,下次登录请使用新密码');
            } else {
                alert(result['Message']);
            }
        }, "json");
    });
    $("#editpd").click(function () {
        var former_pd = $("#former_pd").val();
        var new_pd = $("#new_pd").val();
        var renew_pd = $("#renew_pd").val();
        if (former_pd == '') {
            alert('请输入原始密码');
        } else if (new_pd == '') {
            alert('请输入新密码');
        } else if (renew_pd == '') {
            alert('请确认新密码');
        } else if (new_pd != renew_pd) {
            alert('前后两次输入的新密码不一致');
        } else {
            $.post('index.php?r=Customs/customs/checkandsetpd-a', {
                id: "<?= $myid?>",
                former_pd: hex_md5(former_pd),
                new_pd: hex_md5(new_pd)
            }, function (result) {
                if (result['ErrCode'] == "0") {
                    alert('密码修改成功,下次登录请使用新密码');
                } else {
                    alert('请输入正确的原始密码');
                }
            }, "json");
        }
    });
</script>