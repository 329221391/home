<?php

namespace app\modules\Res;
use app\modules\AppBase\base\appbase\BaseModule;
class Res extends BaseModule
{
    public $controllerNamespace = 'app\modules\Res\controllers';
    public $layout = 'main';
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
