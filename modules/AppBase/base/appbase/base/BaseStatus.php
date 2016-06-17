<?php
/**
 * User: gjc
 *  2015/5/22 17:06
 */
namespace app\modules\AppBase\base\appbase\base;
use app\modules\AppBase\base\appbase\BaseAR;
use Yii;
class BaseStatus extends BaseAR
{
    public function checkIdBy($table_name, $m_id, $user_id)
    {
        $where = "m_id=$m_id AND user_id=$user_id";
        $query = $this->getMultTable($table_name, $m_id, 'id', $where);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    public function checkIdForOpt($table_name, $m_id, $m_opt_id, $user_id)
    {
        $where = "m_id=$m_id AND m_opt_id=$m_opt_id AND user_id=$user_id";
        $query = $this->getMultTable($table_name, $m_id, 'id', $where);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}