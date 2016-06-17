<?php

namespace app\modules\Stats\controllers;
use app\modules\AppBase\base\appbase\StatsBC;
use Yii;
class DefaultController extends StatsBC
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    //退出登录
    public function actionLoginOut()
    {
        Yii::$app->session->destroy();
        $url = Yii::$app->urlManager->createUrl(['Admin/admins/login']);
        return Yii::$app->getResponse()->redirect($url);
    }
}
