<?php

namespace app\modules\AppBase;
use app\modules\AppBase\base\appbase\BaseModule;
class AppBase extends BaseModule
{
    public $controllerNamespace = 'app\modules\AppBase\controllers';
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
