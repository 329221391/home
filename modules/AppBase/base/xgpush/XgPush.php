<?php
/**
 * User: gjc
 *  2015/5/22 11:06
 */
namespace app\modules\AppBase\base\xgpush;
use app\modules\Admin\Articles\models\ArticleSendRevieve;
use app\modules\Admin\Custom\models\Customs;
use app\modules\admin\Redfl\models\Redfl;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;

class XgPush extends XingeApp
{
    const MAXSIZE_PUSHTILTE = 40;
    const IOSENV_PROD = 1;
    const IOSENV_DEV = 2;
    const XGPUSH = 'xgpush';
    const HEAD = 0;
    const TEACHER = 1;
    const PARENT = 2;
    const PENDINGARTICLE = '881';
    const PENDINGPIC = '880';
    const PENDINGEVA = '882';
    const PENDINGNOTE = '883';
    //园长:0;老师:1;家长:2;test:3
//    protected static $access_Id = ['2100117542', '2100117546', '2100117547', '2100116236'];
    protected static $access_Id = ['2100117542', '2100117546', '2100117547', '2200152115', '2200152119', '2200152118'];
//    protected static $secret_Key = ['ee1bca8656a012ce45b5c49faa61f446', '4ce33d4ee1c5f8c1c10a1c01c91ba055', 'db6a245f5568d29a0951b9be53e6f245', '38d63ed99c730afce78157971ae5690c'];
    protected static $secret_Key = ['ee1bca8656a012ce45b5c49faa61f446', '4ce33d4ee1c5f8c1c10a1c01c91ba055', 'db6a245f5568d29a0951b9be53e6f245', 'cc05ccd358f342151f4680ad1b4de428', '76df933b062d1cfadaea510ec3207930', 'b4b04b825a7be2ec806094bc613742bf'];
    public static function  myQueryInfoOfToken($token, $pos)
    {
        $push = new XingeApp(self::$access_Id[$pos], self::$secret_Key[$pos]);
        $ret = $push->QueryInfoOfToken($token);
        return ($ret);
    }
    public static function myPushTagAndroid($content, $tag, $pos)
    {
        $ret = parent::PushTagAndroid(self::$access_Id[$pos], self::$secret_Key[$pos], 'title', (string)$content, $tag);
        return $ret;
    }
    public static function myPushTagIos($content, $tag, $pos)
    {
        $ret = parent::PushTagIos(self::$access_Id[$pos], self::$secret_Key[$pos], $content, $tag, self::IOSENV_DEV);
        return $ret;
    }
    public static function myPushTokenAndroidMsg($content, $token, $pos)
    {
    	(new BaseAnalyze())->writeToAnal('myPushTokenAndroidMsg');
        $ret = parent::PushTokenAndroidMsg(self::$access_Id[$pos], self::$secret_Key[$pos], 'title', $content['type'], $token);
        return $ret;
    }
    public static function myPushTokenIos($content, $token, $pos)
    {
        $pos += 3;
        $ret = parent::PushTokenIos(self::$access_Id[$pos], self::$secret_Key[$pos], $content, $token, self::IOSENV_DEV);
//        $ba = new BaseAnalyze();
//        $ba->writeToAnal('PushByTokenIos: ' . $pos . '-' . json_encode($ret));
        return $ret;
    }
    public static function push_club($e)
    {
        $type = $e->data['id'] . self::getSender();
        self::myPushTagAndroid($type, 'head', self::HEAD);
        self::myPushTagIos(self::getContentForIosTag($e), 'head', self::HEAD+3);
    }
    protected static function getContentForIosTag($e)
    {
        $content['type'] = $e->data['id'] . self::getSender();
        $content['head'] = self::getHeadForIosTag($e->data['id']);
        $content['body'] = mb_substr($e->data['con'], 0, self::MAXSIZE_PUSHTILTE, 'utf-8');
        return $content;
    }
    protected static function getHeadForIosTag($type)
    {
        $head = '';
        $cat = CommonFun::explodeString('-', $type);
        switch ($cat[0]) {
            case CatDef::$mod['club_topic']:
                $head = "有一篇新话题";
                break;
            case CatDef::$mod['club_help']:
                $head = "有一篇新求助";
                break;
            case CatDef::$mod['club_teacher']:
                $head = "有一篇新教师学习";
                break;
            case CatDef::$mod['club_parent']:
                $head = "有一篇新家长学习";
                break;
            case CatDef::$mod['club_se']:
                $head = "有一篇新招生安全";
                break;
            case CatDef::$mod['club_po']:
                $head = "有一篇新政策法规";
                break;
        }
        return $head;
    }
    protected static function getSender()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            $cus = Yii::$app->session['custominfo']->custom;
            return '-' . $cus->school_id . '-' . $cus->class_id . '-' . $cus->id;
        } else {
            $headtoken = (new Customs())->getHeadmastToken();
            return '-' . $headtoken[0][0]['school_id'] . '-0-' . $headtoken[0][0]['id'];
        }
    }
    protected static function getReceiver($cusinfo)
    {
        return '-' . $cusinfo['school_id'] . '-' . $cusinfo['class_id'] . '-' . $cusinfo['id'];
    }
    protected static function getPending($type)
    {
        $cat = CommonFun::explodeString('-', $type);
        if ($cat[0] == HintConst::$ARTICLE_PATH) {
            $type = self::PENDINGARTICLE . '-' . $type;//待审文章
        } elseif ($cat[0] == HintConst::$HIGHLIGHT_PATH_NEW) {
            $type = self::PENDINGPIC . '-' . $type;//待审图片
        } elseif ($cat[0] == HintConst::$NIANPINGJIA_PATH || $cat[0] == HintConst::$YUEPINGJIA_PATH) {
            $type = self::PENDINGEVA . '-' . $type;//待审评价
        } elseif ($cat[0] == HintConst::$NOTE_PATH) {
            $type = self::PENDINGNOTE . '-' . $type;//待审通知
        }
        return $type;
    }
    public static function pushcommon($e)
    {
    	(new BaseAnalyze())->writeToAnal('pushcommon()');
        $type = $e->data['type'];
        $cat = CommonFun::explodeString('-', $type);
        if (self::getIsCanSend() == HintConst::$YesOrNo_NO && ($cat[0] == HintConst::$NOTE_PATH || $cat[0] == HintConst::$ARTICLE_PATH || $cat[0] == HintConst::$HIGHLIGHT_PATH_NEW || $cat[0] == HintConst::$NIANPINGJIA_PATH || $cat[0] == HintConst::$YUEPINGJIA_PATH)) {
            $e->data['type'] = self::getPending($type);
            (new BaseAnalyze())->writeToAnal('pushcommon->PushHeadToken()');
            self::PushHeadToken($e->data);
        } else {
        	(new BaseAnalyze())->writeToAnal('pushcommon->PushCusTokenList()');
            self::PushCusTokenList($e->data);
        }
    }
    protected static function PushCusTokenList($data)
    {
        $cat = CommonFun::explodeString('-', $data['type']);
        $headtoken = (new Customs())->getHeadmastToken();
        //(new BaseAnalyze())->writeToAnal(var_export($headtoken,true));
        $has_send_head = false;
        $head_token_str = '';
        if(!empty($headtoken)){
            self::PushToHeadIncondition($cat[0], $data, $headtoken[0][0]['id']);   //push to head
            $has_send_head = true;
            $head_token_str = $headtoken[0][0]['token'];
        }
        //self::PushToHeadIncondition($cat[0], $data, $headtoken[0][0]['id']);   //push to head
        foreach ($data['token'] as $kk) {
            foreach ($kk as $cusinfo) {
                if (/*$cusinfo['id'] == $headtoken[0][0]['id'] ||*/ $cusinfo['id'] == self::getCustomId()) {   //not to push to head ;not to push to self
                } else {
                	(new BaseAnalyze())->writeToAnal('PushCusTokenList for');
                	/*if($has_send_head && $head_token_str == $cusinfo['token']){
                		continue;
                	}*/
                    self::EditPushContent($cusinfo, $data['type'], $data['con']);
                }
            }
        }
    }
    protected static function PushToHeadIncondition($flag, $data, $head_id)//推送给园长
    {
        switch ($flag) {
            case  CatDef::$mod['reply']:
                return;
                $cat = CommonFun::explodeString('-', $data['type']);
                //die(var_export($cat,true));
                //用户回复通知
                if($cat[1] == HintConst::$NOTE_PATH){
                    $note_id = $cat[2];
                    $query = new Query();
                    $note_author = $query->select('notes.id,notes.author_id,customs.cat_default_id')->from('notes')
                        ->leftjoin('customs','customs.id = notes.author_id')
                        ->where(['notes.id'=>$note_id])->one();
                    if(!$note_author){
                        return;
                    }
                    //如果通知的作者是老师,那么新的回复就不推送给园长了
                    if($note_author['cat_default_id'] == HintConst::$ROLE_TEACHER){
                        return;
                    }
                    self::PushHeadToken($data);
                }
                if($cat[1] == HintConst::$ARTICLE_PATH){
                    $reply_id = $cat[2];
                    $query = new Query();
                    $article_author = $query->select('articles.id,articles.author_id,customs.cat_default_id')->from('article_replies')
                        ->leftjoin('articles','articles.id = article_replies.article_id')
                        ->leftjoin('customs','customs.id = articles.author_id')
                        ->where(['article_replies.id'=>$reply_id])->one();
                    if(!$article_author){
                        return;
                    }
                    //如果文章的作者是老师,那么新的回复就不推送给园长了
                    if($article_author['cat_default_id'] == HintConst::$ROLE_TEACHER){
                        return;
                    }
                    self::PushHeadToken($data);
                }
                break;
            case  CatDef::$mod['rf']:
            case  CatDef::$mod['gf']:
            case  CatDef::$mod['moneva']:
            case  CatDef::$mod['termeva']:
                break;
            case  CatDef::$mod['msg']:
                $reciever_id = $data['token'][0][0]['id'];
                if ($head_id == $reciever_id) {
                    self::PushHeadToken($data);
                }
                break;
            default:
                self::PushHeadToken($data);
        }
    }
    protected static function PushHeadToken($data)
    {
        $headtoken = (new Customs())->getHeadmastToken();
        foreach ($headtoken as $kk) {
            foreach ($kk as $cusinfo) {
                if ($cusinfo['id'] == self::getCustomId()) {
                } else {
                    self::EditPushContent($cusinfo, $data['type'], $data['con']);
                }
            }
        }
    }
    protected static function  EditPushContent($cusinfo, $type, $con)
    {
        $content = [];
        $cat = CommonFun::explodeString('-', $type);
        switch ($cat[0]) {
            case CatDef::$mod['reply']:
                return;
                if ($cat[1] == CatDef::$mod['moneva'] || $cat[1] == CatDef::$mod['termeva']) {
                    $c1 = $type . '-' . (new ArticleSendRevieve())->getEvaReceiver($cat[2]);
                } else {
                    $c1 = $type . self::getReceiver($cusinfo);
                }
                break;
            case CatDef::$mod['praise']:
            case CatDef::$mod['letter']:
            case CatDef::$mod['moneva']:
            case CatDef::$mod['termeva']:
                $c1 = $type . '-' . (new ArticleSendRevieve())->getEvaReceiver($cat[1]);
                break;
            case CatDef::$mod['rf']:
            case CatDef::$mod['gf']:
                $c1 = $type . '-' . (new Redfl())->getEvaReceiver($cat[1]);
                break;
            default:
                $c1 = $type . self::getReceiver($cusinfo);
                break;
        }
        $content['type'] = $c1;
        $content['head'] = self::getHeadofPush($cusinfo, $type);
        $content['body'] = mb_substr($con, 0, self::MAXSIZE_PUSHTILTE, 'utf-8');
        (new BaseAnalyze())->writeToAnal('EditPushContent');
        self::PushSingleToken($content, $cusinfo);
    }
    protected static function  getHeadofPush($cusinfo, $type)
    {
        $cat = CommonFun::explodeString('-', $type);
        switch ($cat[0]) {
            case CatDef::$mod['rf']:
            case CatDef::$mod['gf']:
                $head = $cusinfo['name_zh'] . '小朋友表现太棒了，得到了小红花：';
                break;
            case CatDef::$mod['club_topic']:
                $head = '您收到一篇新话题：';
                break;
            case CatDef::$mod['club_help']:
                $head = '您收到一篇新求助：';
                break;
            case CatDef::$mod['club_teacher']:
                $head = '您收到一篇新教师学习：';
                break;
            case CatDef::$mod['club_parent']:
                $head = '您收到一篇新家长学习：';
                break;
            case CatDef::$mod['club_se']:
                $head = '您收到一篇新招生安全：';
                break;
            case CatDef::$mod['club_po']:
                $head = '您收到一篇新政策趋势：';
                break;
            case CatDef::$mod['note']:
                $head = '您收到一篇新的通知：';
                break;
            case CatDef::$mod['msg']:
                $head = '您收到' . self::getCustomNamezh() . CatDef::$role[self::getCustomRole()] . '的私信：';
                break;
            case CatDef::$mod['vote']:
                $head = '幼儿园有一项新调查期待您的参与：';
                break;
            case CatDef::$mod['reply']:
                return;
                $head = self::getCustomNamezh() . CatDef::$role[self::getCustomRole()] . '的回复：';
                break;
            case CatDef::$mod['pic']:
                $head = '您收到一张关于' . $cusinfo['name_zh'] . '小朋友的新照片：';
                break;
            case CatDef::$mod['article']:
                $head = '您收到一篇新的文章：';
                break;
            case CatDef::$mod['praise']:
                $head = '您收到一篇新的点赞：';
                break;
            case CatDef::$mod['letter']:
                $head = '您收到一篇新的感谢信：';
                break;
            case CatDef::$mod['moneva']:
            case CatDef::$mod['termeva']:
                $head = '您收到' . self::getCustomNamezh() . '老师对' . $cusinfo['name_zh'] . '小朋友新评价：';
                break;
            case self::PENDINGPIC:
                $head = '您有新的照片需要审核!';
                break;
            case self::PENDINGARTICLE:
                $head = '您有新的文章需要审核!';
                break;
            case self::PENDINGEVA:
                $head = '您有新的评价需要审核!';
                break;
            case self::PENDINGNOTE:
                $head = '您有新的通知需要审核!';
                break;
            default:
                $head = $type . self::getReceiver($cusinfo);
                break;
        }
        return $head;
    }
    public static function  PushSingleToken($content, $cusinfo)
    {
    	(new BaseAnalyze())->writeToAnal('PushSingleToken');
        if ($cusinfo['id'] !== self::getCustomId()) {//not to push to self
            if ($cusinfo['token_type'] == 0 || empty($cusinfo['token_type'])) {
                return self::myPushTokenAndroidMsg($content, $cusinfo['token'], self::getPos(intval($cusinfo['cat_default_id'])));
            } else {
                return self::myPushTokenIos($content, $cusinfo['token'], self::getPos(intval($cusinfo['cat_default_id'])));
            }
        }
    }
    protected static function getPos($role)
    {
        switch ($role) {
            case HintConst::$ROLE_HEADMASTER:
                return self::HEAD;
                break;
            case HintConst::$ROLE_TEACHER:
                return self::TEACHER;
                break;
            case HintConst::$ROLE_PARENT:
                return self::PARENT;
                break;
            default :
                return self::HEAD;
                break;
        }
    }
    public static function getIsCanSend()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->iscansend;
        }
        return isset($_REQUEST['iscansend']) ? $_REQUEST['iscansend'] : 0;
    }
    public static function getCustomId()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->id;
        }
        return isset($_REQUEST['my_id']) ? $_REQUEST['my_id'] : 0;
    }
    public static function getCustomNamezh()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->name_zh;
        }
        return isset($_REQUEST['name_zh']) ? $_REQUEST['name_zh'] : 0;
    }
    public static function getCustomRole()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->cat_default_id;
        }
        return isset($_REQUEST['cat_default_id']) ? $_REQUEST['cat_default_id'] : 0;
    }
}