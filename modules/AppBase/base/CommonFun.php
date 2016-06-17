<?php
/**
 * Created by PhpStorm.
 * User: guojianchao
 * Date: 2014/10/16
 * Time: 9:06
 */
namespace app\modules\AppBase\base;
use app\modules\Admin\Classes\models\Classes;
use app\modules\Admin\School\models\Schools;
class CommonFun
{
    public static $Field_Must_Int = ['id', 'school_id', 'class_id', 'teacher_id', 'phone', 'ispassed', 'isdeleted', 'isout', 'isgraduated', 'iscansend', 'isstar'];
    public static function IsDate($date)
    {
        $result = preg_match("/^[0-9]{4}(\-|\/)[0-9]{1,2}(\\1)[0-9]{1,2}(|\s+[0-9]{1,2}(|:[0-9]{1,2}(|:[0-9]{1,2})))$/",
            $date);
        return $result;
    }
    public static function getDateTimeStart($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }
    public static function getDateTimeEnd($date)
    {
        return date('Y-m-d H:i:s', strtotime($date) + 24 * 3600);
    }
    public static function getDateLeft($date)
    {
        return date("Y-m-d", strtotime("-1 day", strtotime($date)));
    }
    public static function getDateRight($date)
    {
        return date("Y-m-d", strtotime("+1 day", strtotime($date)));
    }
    public static function BeyondDate($current_date, $date)
    {
        if (strtotime($current_date) < strtotime($date)) {
            return true;
        } else {
            return false;
        }
    }
    public static function ReError($error_msg)
    {
        header("location:../error.php?error_txt=" . $error_msg);
    }
    public static function getWebName($web_name)
    {
        return substr($web_name, 0, -4) . ".php";
    }
    public static function getsubdate($dt)
    {
        return substr($dt, 0, 10);
    }
    public static function getsubstr($str, $num = 301)
    {
        return substr($str, 0, $num);
    }
    public static function GtoU($value, $flag)
    {
        if ($flag == 1) {
            return iconv('GB2312', 'UTF-8', $value);
        } else {
            return $value;
        }
    }
    public static function UtoG($value, $flag)
    {
        if ($flag == 1) {
            return iconv('UTF-8', 'GB2312', $value);;
        } else {
            return $value;
        }
    }
    public static function json($ErrCode, $Message, $Content)
    {
        return json_encode(array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content));
    }
    public static function FileWrite($Content)
    {
        $fp = fopen("Log.txt", "a+");//文件被清空后再写入
        if ($fp) {
            $flag = fwrite($fp, $Content . "\n");
            if (!$flag) {
//                echo "写入文件失败<br>";
            }
        } else {
//            echo "打开文件失败";
        }
        fclose($fp);
    }
    public static function  getDateFitFormat($str)
    {
        return date("Y-m-d", strtotime($str));
    }
    public static function  getCurrentDateTime()
    {
        return date("Y-m-d H:i:s");
    }
    public static function  getCurrentDate()
    {
        return date("Y-m-d");
    }
    public static function  getCurrentTerm()
    {
        return date("Y");
    }
    public static function  getCurrentYm()
    {
        return date("Ym");
    }
    public static function  getCurrentDateForFile()
    {
        return date("YmdHis");
    }
    public static function encrypt($value)
    {
        if (strlen($value) == 32) {
            return $value;
        } else {
            return md5($value);
        }
    }
    public static function  generate_code($flag, $length = 8)
    {
        $school = new Schools();
        $classes = new Classes();
        if ($flag == HintConst::$SCHOOL) {
            while (1) {
                $code = CommonFun::generate_code_num();
                $result = $school->find()->where(['code' => $code])->one();
                if (is_null($result)) {
                    break;
                }
            }
        } elseif ($flag == HintConst::$CLASS) {
            while (1) {
                $code = CommonFun::generate_code_num($length);
                $result = $classes->find()->where(['code' => $code])->one();
                if (is_null($result)) {
                    break;
                }
            }
        }
        return $code;
    }
    public static function  generate_code_num($length = 8)
    {
        return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
    }
    public static function must_int($flag)
    {
        foreach (self::$Field_Must_Int as $v) {
            if ($flag == $v) {
                return true;
                break;
            }
        }
        return false;
    }
    public static function array_depth($array)
    {
        if (!is_array($array)) return 0;
        $max_depth = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = array_depth($value) + 1;
                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }
        return $max_depth;
    }
    public static function explodeString($char, $string)
    {
        return explode($char, $string);
    }
    public static function array2to1($arr, $field)
    {
        $aim = [];
        foreach ($arr as $k => $v) {
            $aim[] = $v[$field];
        }
        return $aim;
    }
    public static function substr_cut($str_cut, $length)
    {//please use mb_strsub
        if (strlen($str_cut) > $length) {
            for ($i = 0; $i < $length; $i++)
                if (ord($str_cut[$i]) > 128) $i++;
            $str_cut = substr($str_cut, 0, $i) . "..";
        }
        return $str_cut;
    }
}