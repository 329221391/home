<?php
/**
 * User: gjc
 *  2015/6/15 10:39
 */
namespace app\modules\Stats\controllers;
use app\modules\Admin\Classes\models\Classes;
use app\modules\AppBase\base\appbase\StatsBC;
use app\modules\AppBase\base\CommonFun;
class ClassController extends StatsBC
{
    public function  actionIndex()
    {
        $dt = isset($_REQUEST['s']) ? $_REQUEST['s'] : CommonFun::getCurrentDate();
        $enddate = isset($_REQUEST['e']) ? $_REQUEST['e'] : CommonFun::getCurrentDate();
        if ($dt >= $enddate) {
            $enddate = CommonFun::getDateRight($dt);
        }
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 0;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $class = new Classes();
        $status = $class->getClassStatus($school_id);
        $pathinfo=['s' => $dt, 'e' => $enddate, 'school_id' => $school_id, 'name' => $name, 'type' => $type];
        return $this->render('index', ['status' => $status, 'pathinfo' => $pathinfo]);
    }
}