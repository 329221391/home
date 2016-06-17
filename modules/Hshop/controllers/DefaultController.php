<?php

namespace app\modules\Hshop\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBeauty()
    {
        return $this->render('beauty');
    }

    public function actionIdea()
    {
        return $this->render('idea');
    }

    public function actionInfant()
    {
        return $this->render('infant');
    }
}
