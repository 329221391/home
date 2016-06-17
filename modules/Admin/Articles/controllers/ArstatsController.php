<?php

namespace app\modules\Admin\Articles\controllers;

use app\modules\Admin\Articles\models\ArStats;
use app\modules\AppBase\base\appbase\BaseController;
class ArstatsController extends BaseController
{
    public function actionGetlist()
    {
        $arstats = new ArStats();
        $result = $arstats->Getlist();
        return ($result);
    }

}
