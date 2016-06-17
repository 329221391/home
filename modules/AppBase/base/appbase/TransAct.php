<?php
namespace app\modules\AppBase\base\appbase;
use app\modules\AppBase\base\appbase\base\BaseCommonDB;
use Yii;
/**
 * User: gjc
 *  2015/7/27 20:08
 * same to BaseDb1:but default to operate db
 */
class TransAct extends BaseCommonDB
{
    function __construct()
    {
        $this->setDb(Yii::$app->db) ;
    }
}