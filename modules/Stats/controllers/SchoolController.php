<?php
/**
 * User: gjc
 *  2015/6/15 10:39
 */
namespace app\modules\Stats\controllers;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\StatsBC;
use app\modules\AppBase\base\CommonFun;
use Yii;
class SchoolController extends StatsBC
{
    public function  actionIndex()
    {
        $dt = isset($_REQUEST['s']) ? $_REQUEST['s'] : CommonFun::getCurrentDateTime();
        $enddate = isset($_REQUEST['e']) ? $_REQUEST['e'] : CommonFun::getCurrentDateTime();
        $sch_name = isset($_REQUEST['sch_name']) ? $_REQUEST['sch_name'] : '';
        if ($dt >= $enddate) {
            $enddate = CommonFun::getDateRight($dt);
        }
        $sch = new Schools();
        if (empty($sch_name)) {
            $status = $sch->getSchByDT($dt, $enddate);
        } else {
            $status = $sch->getSchByName($sch_name);
        }
        $pathinfo=[ 's' => $dt, 'e' => $enddate, 'sch_name' => $sch_name];
        return $this->render('index', ['status' => $status,'pathinfo' => $pathinfo]);
    }
    public function actionEdit()
    {
        $field = Yii::$app->request->get('field');
        $val = Yii::$app->request->get('val');
        $id = Yii::$app->request->get('id');
        if ($field && $val && $id) {
            $sch = new Schools();
            switch ($field) {
                case 'ispassed':
                    $sch->updateF($id, $field, $val);
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => $val];
                    return (json_encode($result));
                    break;
                default:
                    break;
            }
            $result = ['error' => 0, 'message' => '更新成功', 'content' => $val . ' <span class="glyphicon glyphicon-pencil"></span></span>'];
            return (json_encode($result));
        } else {
            $result = ['error' => 1, 'message' => '失败', 'content' => ''];
            return (json_encode($result));
        }
    }
}