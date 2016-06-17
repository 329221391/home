<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/18
 * Time: 10:47
 */
namespace app\modules\AppBase\base\appbase\base;
use app\modules\AppBase\base\appbase\LogToFile;
use app\modules\AppBase\base\HintConst;
class BaseExcept
{
    public function execpt_nosuccess($err = '')
    {
        $this->log($err);
        die(json_encode(array("ErrCode" => HintConst::$No_success, "Message" => HintConst::$NULL, "Content" => HintConst::$NULLARRAY)));
    }
    public function execpt_noteacherinfo($err = '')
    {
        $this->log($err);
        die(json_encode(array("ErrCode" => HintConst::$No_teacherinfo, "Message" => HintConst::$NULL, "Content" => HintConst::$NULLARRAY)));
    }
    public function execpt_notimage($err = '')
    {
        $this->log($err);
        die(json_encode(array("ErrCode" => HintConst::$No_notimage, "Message" => HintConst::$NULL, "Content" => HintConst::$NULLARRAY)));
    }
    public function log($err)
    {
        LogToFile::LogErr($err);
    }
}