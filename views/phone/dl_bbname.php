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
<title>宝宝名称</title>
<script type="text/javascript" src="js/cook.js"></script>
<head>
</head>
<body>
<div class="sy_logo"><img src="images/logo_mbweb.png"></div>
<div class=" clear dl">
    <input id="name_zh" class="round_ty" value="宝宝名称：" class="round_ty" onFocus="if (value =='宝宝名称：'){value =''}"
           onBlur="if (value ==''){value='宝宝名称：'}" type="text"> <br>
    <input id="submit" type="button"
           class=" button button-caution button-pill dlsz top_jl mmjg3"
           value="下一步">
</div>
</body>
</html>
<script language="javascript">
    $("#submit").click(function () {
        var name_zh = $("#name_zh").val();
        name_zh = $.trim(name_zh);
        if (name_zh == "" || name_zh == "宝宝名称：") {
            alert("请输入宝宝名称");
        } else {
            var phone = getCookie('phone');
            var school_id = getCookie('school_id');
            var class_id = getCookie('class_id');
            var password = getCookie('password');
            $.post('index.php?r=Customs/customs/addparent', {
                name_zh: name_zh,
                phone: phone,
                school_id: school_id,
                class_id: class_id,
                password: password
            }, function (result) {
                if (result['ErrCode'] == "0") {
                    window.location.href = 'index.php?r=phone/index_all';
                } else if (result['ErrCode'] == "9008") {
                    alert('该电话号码已经注册过了, 请联系管理员');
                }
            }, "json");
        }
    });
</script>