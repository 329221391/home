<?php
/**
 * User: gjc
 *  2015/6/15 10:39
 */
namespace app\modules\Stats\controllers;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\StatsBC;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use Yii;
class UsedschController extends StatsBC
{
    public function  actionIndex()
    {
        $dt = isset($_REQUEST['s']) ? $_REQUEST['s'] : CommonFun::getCurrentDate();
        $enddate = isset($_REQUEST['e']) ? $_REQUEST['e'] : CommonFun::getCurrentDate();
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 18;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : CatDef::$mod['custom'];
        if ($dt >= $enddate) {
            $enddate = CommonFun::getDateRight($dt);
        }
        $sch = new Schools();
        $status = $sch->getSchByType($dt, $enddate, $type);
        $pathinfo=[ 'type'=>$type, 's' => $dt, 'e' => $enddate];
        return $this->render('index', ['status' => $status,'pathinfo'=>$pathinfo]);
    }
}