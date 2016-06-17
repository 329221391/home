<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/3
 * Time: 14:14
 */
namespace app\modules\AppBase\base\appbase;
use app\modules\AppBase\base\CommonFun;
use Yii;
class BaseAnalyze
{
    const LOG_WEB_FILE = "web.log";
    const LOG_ANAL_FILE = "anal.log";
    const LOG_WASTE_TIME = "wastetime.log";
    const LOG_ERR = "err.log";
    public  function  writeToFile($content)
    {
        $content .= "\t" . CommonFun::getCurrentDateForFile();
        $content .= "\t" . Yii::$app->request->getUserIP();
        $content .= "\t" . Yii::$app->request->getUrl();
        $content .= "\t" . Yii::$app->request->getUserAgent();
        $content .= " \r\n";
        $fh = fopen(self::LOG_WEB_FILE, "a");//a追加
        fwrite($fh, $content);    // 输出：6
        fclose($fh);
    }
    public  function  writeToAnal($content)
    {
        $content .= " \r\n";
        $fh = fopen(self::LOG_ANAL_FILE, "a");//a追加
        fwrite($fh, $content);    // 输出：6
        fclose($fh);
    }
    public  function  writeToErr($content)
    {
        $content .= " \r\n";
        $fh = fopen(self::LOG_ERR, "a");//a追加
        fwrite($fh, $content);    // 输出：6
        fclose($fh);
    }
    public  function  writeToWasteTime($content)
    {
        $content .= " \r\n";
        $fh = fopen(self::LOG_WASTE_TIME, "a");//a追加
        fwrite($fh, $content);    // 输出：6
        fclose($fh);
    }
}