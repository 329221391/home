<?php

namespace app\modules\Admin\Articles\controllers;
use app\modules\Admin\Articles\models\ArAtStats;
use app\modules\AppBase\base\appbase\BaseController;
class AratstatsController extends BaseController
{
    public function actionGetlist()
    {
        $aratstats = new ArAtStats();
        $result = $aratstats->Getlist();
        return ($result);
    }
}
