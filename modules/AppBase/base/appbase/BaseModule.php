<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/23
 * Time: 11:38
 */
namespace app\modules\AppBase\base\appbase;
use Yii;
use yii\base\Module;
class BaseModule extends Module
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->initException();
    }
    protected function initException()
    {
        Yii::setAlias('@base', dirname(__DIR__));
        Yii::$app->errorHandler->errorView = '@base/myerror.php';
        Yii::$app->errorHandler->exceptionView = '@base/myerror.php';
    }
}