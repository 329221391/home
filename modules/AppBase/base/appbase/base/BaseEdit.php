<?php
/**
 * User: gjc
 *  2015/7/28 16:42
 */
namespace app\modules\AppBase\base\appbase\base;
use app\modules\AppBase\base\HintConst;
use Yii;
class BaseEdit
{
    public function edit($table_name, $id, $field, $val)
    {
        $mo = (new BaseFactory())->getDBClass($table_name);
        if ($mo !== null) {
            if ($mo->hasAttribute($field)) {
                $r = json_decode($mo->updateF($id, $field, $val));
                $ErrCode = $r->ErrCode;
            } else {
                $ErrCode = HintConst::$NoProp;
            }
        } else {
            $ErrCode = HintConst::$No_table;
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public  function getProp($table_name, $id, $field)
    {
        $Content = HintConst::$NULLARRAY;
        $mo = (new BaseFactory())->getDBClass($table_name);
        if ($mo !== null) {
            if ($mo->hasAttribute($field)) {
                $r = json_decode($mo->getF($id, $field));
                $ErrCode = $r->ErrCode;
                $Content = $r->Content;
            } else {
                $ErrCode = HintConst::$NoProp;
            }
        } else {
            $ErrCode = HintConst::$No_table;
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => $Content];
        return json_encode($result);
    }
}