<?php
/**
 * User: gjc
 *  2015/6/15 10:39
 */
namespace app\modules\Stats\controllers;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\StatsBC;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
class CustomController extends StatsBC
{
    public function  actionIndex()
    {
        $dt = isset($_REQUEST['s']) ? $_REQUEST['s'] : CommonFun::getCurrentDate();
        $enddate = isset($_REQUEST['e']) ? $_REQUEST['e'] : CommonFun::getCurrentDate();
        if ($dt >= $enddate) {
            $enddate = CommonFun::getDateRight($dt);
        }
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 0;
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;
        $custom = new Customs();
        $status = $custom->getCustomStatus($school_id);
        $pathinfo=['s' => $dt, 'e' => $enddate, 'school_id' => $school_id, 'name' => $name, 'type' => $type];
        return $this->render('index', ['status' => $status,  'pathinfo' => $pathinfo]);
    }
    public function  actionRegcustom()
    {
        return json_encode(array("ErrCode" => HintConst::$Zero, "Message" => HintConst::$Success, "Content" => (new Customs())->RegCustom()));
    }
}