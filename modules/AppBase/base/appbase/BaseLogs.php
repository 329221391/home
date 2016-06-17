<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/6
 * Time: 14:16
 */
namespace app\modules\AppBase\base\appbase;
use Yii;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;
class BaseLogs
{
    const LOGS_PATH = 'log_files';
    public function Upload()
    {
        $log_file = UploadedFile::getInstanceByName('log');
        if ($log_file) {
            //检查文件大小 后缀
//            print_r($log_file);
            //检查文件后缀 是不是log
            if (strlen($log_file->name) - 4 !== strripos($log_file->name, '.log')) {
                $result = ['ErrCode' => '1', 'Message' => 'not log file', 'Content' => []];
                die (json_encode($result));
            }
            $log_path = self::LOGS_PATH . '/' . $this->getCustomRole() . '/' . $this->getCustomId() . '/';
            if (!is_dir($log_path)) {
                if (BaseFileHelper::createDirectory($log_path)) {
                } else {
                    $result = ['ErrCode' => '1', 'Message' => 'No permission', 'Content' => []];
                    die (json_encode($result));
                }
            }
            $log = $log_path . $log_file->name;
            $log_file->saveAs($log);    //保存日志到指定路径
            $result = ['ErrCode' => '0', 'Message' => 'success', 'Content' => []];
            die (json_encode($result));
        }
    }
    protected function getCustomId()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->id;
        }
        return 0;
    }
    public function getCustomRole()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->cat_default_id;
        }
        return 0;
    }
}