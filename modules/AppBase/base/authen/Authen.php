<?php
/**
 * User: gjc
 *  2015/4/17 17:32
 */
namespace app\modules\AppBase\base\authen;
class Authen
{
    public function getsfkey($data)
    {
        return $this->encode($data);
    }
    public function checksfkey($sfkey)
    {
        return $this->decode($sfkey);
    }
    protected function encode($string = '', $skey = 'jcphp')
    {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key < $strCount && $strArr[$key] .= $value;
        return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
    }
    protected function decode($string = '', $skey = 'jcphp')
    {
        $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        return base64_decode(join('', $strArr));
    }
} 