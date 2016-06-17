<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/4
 * Time: 10:20
 */
namespace app\modules\AppBase\base\appbase;
class XmlAndJson
{
    /**
     * 把xml文件解析成数组
     * @param string $fileOrString 文件路径 or xml代码
     * @param bool $type true为 xml代码 ， false为xml文件
     * <a href="http://my.oschina.net/u/556800" target="_blank" rel="nofollow">@return</a>  array
     */
    public static function xml_to_json($fileOrString, $type = false)
    {
        $str = $type ? simplexml_load_string($fileOrString) : simplexml_load_file($fileOrString);
        $json = json_encode($str);
        $configData = json_decode($json, true);
        return $configData;
    }
    public static function xml_to_json2($fileOrString, $type = false)
    {
        $str = file_get_contents($fileOrString);
        var_dump($str);
        exit;
        $str = $type ? simplexml_load_string($fileOrString) : simplexml_load_file($fileOrString);
        $json = json_encode($str);
        $configData = json_decode($json, true);
        return $configData;
    }
}