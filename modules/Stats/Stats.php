<?php

namespace app\modules\Stats;
use app\modules\AppBase\base\appbase\BaseModule;
class Stats extends BaseModule
{
    public $controllerNamespace = 'app\modules\Stats\controllers';
    public $layout = 'main';
    public function init()
    {
        parent::init();
// custom initialization code goes here
    }
}
