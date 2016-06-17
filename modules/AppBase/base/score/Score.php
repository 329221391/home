<?php
/**
 * User: gjc
 *  2015/7/13 10:42
 */
namespace app\modules\AppBase\base\score;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Custom\models\CustomScore;
use app\modules\Admin\Vote\models\Vote;
use app\modules\AppBase\base\appbase\base\BaseEdit;
use app\modules\AppBase\base\BaseConst;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\base\Component;
class Score extends Component
{
    const CUSTOM_POINT = 'custom_point';
    const CUSTOMSCORE_POINT = 'customscore_point';
    const CUSTOM_COIN = 'custom_coin';
    const CUSTOMSCORE_COIN = 'customscore_coin';
    const REPLEY_POINT_N = 1;//回复积分
    const REPLEY_COIN_N = 1;//回复金币
    const CLUB_ARTI_CREATE_N = 5;//发布俱乐部文章
    const CLUB_TOPIC_CREATE_N = 2;//发布俱乐部话题
    const CLUB_SHARE_N = 1;//分享俱乐部文章
    const ARTI_CREATE_N = 1;//创建文章
    const NOTE_CREATE_N = 1;//创建通知
    const IMG_CREATE_N = 5;//发照片
    const IMG_SHARE_N = 2;//分享照片
    const RF_CREATE_N = 1;//红花
    const EVA_CREATE_N = 10;//月评价年评价
    const VOTE_CAST_N = 3; //参与投票
    const MEAL_EDIT_N = 2;//每天就2分
    const PRAISE_CREATE_N = 5;//发鼓励
    const LETTER_CREATE_N = 5;//发感谢信
    const HOMEWORK_CREATE_N = 1; //发作业
    const HOMEWORK_REPLY_CREATE_N = 1; //回复作业
    public static function getSysP($pri_type_id, $sub_type_id)
    {
        if (self::getCustomType() == HintConst::$ROLE_TEACHER || self::getCustomType() == HintConst::$ROLE_PARENT) {
            switch ($pri_type_id) {
                case 'create':
                    switch ($sub_type_id) {
                        case CatDef::$mod['pic']:
                            return self::IMG_CREATE_N;
                            break;
                        case CatDef::$mod['article']:
                            return self::ARTI_CREATE_N;
                            break;
                        case CatDef::$mod['moneva']:
                        case CatDef::$mod['termeva']:
                            return self::EVA_CREATE_N;
                            break;
                        case CatDef::$mod['note']:
                            return self::NOTE_CREATE_N;
                            break;
                        default:
                            return 0;
                            break;
                    }
                    break;
                case 'reply':
                    return self::REPLEY_POINT_N;
                    break;
                case 'cast_vote':
                    return self::VOTE_CAST_N;
                    break;
                default:
                    return 0;
                    break;
            }
        }
        return 0;
    }
    public function setCusP(&$d)
    {
        $tn = (new CustomScore())->getTN($d);
        if ($tn == BaseConst::$articles_T || $tn == BaseConst::$notes_T) {
            $title = json_decode((new BaseEdit())->getProp($tn, $d['related_id'], 'title'));
            $d['contents'] = $title->Content;
        } elseif ($tn == BaseConst::$article_attachment_T) {
            $id = json_decode((new BaseEdit())->getProp($tn, $d['related_id'], 'article_id'));
            $title = json_decode((new BaseEdit())->getProp('articles', $id->Content, 'title'));
            $d['contents'] = $title->Content;
        } elseif ($tn == BaseConst::$article_replies_T || $tn == BaseConst::$notes_replies_T || $tn == BaseConst::$vote_replies_T) {
            $contents = json_decode((new BaseEdit())->getProp($tn, $d['related_id'], 'contents'));
            $d['contents'] = $contents->Content;
        }
        (new BaseEdit())->edit($tn, $d['related_id'], 'cus_p', $d['score']);
    }
    public static function getCustomType()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->cat_default_id;
        }
        return HintConst::$ROLE_PARENT;
    }
    public function addPointInCustom($event_str, $num, $custom_id = 0)
    {
        $this->on($event_str, [new Customs(), 'addPoint'], ['num' => $num, 'custom_id' => $custom_id]);
        $this->trigger($event_str);
        $this->off($event_str);
    }
    public function addPointCustomScore($d)
    {
        self::addSchoolClass($d);
        $this->on(self::CUSTOMSCORE_POINT, [new CustomScore(), 'addNewFromEvent'], ['d' => $d]);
        $this->trigger(self::CUSTOMSCORE_POINT);
        $this->off(self::CUSTOMSCORE_POINT);
    }
    public function addCoinInCustom($event_str, $num, $custom_id = 0)
    {
        $this->on($event_str, [new Customs(), 'addCoin'], ['num' => $num, 'custom_id' => $custom_id]);
        $this->trigger($event_str);
        $this->off($event_str);
    }
    public function addCoinCustomScore($d)
    {
        self::addSchoolClass($d);
        $this->on(self::CUSTOMSCORE_COIN, [new CustomScore(), 'addNewFromEvent'], ['d' => $d]);
        $this->trigger(self::CUSTOMSCORE_COIN);
        $this->off(self::CUSTOMSCORE_COIN);
    }
    //addCoinCustomScore逻辑通用,此方法解决积分记录的custom_id class_id name_zh字段
    public function addCoinCustomScoreByTang($d){
        if(array_key_exists('custom_id',$d)){
            $mo = new Customs();
            $cus = $mo->findId($d['custom_id']);
            $d['school_id'] = $cus->school_id;
            $d['class_id'] = $cus->class_id;
            $d['custom_name'] = $cus->name_zh;
        }else{
            $d['school_id'] = Yii::$app->session['custominfo']->custom->school_id;
            $d['class_id'] = Yii::$app->session['custominfo']->custom->class_id;
            $d['custom_name'] = Yii::$app->session['custominfo']->custom->name_zh;
        }

        $this->on(self::CUSTOMSCORE_COIN, [new CustomScore(), 'addNewFromEvent'], ['d' => $d]);
        $this->trigger(self::CUSTOMSCORE_COIN);
        $this->off(self::CUSTOMSCORE_COIN);
    }
    protected function addSchoolClass(&$d)
    {
        if ($d['p_s_type_id']) {
            $mo = new Customs();
            $cus = $mo->findId($d['custom_id']);
            $d['school_id'] = $cus->school_id;
            $d['class_id'] = $cus->class_id;
            $d['custom_name'] = $cus->name_zh;
        } else {
            $d['school_id'] = Yii::$app->session['custominfo']->custom->school_id;
            $d['class_id'] = Yii::$app->session['custominfo']->custom->class_id;
            $d['custom_name'] = Yii::$app->session['custominfo']->custom->name_zh;
        }
    }
    public function ReplyPoint($d)
    {
        //Head have no score for castvote ;
        if ($this->getCustomType() == HintConst::$ROLE_TEACHER || $this->getCustomType() == HintConst::$ROLE_PARENT) {
            $d['p_s_type_id'] = 0;
            $d['score'] = self::REPLEY_POINT_N;
            $this->addPointInCustom(self::CUSTOM_POINT, $d['score']);
            $this->addPointCustomScore($d);
        }
    }
    public function ReplyCoin($d)
    {
        //Head only has coin ,this is for club;
        if ($this->getCustomType() == HintConst::$ROLE_HEADMASTER) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = CatDef::$act['club_reply'];
            $d['coin'] = self::REPLEY_COIN_N;
            $this->addCoinInCustom(self::CUSTOM_POINT, $d['coin']);
            $this->addCoinCustomScore($d);
        }
    }
    public function ClubArtiCreate($d)
    {
        //Head have no score for creating;
        if ($this->getCustomType() == HintConst::$ROLE_HEADMASTER) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = CatDef::$act['create'];
            $num = 0;
            if ($d['sub_type_id'] == CatDef::$mod['club_topic']) {
                $num = self::CLUB_TOPIC_CREATE_N;
            } elseif ($d['sub_type_id'] == CatDef::$mod['club_teacher'] || $d['sub_type_id'] == CatDef::$mod['club_parent'] || $d['sub_type_id'] == CatDef::$mod['club_se'] || $d['sub_type_id'] == CatDef::$mod['club_po']) {
                $num = self::CLUB_ARTI_CREATE_N;
            }
            $d['coin'] = $num;
            $this->addCoinInCustom(self::CUSTOM_POINT, $d['coin']);
            $this->addCoinCustomScore($d);
        }
    }
    public function ClubShare($id)
    {
        if ($this->getCustomType() == HintConst::$ROLE_HEADMASTER) {
            $club_arti = new Vote();
            $mo = $club_arti->findId($id);
            if ($mo !== null) {
                $share['p_s_type_id'] = $shared['p_s_type_id'] = 0;
                $share['pri_type_id'] = CatDef::$act['share'];
                $shared['pri_type_id'] = CatDef::$act['shared'];
                $share['sub_type_id'] = $shared['sub_type_id'] = $mo->pri_type_id;
                $share['related_id'] = $shared['related_id'] = $id;
                $share['coin'] = $shared['coin'] = self::CLUB_SHARE_N;
                $share['contents'] = $shared['contents'] = $mo->title;
                //deal with custom of share  分享人+1   园长加分不要了
//                $this->addCoinInCustom(self::CUSTOM_POINT, $share['coin']);
//                $this->addCoinCustomScore($share);
                //deal with custom of shared 作者+1
                $this->addCoinInCustom(self::CUSTOM_POINT, $shared['coin'], $mo->author_id);
                $this->addCoinCustomScore($shared);
            }
        }
    }
    public function ArtiCreate($d)
    {
        //Head have no score for creating;
        //园长审核的时候后也调用该方法,所以这里不能判断该用户是教师的时候才能创建
        //if ($this->getCustomType() == HintConst::$ROLE_TEACHER) {
        $d['p_s_type_id'] = 0;
        $d['pri_type_id'] = CatDef::$act['create'];
        $num = 0;
        if ($d['sub_type_id'] == CatDef::$mod['article']) {
            $num = self::ARTI_CREATE_N;
        } elseif ($d['sub_type_id'] == CatDef::$mod['moneva'] || $d['sub_type_id'] == CatDef::$mod['termeva']) {
            $num = self::EVA_CREATE_N;
        } elseif ($d['sub_type_id'] == CatDef::$mod['praise']){
            $num = self::PRAISE_CREATE_N;
        } elseif ($d['sub_type_id'] == CatDef::$mod['letter']){
            $num = self::LETTER_CREATE_N;
        }
        $d['score'] = $num;

        $this->addPointInCustom(self::CUSTOM_POINT, $d['score'],array_key_exists('custom_id',$d) ? $d['custom_id'] : 0);
        $this->addCoinCustomScoreByTang($d);
        //}
    }

    public function HomeworkCreate($d){
        if ($this->getCustomType() == HintConst::$ROLE_TEACHER) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = 1;
            $d['sub_type_id'] = CatDef::$mod['homework'];
            $num = self::HOMEWORK_CREATE_N;
            $d['score'] = $num;
            $this->addPointInCustom(self::CUSTOM_POINT, $d['score']);
            $this->addPointCustomScore($d);
        }
    }

    public function HomeworkReplyCreate($d){
        $d['p_s_type_id'] = 0;
        $d['pri_type_id'] = 2;
        $d['sub_type_id'] = CatDef::$mod['homework_reply'];
        $num = self::HOMEWORK_REPLY_CREATE_N;
        $d['score'] = $num;
        $this->addPointInCustom(self::CUSTOM_POINT, $d['score']);
        $this->addPointCustomScore($d);
    }

    public function NoteCreate($d)
    {
        //Head have no score for creating ;
        //if ($this->getCustomType() == HintConst::$ROLE_TEACHER) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = CatDef::$act['create'];
            $d['sub_type_id'] = CatDef::$mod['note'];
            $d['score'] = self::NOTE_CREATE_N;
            $this->addPointInCustom(self::CUSTOM_POINT, $d['score'],array_key_exists('custom_id',$d) ? $d['custom_id'] : 0);
            $this->addPointCustomScore($d);
        //}
    }
    public function ImgCreate($d)
    {
        //Head have no score for creating ;
        //if ($this->getCustomType() == HintConst::$ROLE_TEACHER) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = CatDef::$act['create'];
            $d['sub_type_id'] = CatDef::$mod['pic'];
            $d['score'] = self::IMG_CREATE_N;
            $this->addPointInCustom(self::CUSTOM_POINT, $d['score'],array_key_exists('custom_id',$d) ? $d['custom_id'] : 0);
            $this->addPointCustomScore($d);
        //}
    }
    public function VoteCast($d)
    {
        //Head have no score for castvote ;
        if ($this->getCustomType() == HintConst::$ROLE_TEACHER || $this->getCustomType() == HintConst::$ROLE_PARENT) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = CatDef::$act['cast_vote'];
            $d['score'] = self::VOTE_CAST_N;
            $this->addPointInCustom(self::CUSTOM_POINT, $d['score']);
            $this->addPointCustomScore($d);
        }
    }
    public function ImgShare($d)
    {
        //Head have no score for castvote ;
        if ($this->getCustomType() == HintConst::$ROLE_TEACHER || $this->getCustomType() == HintConst::$ROLE_PARENT) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = CatDef::$act['share_img'];
            $d['sub_type_id'] = CatDef::$mod['pic'];
            $d['score'] = self::IMG_SHARE_N;
            $this->addPointInCustom(self::CUSTOM_POINT, $d['score']);
            $this->addPointCustomScore($d);
        }
    }
    public function MealEdit()
    {
        //Head have no score for castvote ;
        if ($this->getCustomType() == HintConst::$ROLE_TEACHER) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = CatDef::$act['edit_meal'];
            $d['sub_type_id'] = 0;
            $d['related_id'] = 0;
            $d['score'] = self::MEAL_EDIT_N;
            $this->addPointInCustom(self::CUSTOM_POINT, $d['score']);
            $this->addPointCustomScore($d);
        }
    }
    public function Adopt($d, $num)
    {
        $d['p_s_type_id'] = 0;
        $d['pri_type_id'] = CatDef::$act['adopt'];
        $d['sub_type_id'] = 0;
        $d['coin'] = $num;
        $this->addCoinInCustom(self::CUSTOMSCORE_COIN, $num, $d['custom_id']);
        $this->addCoinCustomScore($d);
    }
    public function addRf($d)
    {
        if ($this->getCustomType() == HintConst::$ROLE_TEACHER) {
            $d['p_s_type_id'] = 0;
            $d['pri_type_id'] = CatDef::$act['addrf'];
            $d['score'] = self::RF_CREATE_N;
            $this->addPointInCustom(self::CUSTOM_POINT, $d['score'], $d['custom_id']);
            $this->addPointCustomScore($d);
        }
    }
    public function EditScoreByHead($d, $num)
    {
        //head can do this;  custom score
        if ($this->getCustomType() == HintConst::$ROLE_HEADMASTER || isset(Yii::$app->session['manage_user'])) {
            $d['p_s_type_id'] = 1;
            $d['score'] = $num;
            if (!($d['pri_type_id'] == CatDef::$act['custom_score'] && $d['sub_type_id'] == CatDef::$mod['custom_score'])) {
                self::setCusP($d);//and add contents ; headmast customs scores for medal,not to excute this.
            }
            $this->addPointInCustom(self::CUSTOMSCORE_POINT, $num, $d['custom_id']);
            $this->addPointCustomScore($d);
            return 0;
        } else {
            return HintConst::$Not_head;
        }
    }
    public function  Rankofhead()
    {
        return (new Customs())->Rankofhead();
    }
    public function  Rankofhl()
    {
        $inalllocation = null;
        $inselflocation = null;
        (new Customs())->Rankofhl($inalllocation, $inselflocation);
        return ['inalllocation' => array_slice($inalllocation, 0, 50), 'inselflocation' => array_slice($inselflocation, 0, 50)];
    }
    public function  Rankofteacher()
    {
        return (new Customs())->Rankofteacher();
    }
    public function  Rankoftl()
    {
        $inschool = null;
        (new Customs())->Rankoftl($inschool);
        return ['inschool' => $inschool];
    }
    public function  Rankofparent($id)
    {
        return (new Customs())->Rankofparent($id);
    }
    public function  Rankofpl()
    {
        $inschool = null;
        $inclass = null;
        (new Customs())->Rankofpl($inschool, $inclass);
        return ['inschool' => $inschool, 'inclass' => $inclass];
    }
    public function  Rankoftlforsum()
    {
        $teacher = (new Customs())->getRankForPoints(HintConst::$ROLE_TEACHER);
        $week = [];
        $today = [];
        $yesterday = [];
        (new CustomScore())->gathor($week, $today, $yesterday);
        self::combinRankforsum($teacher, $week, $today, $yesterday);
        return $teacher;
    }
    public function  Rankofplforsum()
    {
        $parent = (new Customs())->getRankForPoints(HintConst::$ROLE_PARENT);
        $week = [];
        $today = [];
        $yesterday = [];
        (new CustomScore())->gathor($week, $today, $yesterday);
        self::combinRankforsum($parent, $week, $today, $yesterday);
        return $parent;
    }
    protected function combinRankforsum(&$aim, $week, $today, $yesterday)
    {
        foreach ($aim as &$k1) {
            $k1['week'] = 0;
            $k1['today'] = 0;
            $k1['yesterday'] = 0;
            foreach ($week as $w) {
                if ($k1['id'] == $w['custom_id']) {
                    $k1['week'] = $w['week'];
                    break;
                }
            }
            foreach ($today as $w) {
                if ($k1['id'] == $w['custom_id']) {
                    $k1['today'] = $w['today'];
                    break;
                }
            }
            foreach ($yesterday as $w) {
                if ($k1['id'] == $w['custom_id']) {
                    $k1['yesterday'] = $w['yesterday'];
                    break;
                }
            }
        }
    }
    public function Scoredetail()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : CommonFun::getCurrentDate();
        $end = isset($_REQUEST['end']) ? $_REQUEST['end'] : CommonFun::getCurrentDate();
        if (!is_numeric($id) || $id == 0) {
            $ErrCode = HintConst::$NoId;
        } else {
            $Content = (new CustomScore())->Scoredetail($id, $start, $end);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$WEB_JYQ, 'Content' => $Content];
        return json_encode($result);
    }
}