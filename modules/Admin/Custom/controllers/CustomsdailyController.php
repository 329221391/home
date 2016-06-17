<?php

namespace app\modules\Admin\Custom\controllers;
use app\modules\Admin\Custom\models\Customsdaily;
use app\modules\Admin\Custom\models\CustomsdailySearch;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * CustomsdailyController implements the CRUD actions for Customsdaily model.
 */
class CustomsdailyController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Lists all Customsdaily models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomsdailySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Customsdaily model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new Customsdaily model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customsdaily();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Customsdaily model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Deletes an existing Customsdaily model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    /**
     * Finds the Customsdaily model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customsdaily the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customsdaily::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
    * 添加日常总结
   */
    public function actionOperatedaily()
    {
        $ErrCode = HintConst::$Zero;
        $data[HintConst::$Field_custom_id] = !empty($_REQUEST[HintConst::$Field_custom_id]) ? $_REQUEST[HintConst::$Field_custom_id] : '';
        $data[HintConst::$Field_daily_type_id] = !empty($_REQUEST[HintConst::$Field_daily_type_id]) ? $_REQUEST[HintConst::$Field_daily_type_id] : '';
        $data[HintConst::$Field_daily_contents] = !empty($_REQUEST[HintConst::$Field_daily_contents]) ? $_REQUEST[HintConst::$Field_daily_contents] : '';
        $data[HintConst::$Field_date] = !empty($_REQUEST[HintConst::$Field_date]) ? $_REQUEST[HintConst::$Field_date] : '';
        if ($data[HintConst::$Field_custom_id] == '' || !is_numeric($data[HintConst::$Field_custom_id])) {
            $ErrCode = HintConst::$NoCustomId;
        } elseif ($data[HintConst::$Field_daily_type_id] == '' || !is_numeric($data[HintConst::$Field_daily_type_id])) {
            $ErrCode = HintConst::$NoDailyTypeId;
        } elseif ($data[HintConst::$Field_daily_contents] == '') {
            $ErrCode = HintConst::$NoDailyContents;
        } elseif ($data[HintConst::$Field_date] == '' || !CommonFun::IsDate($data[HintConst::$Field_date])) {
            $ErrCode = HintConst::$NoDate;
        } else {
            $customsDaily = new Customsdaily();
            $result = $customsDaily->OperateDaily($data);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
}
