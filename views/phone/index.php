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
<link href="css/buttons.css" rel="stylesheet" type="text/css">
<link href="css/css.css" rel="stylesheet" type="text/css">
<title>登录</title>
<script type="text/javascript" src="js/md5.js"></script>
<head>
</head>
<body>
<div class="sy_logo"><img src="images/logo_mbweb.png"></div>
<div class=" clear dl">
    <input id="phone" class="round_ty" value="家长手机：" class="round_ty" onFocus="if (value =='家长手机：'){value =''}"
           onBlur="if (value ==''){value='家长手机：'}" name="" type="text" /> <br>
     <input name="" type="text"class="round_ty mmjg" value="密码："  id="tx"   />
 <input name="" type="password" class="round_ty mmjg" style="display:none;" id="password" /> <br>
    <input id="submit" type="button" class=" button button-caution button-pill dlsz" value="登&nbsp;录" />
</div>
<div class="xm" style="margin-top:2.2rem;"><span class="left">忘记密码</span><span class="right"><a
            href=<?php echo SiteCom::$phone_url . "dl_xyh" ?> target="_self">新用户</a></span></div>
</body>
</html>
<script language="javascript">
var tx = document.getElementById("tx"), pwd = document.getElementById("password");
 tx.onfocus = function(){
 if(this.value != "密码：") return;
 this.style.display = "none";
 pwd.style.display = "";
 pwd.value = "";
 pwd.focus();
 }
 pwd.onblur = function(){
 if(this.value != "") return;
 this.style.display = "none";
 tx.style.display = "";
 tx.value = "密码：";
 }//上面为新增密码变为点号
    $("#submit").click(function () {
        var ltjphone = /^1\d{10}$/;
        var phone = $("#phone").val();
        phone = $.trim(phone);
        var password = $("#password").val();
        password = $.trim(password);
        var cat_default_id = 209;
        if (password == "" || password == "密码：") {
            alert("密码不能为空")
        }
        else if (!ltjphone.test(phone)) {
            alert("请输入正确的家长手机号");
        }
        else {
            $.post('index.php?r=Customs/customs/login-a-h', {
                phone: phone,
                password: hex_md5(password),
                cat_default_id: cat_default_id
            }, function (result) {
                if (result['ErrCode'] == "0") {
                    window.location.href = 'index.php?r=phone/index_all';
                } else {
                    alert(result['Message']);
                }
            }, "json");
        }
    });
</script>