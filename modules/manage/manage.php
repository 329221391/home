<?php

namespace app\modules\manage;
use app\modules\AppBase\base\appbase\BaseModule;
use Yii;
use yii\base\Module;
class manage extends Module
{
    public $controllerNamespace = 'app\modules\manage\controllers';
    public $layout = 'main';
    public function beforeAction($action)
    {
        $allow_arr = ['apkinfo', 'checkcode-a', 'login', 'user-share', 'addparent'];
        if (isset(Yii::$app->session['manage_user']) || in_array($action->id, $allow_arr)) {
            return true;
        } else {
            $url = Yii::$app->urlManager->createUrl(['manage/default/login']);
            return Yii::$app->getResponse()->redirect($url);
        }
    }
    public function set_layout($layout_name)
    {
        return $this->layout = $layout_name;
    }
    public function init()
    {
        Yii::$app->homeUrl = 'index.php?r=manage/school';
        parent::init();
    }
}
