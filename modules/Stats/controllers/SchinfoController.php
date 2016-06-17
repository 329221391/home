<?php
/**
 * User: gjc
 *  2015/6/15 10:39
 */
namespace app\modules\Stats\controllers;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\StatsBC;
use app\modules\AppBase\base\CommonFun;
use Yii;
class SchinfoController extends StatsBC
{
    public function  actionIndex()
    {
        $dt = isset($_REQUEST['s']) ? $_REQUEST['s'] : CommonFun::getCurrentDateTime();
        $enddate = isset($_REQUEST['e']) ? $_REQUEST['e'] : CommonFun::getCurrentDateTime();
        if ($dt >= $enddate) {
            $enddate = CommonFun::getDateRight($dt);
        }
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 0;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $sch = new Schools();
        $status = $sch->getStatusBySchid($school_id, $dt, $enddate);
        if (!$school_id) {
            $name = '全部';
        }
        $pathinfo=[ 'type' => $type,'s' => $dt, 'e' => $enddate, 'school_id' => $school_id, 'name' => $name];
        return $this->render('index', ['status' => $status,'pathinfo'=>$pathinfo]);
    }
    public function actionMan()
    {
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 0;
        $custom = new Customs();
        Yii::$app->session['manage_user'] = $custom->getManagerSes($school_id);
        $url = Yii::$app->urlManager->createUrl(['manage/article/index']);
        return Yii::$app->getResponse()->redirect($url);
    }
}