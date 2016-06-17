<?php

namespace app\modules\Admin\Redfl\controllers;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Redfl\models\Redfl;
use app\modules\Admin\Redfl\models\RedflSearch;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\appbase\MultThread;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * RedflController implements the CRUD actions for Redfl model.
 */
class RedflController extends BaseController
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
     * Lists all Redfl models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new RedflSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Redfl model.
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
     * Creates a new Redfl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Redfl();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Updates an existing Redfl model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ($this->checkAdminSession()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Deletes an existing Redfl model.
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
     * Finds the Redfl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Redfl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Redfl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionAddrf()
    {
        return (new Redfl())->Addrf();
    }
    public function actionGetfldetail()
    {
        return (new Redfl())->Getfldetail();
    }
    public function actionGetfldebyid()
    {
        return (new Redfl())->Getfldebyid();
    }
    public function actionGetflist()
    {
        return (new Redfl())->Getflist();
    }
    public function actionGetuserfl()
    {
        return (new Customs())->getFl();
    }
    public function actionPushaddrf()
    {
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $user[] = $user_id;
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_rf($token, $type, $id);
    }
}
