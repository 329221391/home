<?php

namespace app\modules\Admin\Apkversion\controllers;
use app\modules\Admin\Apkversion\models\Apkversion;
use app\modules\Admin\Apkversion\models\ApkversionSearch;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
/**
 * ApkversionController implements the CRUD actions for Apkversion model.
 */
class ApkversionController extends BaseController
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
     * Lists all Apkversion models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new ApkversionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Apkversion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ($this->checkAdminSession()) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    /**
     * Creates a new Apkversion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $rootPath = "apk/";
            $model = new Apkversion();
            if ($model->load(Yii::$app->request->post())) {
                $url = UploadedFile::getInstance($model, 'url');
                $ext = $url->getExtension();
                $randName = "hb" . $model->cat_default_id . CommonFun::getCurrentDateForFile() . "." . $ext;
                $url->saveAs($rootPath . $randName);
                $model->url = $rootPath . $randName;
                $model->createtime = CommonFun::getCurrentDateTime();
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Updates an existing Apkversion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ($this->checkAdminSession()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post())) {
                $url = UploadedFile::getInstance($model, 'url');
                $ext = $url->getExtension();
                $randName = "hb" . $model->cat_default_id . CommonFun::getCurrentDateForFile() . "." . $ext;
                $url->saveAs(HintConst::$DIR_APK . $randName);
                $model->url = HintConst::$DIR_APK . $randName;
                if ($model->save()) {
                    if ($model->cat_default_id == HintConst::$ROLE_PARENT) {
                        $file_name = HintConst::$FILE_PARENT_APK;
                    } elseif ($model->cat_default_id == HintConst::$ROLE_HEADMASTER) {
                        $file_name = HintConst::$FILE_MASTER_APK;
                    } elseif ($model->cat_default_id == HintConst::$ROLE_TEACHER) {
                        $file_name = HintConst::$FILE_TEACHER_APK;
                    }
                    copy($model->url, HintConst::$DIR_DOWNLOAD . $file_name);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Deletes an existing Apkversion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->checkAdminSession()) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
    }
    /**
     * Finds the Apkversion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apkversion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apkversion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionApkinfo()
    {
        $ErrCode = HintConst::$Zero;
        $role = !empty($_REQUEST['role']) ? $_REQUEST['role'] : '';
        if ($role == '' || !is_numeric($role)) {
            $ErrCode = HintConst::$NoRole;
        } else {
            //$this->mc_name_act .= $role;
            //if ($val = $this->mc->get($this->mc_name_act)) {
            //    parent::myjsonencode($val);
            //} else {
                $apkversion = new Apkversion();
                $result = $apkversion->getApkinfo($role);
                parent::myjsonencode($result);
            //  $this->mc->add($this->mc_name_act, $result);
            //}
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
}
