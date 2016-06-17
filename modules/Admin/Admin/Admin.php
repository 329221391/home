<?php

namespace app\modules\Admin\Admin;
use app\modules\AppBase\base\appbase\BaseModule;
class Admin extends BaseModule
{
    public $controllerNamespace = 'app\modules\Admin\Admin\controllers';
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
