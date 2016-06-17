<?php
function http_get($url){
    //初始化
    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //执行并获取HTML文档内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}

function http_get_json($url){
    $ret = http_get($url);
    return json_encode($ret);
}


function is_run($year){
    if($year%100==0){//判断世纪年
        if ($year%400==0&&$year%3200!=0){
            return true;
        }
        else{
            return false;
        }
    }
    else{//剩下的就是普通年了
        if($year%4==0&&$year%100!=0){
            return true;
        }
        else {
            return false;
        }
    }
}