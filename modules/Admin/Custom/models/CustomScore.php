<?php

namespace app\modules\Admin\Custom\models;
use app\modules\AppBase\base\appbase\base\BaseEdit;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\BaseConst;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "custom_score".
 * @property integer $id
 * @property integer $custom_id
 * @property integer $pri_type_id
 * @property integer $sub_type_id
 * @property integer $related_id
 * @property string $contents
 * @property string $createtime
 */
class CustomScore extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_score';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_id', 'pri_type_id', 'sub_type_id', 'related_id'], 'integer'],
            [['createtime'], 'safe'],
            [['contents'], 'string', 'max' => 100]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'custom_id' => 'Custom ID',
            'pri_type_id' => 'Pri Type ID',
            'sub_type_id' => 'Sub Type ID',
            'related_id' => 'Related ID',
            'contents' => 'Contents',
            'createtime' => 'Createtime',
        ];
    }
    protected function addNew($d)
    {
        if (!isset($d['custom_id'])) {
            $d['custom_id'] = $this->getCustomId();
        }
        $d['createtime'] = CommonFun::getCurrentDateTime();
        return $this->addNewMultiTable('custom_score_', $d, 'school_id');
    }
    public function addNewFromEvent($e)
    {
        $this->addNew($e->data['d']);
    }
    public function gathor(&$week, &$today, &$yesterday)
    {
        $week = self::gathorweek();
        $today = self::gathortoday();
        $yesterday = self::gathoryesterday();
    }
    public function gathorweek()
    {
        $school_id = $this->getCustomSchool_id();
        $mc_name = $this->getMcName() . 'gathorweek' . $school_id;
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $tn = 'custom_score_' . $this->getTenMod($school_id);
            $sql = "SELECT custom_id, sum(score) as week FROM $tn where  school_id=$school_id AND week(createtime)=week(now()) group by custom_id order by custom_id";
            $mo = $this->queryAll($sql);
            $this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
    public function gathortoday()
    {
        $school_id = $this->getCustomSchool_id();
        $mc_name = $this->getMcName() . 'gathortoday' . $school_id;
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $tn = 'custom_score_' . $this->getTenMod($school_id);
            $sql = "SELECT custom_id, sum(score) as today FROM $tn where  school_id=$school_id AND to_days(createtime)=to_days(now()) group by custom_id order by custom_id";
            $mo = $this->queryAll($sql);
            $this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
    public function gathoryesterday()
    {
        $school_id = $this->getCustomSchool_id();
        $mc_name = $this->getMcName() . 'gathoryesterday' . $school_id;
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $tn = 'custom_score_' . $this->getTenMod($school_id);
            $sql = "SELECT custom_id, sum(score) as yesterday FROM $tn where  school_id=$school_id AND to_days(now())-to_days(createtime) = 1 group by custom_id order by custom_id";
            $mo = $this->queryAll($sql);
            $this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
    public function Scoredetail($id, $start, $end)
    {
        $school_id = $this->getCustomSchool_id();
        $mc_name = $this->getMcName() . 'Scoredetail' . $school_id . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $tn = 'custom_score_' . $this->getTenMod($school_id);
            $sql = "SELECT id,pri_type_id,p_s_type_id,sub_type_id,createtime,score,coin,related_id,contents  FROM $tn where  custom_id=$id and date_format(createtime,'%Y-%m-%d')  BETWEEN '$start' AND '$end' ORDER BY createtime DESC";
            $mo = $this->queryAll($sql);
            //$this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
    public function getdd()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$ZeroInt;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        if (!is_numeric($id) || $id == 0) {
            $ErrCode = HintConst::$NoId;
        } else {
            $Content = self::get_dd($id);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$WEB_JYQ, 'Content' => $Content];
        return json_encode($result);
    }
    private function get_dd($id)
    {
        $school_id = $this->getCustomSchool_id();
        $d = $this->getMultTable('custom_score_', $school_id, '*', 'id=' . $id);
        $tn = self::getTN($d);
        $r['tn'] = $tn;
        $r['id'] = $d['related_id'];
        if ($tn == BaseConst::$article_replies_T) {
            $article_id = json_decode((new BaseEdit())->getProp($tn, $d['related_id'], 'article_id'));
            $r['tn'] = BaseConst::$articles_T;
            $r['id'] = self::getid($article_id);
        } elseif ($tn == BaseConst::$notes_replies_T) {
            $article_id = json_decode((new BaseEdit())->getProp($tn, $d['related_id'], 'note_id'));
            $r['tn'] = BaseConst::$notes_T;
            $r['id'] = self::getid($article_id);
        } elseif ($tn == BaseConst::$vote_replies_T) {
            $article_id = json_decode((new BaseEdit())->getProp($tn, $d['related_id'], 'm_id'));
            $r['tn'] = BaseConst::$vote_T;
            $r['id'] = self::getid($article_id);
        }
        return $r;
    }
    private function  getid($article_id)
    {
        if ($article_id->ErrCode == 0) {
            return $article_id->Content;
        } else {
            return 0;
        }
    }
    public function getTN($d)
    {
        $tn = '';
        switch ($d['pri_type_id']) {
            case CatDef::$act['create']:
                switch ($d['sub_type_id']) {
                    case CatDef::$mod['pic']:
                        $tn = BaseConst::$article_attachment_T;
                        break;
                    case CatDef::$mod['article']:
                    case CatDef::$mod['moneva']:
                    case CatDef::$mod['termeva']:
                        $tn = BaseConst::$articles_T;
                        break;
                    case CatDef::$mod['note']:
                        $tn = BaseConst::$notes_T;
                        break;
                    case CatDef::$mod['club_topic']:
                    case CatDef::$mod['club_help']:
                    case CatDef::$mod['club_teacher']:
                    case CatDef::$mod['club_parent']:
                    case CatDef::$mod['club_se']:
                    case CatDef::$mod['club_po']:
                        $tn = BaseConst::$vote_T;
                        break;
                }
                break;
            case  CatDef::$act['reply']:
                switch ($d['sub_type_id']) {
                    case CatDef::$mod['pic']:
                        $tn = BaseConst::$article_replies_T;
                        break;
                    case CatDef::$mod['article']:
                    case CatDef::$mod['moneva']:
                    case CatDef::$mod['termeva']:
                        $tn = BaseConst::$article_replies_T;
                        break;
                    case CatDef::$mod['note']:
                        $tn = BaseConst::$notes_replies_T;
                        break;
                }
                break;
            case  CatDef::$act['note_reply']:
                $tn = BaseConst::$notes_replies_T;
                break;
            case  CatDef::$act['club_reply']:
                $tn = BaseConst::$vote_replies_T;
                break;
            case  CatDef::$act['addrf']:
                $tn = BaseConst::$redfl_T;
                break;
            default:
                $tn = '';
                break;
        }
        return $tn;
    }
}
