<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/24
 * Time: 14:30
 */
namespace app\modules\AppBase\base;
use Yii;
class SiteCom
{
    public static $site_url = "index.php?r=site/";//site的公共路径
    public static $phone_url = "index.php?r=phone/";//phone的公共路径
    public static $download_url = "index.php?r=download/";//download的公共路径
    public static function getImgUrl($url_org)
    {
        $host = str_replace('http://', '', Yii::$app->request->getHostInfo());
        return str_replace($host, '', $url_org);
    }
    public static function getRoleImg($type)
    {
        switch ($type) {
            case HintConst::$ROLE_HEADMASTER:
                return 'images/yz_48.png';
                break;
            case HintConst::$ROLE_TEACHER:
                return 'images/lstx48.png';
                break;
            case HintConst::$ROLE_PARENT:
                return 'images/jztx48.png';
                break;
        }
    }
    public static function getRoleName($type)
    {
        switch ($type) {
            case HintConst::$ROLE_HEADMASTER:
                return '园长';
                break;
            case HintConst::$ROLE_TEACHER:
                return '教师';
                break;
            case HintConst::$ROLE_PARENT:
                return '家长';
                break;
        }
    }
    public static function getIcon($type)
    {
        switch ($type) {
            case HintConst::$HIGHLIGHT_PATH_NEW:
                return 'images/icons_zp.png';
                break;
            case HintConst::$YUEPINGJIA_PATH:
                return 'images/icons_pj.png';
                break;
            case HintConst::$NIANPINGJIA_PATH:
                return 'images/icons_pj.png';
                break;
        }
    }
    public static function getArticleType($type)
    {
        switch ($type) {
            case HintConst::$HIGHLIGHT_PATH_NEW:
                return '精彩瞬间';
                break;
            case HintConst::$YUEPINGJIA_PATH:
                return '月评价';
                break;
            case HintConst::$NIANPINGJIA_PATH:
                return '年评价';
                break;
        }
    }
    public static function getactname($type)
    {
        switch ($type) {
            case HintConst::$WEBTYPE_ARTALL:
                $actname= 'ysq';
                break;
            case HintConst::$WEBTYPE_ARTME:
                $actname= 'ysq';
                break;
            case HintConst::$WEBTYPE_MEVA:
                $actname= 'babyevaluate';
                break;
            case HintConst::$WEBTYPE_YEVA:
                $actname= 'babyevaluate';
                break;
        }
        return $actname.'&webtype='.$type;
    }
}