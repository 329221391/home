<?php
/**
 * User: gjc
 *  2015/6/15 10:39
 */
namespace app\modules\Stats\controllers;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\StatsBC;
class ProvinceController extends StatsBC
{
    public function  actionIndex()
    {
        $p = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
        $sch = new Schools();
        $status = $sch->getSchByProvince($p);
        $pathinfo=['p' => $p];
        return $this->render('index', ['status' => $status, 'pathinfo' => $pathinfo]);
    }
}