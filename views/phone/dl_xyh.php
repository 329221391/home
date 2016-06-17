<?php

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
<title>注册</title>
<script type="text/javascript" src="js/cook.js"></script>
<head>
</head>
<body>
<div class="sy_logo"><img src="images/logo_mbweb.png"></div>
<div class=" clear dl">
    <input id="code" class="round_ty  mmjg1" value="班级码：" class="round_ty" onFocus="if (value =='班级码：'){value =''}"
           onBlur="if (value ==''){value='班级码：'}" name="" type="text"> <br>
    <input id="phone" class="round_ty" value="手机号码：" class="round_ty" onFocus="if (value =='手机号码：'){value =''}"
           onBlur="if (value ==''){value='手机号码：'}" type="text"> <br>
    <input id="submit" type="button"
           class=" button button-caution button-pill dlsz top_jl"
           value="下一步">
</div>
</body>
</html>
<script language="javascript">
    $("#submit").click(function () {
        var ltjphone = /^1\d{10}$/;
        var phone = $("#phone").val();
        phone = $.trim(phone);
        var code = $("#code").val();
        code = $.trim(code);
        if (code == "" || code == "班级码：") {
            alert("班级码不能为空")
        } else if (!ltjphone.test(phone)) {
            alert("请输入正确的家长手机号");
        } else {
            $.post('index.php?r=Classes/classes/checkcode-a', {
                code: code
            }, function (result) {
                if (result['ErrCode'] == "0") {
                    SetCookie('school_id', result['Content']['school_id']);
                    SetCookie('class_id', result['Content']['id']);
                    SetCookie('phone', phone);
                    window.location.href = 'index.php?r=phone/dl_ma';
                } else {
                    alert(result['Message']);
                }
            }, "json");
        }
    });
</script>