<?php
?><!DOCTYPE HTML>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content=" initial-scale=1.0,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<link href="css/buttons.css" rel="stylesheet" type="text/css">
<link href="css/css.css" rel="stylesheet" type="text/css">
<title>密码设置</title>
<script type="text/javascript" src="js/cook.js"></script>
<head>
</head>
<body>
<div class="sy_logo"><img src="images/logo_mbweb.png"></div>
<div class=" clear dl">
    <input name="" type="text" class="round_ty  mmjg2" value="密码：" id="tx"/>
    <input name="" type="password" class="round_ty  mmjg2" style="display:none;" id="pd"/>
    <!--    <input id="pd" class="round_ty  mmjg2" value="密码：" class="round_ty" onFocus="if (value =='密码：'){value =''}"
               onBlur="if (value ==''){value='密码：'}" name="" type="text"/>--> <br>
    <input name="" type="text" class="round_ty  " value="重复密码：" id="tx1"/>
    <input name="" type="password" class="round_ty  " style="display:none;" id="repd"/>
    <!--    <input id="repd" class="round_ty" value="重复密码：" class="round_ty" onFocus="if (value =='重复密码：'){value =''}"
               onBlur="if (value ==''){value='重复密码：'}" type="text"/>--> <br>
    <input id="submit" type="button"
           class=" button button-caution button-pill dlsz top_jl"
           value="下一步"/>
</div>
</body>
</html>
<script language="javascript">
    var tx = document.getElementById("tx"), pwd = document.getElementById("pd");
    tx.onfocus = function () {
        if (this.value != "密码：") return;
        this.style.display = "none";
        pwd.style.display = "";
        pwd.value = "";
        pwd.focus();
    }
    pwd.onblur = function () {
        if (this.value != "") return;
        this.style.display = "none";
        tx.style.display = "";
        tx.value = "密码：";
    }
    var tx1 = document.getElementById("tx1"), pwd1 = document.getElementById("repd");
    tx1.onfocus = function () {
        if (this.value != "重复密码：") return;
        this.style.display = "none";
        pwd1.style.display = "";
        pwd1.value = "";
        pwd1.focus();
    }
    pwd1.onblur = function () {
        if (this.value != "") return;
        this.style.display = "none";
        tx1.style.display = "";
        tx1.value = "重复密码：";
    }//上面为新增密码变为点号
    $("#submit").click(function () {
        var pd = $("#pd").val();
        pd = $.trim(pd);
        var repd = $("#repd").val();
        repd = $.trim(repd);
        if (pd == "" || pd == "密码：") {
            alert("请输入正确的家长手机号");
        } else if (repd == "" || repd == "重复密码：") {
            alert("请确认密码")
        } else if (pd != repd) {
            alert("两次输入的密码不一致")
        }
        else {
            SetCookie('password', pd);
            window.location.href = 'index.php?r=phone/dl_bbname';
        }
    });
</script>