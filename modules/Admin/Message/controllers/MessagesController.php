<?php

namespace app\modules\Admin\Message\controllers;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Message\models\Messages;
use app\modules\Admin\Message\models\MessagesSearch;
use app\modules\AppBase\base\appbase\Asyn;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * MessagesController implements the CRUD actions for Messages model.
 */
class MessagesController extends BaseController
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
     * Lists all Messages models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new MessagesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Messages model.
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
     * Creates a new Messages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Messages();
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
     * Updates an existing Messages model.
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
     * Deletes an existing Messages model.
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
     * Finds the Messages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Messages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
     * 登录后发送私信
     */
    public function actionSendmsg()
    {
        $ErrCode = HintConst::$Zero;
        $contents = !empty($_REQUEST['contents']) ? $_REQUEST['contents'] : '';
        $reciever_id = !empty($_REQUEST['reciever_id']) ? $_REQUEST['reciever_id'] : '';
        if ($reciever_id == '') {
            $ErrCode = HintConst::$NoRecieverId;
        } elseif ($contents == '') {
            $ErrCode = HintConst::$NoContents;
        } else {
            $messages = new Messages();
            $result = $messages->Sendmsg($contents, $reciever_id);
            $this->push($reciever_id, $contents);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    public function push($user_id, $con)
    {
        $asyn = new Asyn();
        $asyn->pushsendmsg(['user_id' => $user_id, 'con' => $con]);
    }
    public function actionPushsendmsg()
    {
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $con = isset($_REQUEST['con']) ? $_REQUEST['con'] : '';
        $user = explode('-', $user_id);
        $custom = new Customs();
//        $token = $custom->getToken([], [], $user);
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_msg($token, $con);
    }
}
