<?php
/**
 * User: gjc
 *  2015/6/15 10:39
 */
namespace app\modules\Stats\controllers;
use app\modules\Admin\Vote\models\Club;
use app\modules\AppBase\base\appbase\StatsBC;
use app\modules\AppBase\base\cat_def\CatDef;
use Yii;
use yii\web\NotFoundHttpException;
class ClubController extends StatsBC
{
    public function  actionIndex()
    {
        $club = new Club();
        $d['pri_type_id'] = isset($_REQUEST['pri_type_id']) ? $_REQUEST['pri_type_id'] : CatDef::$mod['club_arti'];
        $status = $club->Club_list_for_audit($d);
        return $this->render('index', ['status' => $status, 'pri_type_id' => $d['pri_type_id']]);
    }
    public function actionView($id, $pri_type_id)
    {
        return $this->render('view', [
            'model' => (new Club())->Get_detail($id),
            'pri_type_id' => $pri_type_id
        ]);
    }
    public function actionDelete($id, $pri_type_id)
    {
        $club = $this->findModel($id);
        if ($club) {
            $club->delete();
        }
        return $this->redirect(['index', 'pri_type_id' => $pri_type_id]);
    }
    protected function findModel($id)
    {
        if (($model = Club::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}