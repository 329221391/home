<?php
/**
  * User: gjc
 *  2015/7/23 19:07
 */

namespace app\modules\AppBase\base\appbase\base;


use app\modules\AppBase\base\appbase\BaseAR;
class BaseFocus extends BaseAR{
    public function checkIdBy($table_name, $custom_id, $focused_id)
    {
        $where = "custom_id=$custom_id AND focused_id=$focused_id";
        $query = $this->getMultTable($table_name, $custom_id, 'id', $where);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

}