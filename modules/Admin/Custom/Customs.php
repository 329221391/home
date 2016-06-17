<?php

namespace app\modules\Admin\Custom;
use app\modules\AppBase\base\appbase\BaseModule;
class Customs extends BaseModule
{
    public $controllerNamespace = 'app\modules\Admin\Custom\controllers';
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
