<?php

namespace app\modules\Admin\Admin\controllers;
use app\modules\Admin\Admin\models\Admins;
use app\modules\Admin\Admin\models\AdminsSearch;
use app\modules\AppBase\base\appbase\AdminBC;
use app\modules\AppBase\base\appbase\base\BaseEdit;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * AdminsController implements the CRUD actions for Admins model.
 */
class AdminsController extends AdminBC
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
     * Lists all Admins models.
     * @return mixed
     */
    public function actionLogin()
    {
//        $this->module->set_layout('main2');
        $statussite = 'Stats/info/index';
        if (isset(Yii::$app->session['admin_user'])) {
            $url = Yii::$app->urlManager->createUrl([$statussite]);
            return Yii::$app->getResponse()->redirect($url);
        } else {
            $user_name = isset($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : 0;
            $password = isset($_REQUEST['password']) ? trim($_REQUEST['password']) : 0;
            if ($user_name && $password) {
                //检查是不是正确
                $admin = Admins::find()->asarray()
                    ->where(['name' => md5($user_name), 'password' => md5($password)])
                    ->one();
                //检查不通过 就返回密码不对的用户提示
                if ($admin && is_array($admin) && $admin['id'] > 0) {
                    //检查是不是通过审核  可以使用
                    if ($admin['ispassed'] == HintConst::$YesOrNo_NO) {
                        return $this->render('login', ['message' => '账号未通过审核，耐心等待管理员审核']);
                    } elseif ($admin['isdeleted'] == HintConst::$YesOrNo_YES) {
                        return $this->render('login', ['message' => '账号已删除,或不存在']);
                    }
                    //建立session  要跟其他地方的不同
                    Yii::$app->session['admin_user'] = $admin;
                    $url = Yii::$app->urlManager->createUrl([$statussite]);
                    return Yii::$app->getResponse()->redirect($url);
                } else {
                    return $this->render('login', ['message' => '账号不正确，请查证后再登录']);
                }
            } else {
                return $this->render('login');
            }
        }
    }
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new AdminsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Admins model.
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
     * Creates a new Admins model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Admins();
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
     * Updates an existing Admins model.
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
     * Deletes an existing Admins model.
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
     * Finds the Admins model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admins the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admins::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPath()
    {
        echo $this->className();
        echo Yii::$app->className();
        var_dump(Yii::$app->getBasePath());
        var_dump(Yii::getAlias('system'));
        var_dump(Yii::$app->canGetProperty('system'));
    }
    public function actionGetconf()
    {
        $admins = new Admins();
        $result = $admins->GetConf();
        parent::myjsonencode($result);
    }
    public function actionMyflush()
    {
        $admin = new Admins();
        $admin->Myflush();
    }
    public function actionPhpinfo()
    {
        phpinfo();
    }

}
