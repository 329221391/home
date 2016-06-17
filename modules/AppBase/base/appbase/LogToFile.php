<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/22
 * Time: 8:42
 */
namespace app\modules\AppBase\base\appbase;
use Yii;
class LogToFile
{
    public static function LogErr($something)
    {
        if (strlen($something) > 0) {
            $ba = new BaseAnalyze();
            $ba->writeToErr('error: '.Yii::$app->request->getUrl() . '|' . $something);
        }
    }
    public static function LogAnal($something)
    {
        if (strlen($something) > 0) {
            $ba = new BaseAnalyze();
            $ba->writeToAnal('anal: '.Yii::$app->request->getUrl() . '|' . $something);
        }
    }
}