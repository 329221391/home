<?php

namespace app\modules\Admin\Message\controllers;
use app\modules\Admin\Message\models\Msgsendrecieve;
use app\modules\Admin\Message\models\MsgsendrecieveSearch;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * MsgsendrecieveController implements the CRUD actions for Msgsendrecieve model.
 */
class MsgsendrecieveController extends BaseController
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
     * Lists all Msgsendrecieve models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new MsgsendrecieveSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Msgsendrecieve model.
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
     * Creates a new Msgsendrecieve model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Msgsendrecieve();
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
     * Updates an existing Msgsendrecieve model.
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
     * Deletes an existing Msgsendrecieve model.
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
     * Finds the Msgsendrecieve model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Msgsendrecieve the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Msgsendrecieve::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
   * 获得msglist:获取登录用户未读的msg
   */
    public function  actionGetmsgsrlistA()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : '1';
        $size = !empty($_REQUEST['size']) ? $_REQUEST['size'] : '20';
        if ($page == '' || !is_numeric($page)) {
            $ErrCode = HintConst::$NoPage;
            $Message = HintConst::$NoPage_M;
        } elseif ($size == '' || !is_numeric($size)) {
            $ErrCode = HintConst::$NoSize;
            $Message = HintConst::$NoSize_M;
        } else {
            $this->mc_name .= $page;
            $this->mc_name .= $size;
            if ($val = $this->mc->get($this->mc_name)) {
                parent::myjsonencode($val);
            } else {
                $msgSR = new Msgsendrecieve();
                $result = $msgSR->getMsgSR($page, $size);
                parent::myjsonencode($result);
                $this->mc->add($this->mc_name, $result);
            }
        }
        if ($ErrCode != HintConst::$Zero) {
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    /*
   * 获得msglist:获取登录用户未读的msg
   */
    public function  actionGetmsgsrnoreadlistA()
    {
        if ($val = $this->mc->get($this->mc_name)) {
            parent::myjsonencode($val);
        } else {
            $msgSR = new Msgsendrecieve();
            $result = $msgSR->getMsgSRNoRead();
            parent::myjsonencode($result);
            $this->mc->add($this->mc_name, $result);
        }
    }
    /*
  * 获得相关用户的私信用户
  */
    public function  actionGetmsgrelationcustomA()
    {
        $msgSR = new Msgsendrecieve();
        $result = $msgSR->getMsgrelationcustom();
        parent::myjsonencode($result);
    }
    /*
  * 获得msglist:获取指定用户id的最近50条记录
  */
    public function  actionGetmsgsr50listA()
    {
        $ErrCode = HintConst::$Zero;
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '' || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $this->mc_name .= $id;
            if ($val = $this->mc->get($this->mc_name)) {
                parent::myjsonencode($val);
            } else {
                $msgSR = new Msgsendrecieve();
                $re = $msgSR->getMsgSR50($id);
                parent::myjsonencode($re);
                $this->mc->add($this->mc_name, $re);
            }
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    /*
  * 获得msglist:获取msg,指定双方用户id
  */
    public function  actionGetmsgsr50listTwoidA()
    {
        $ErrCode = HintConst::$Zero;
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $another_id = !empty($_REQUEST['another_id']) ? $_REQUEST['another_id'] : '';
        if ($id == '' || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else if ($another_id == '' || !is_numeric($another_id)) {
            $ErrCode = HintConst::$NoAnotherId;
        } else {
            $msgSR = new Msgsendrecieve();
            $re = $msgSR->getMsgSR50TwoId($id, $another_id);
            parent::myjsonencode($re);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
}
