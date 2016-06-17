<?php

namespace app\modules\Shop;

use app\modules\AppBase\base\appbase\BaseModule;
class Shop extends BaseModule
{
    public $controllerNamespace = 'app\modules\Shop\controllers';
    public $layout = 'main';
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
