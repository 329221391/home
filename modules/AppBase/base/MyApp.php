<?php

//自定义变量和错误类别
require(__DIR__ . '/../include/myinit.php');
if (!$_SESSION['customInfo']) {
    $_SESSION['customInfo'] = new CustomInfo ();
}
$_SESSION['customInfo']->getCustom()->name_zh = 'duoduo';


