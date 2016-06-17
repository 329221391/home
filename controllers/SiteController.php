<?php

namespace app\controllers;
use app\models\ContactForm;
use app\models\LoginForm;
use app\modules\AppBase\base\appbase\SiteBC;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
class SiteController extends SiteBC
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionMyerror()
    {
        $this->myerror();
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSqhz()
    {
        return $this->render('sqhz');
    }
    public function actionSybz()
    {
        return $this->render('sybz');
    }
    public function actionGywm()
    {
        return $this->render('gywm');
    }
    public function actionLxwm()
    {
        return $this->render('lxwm');
    }
    public function actionZxns()
    {
        return $this->render('zxns');
    }
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionPhpinfo()
    {
        phpinfo();
    }
}
