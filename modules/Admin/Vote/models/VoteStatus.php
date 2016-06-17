<?php

namespace app\modules\Admin\Vote\models;
use app\modules\AppBase\base\appbase\base\BaseEdit;
use app\modules\AppBase\base\appbase\base\BaseStatus;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
/**
 * This is the model class for table "vote_user".
 * @property integer $id
 * @property integer $m_id
 * @property integer $user_id
 * @property string $contents
 * @property string $createtime
 * @property integer $yesno
 */
class VoteStatus extends BaseStatus
{
    private $selstr = 'user_id,user_name,contents, yesno, createtime';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_status';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'user_id', 'yesno'], 'integer'],
            [['m_id', 'user_id', 'yesno', 'createtime'], 'safe'],
            [['contents'], 'string', 'max' => 500]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'm_id' => 'Vote ID',
            'user_id' => 'User ID',
            'contents' => 'Contents',
            'createtime' => 'Createtime',
            'yesno' => 'yesno',
        ];
    }
    public function Adduservote()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $d['m_id'] = isset($_REQUEST['vote_id']) ? trim($_REQUEST['vote_id']) : '';
        $d['user_id'] = Yii::$app->session['custominfo']->custom->id;
        $d['user_name'] = Yii::$app->session['custominfo']->custom->name_zh;
        $d['contents'] = isset($_REQUEST['contents']) ? trim($_REQUEST['contents']) : '';
        $d['yesno'] = isset($_REQUEST['yesno']) ? trim($_REQUEST['yesno']) : 'a';
        if (empty($d['m_id']) || !is_numeric($d['m_id'])) {
            $ErrCode = HintConst::$NoId;
        } elseif (empty($d['yesno']) || !is_numeric($d['yesno'])) {
            $ErrCode = HintConst::$No_yesno;
        } else {
            if ($this->checkIdBy('vote_status_', $d['m_id'], $d['user_id'])) {
                $ErrCode = HintConst::$AlreadVote;
            } else {
                $d['sys_p'] = Score::getSysP('cast_vote', '');
                $Content = $this->addNew($d);
                $vote = new Vote();
                if ($d['yesno'] == HintConst::$YesOrNo_YES) {
                    $vote->increaseF($d['m_id'], HintConst::$F_yes);
                } else {
                    $vote->increaseF($d['m_id'], HintConst::$F_no);
                }
                $score = new Score();
                $title = json_decode((new BaseEdit())->getProp('vote', $d['m_id'], 'title'));
                $data['contents'] = $title->Content;
                $data['related_id'] = $d['m_id'];
                $data['sub_type_id'] = CatDef::$mod['vote'];
                $score->VoteCast($data);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function addNew($d)
    {
        $d['createtime'] = CommonFun::getCurrentDateTime();
        return $this->addNewMultiTable('vote_status_', $d);
    }
    public function Getuservotelist($yesno)
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $m_id = isset($_REQUEST['vote_id']) ? trim($_REQUEST['vote_id']) : '';
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $mc_name = $this->getMcName() . 'Getuservotelist' . $m_id . $page . $page_size . $yesno;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            if (empty($m_id) || !is_numeric($m_id)) {
                $ErrCode = HintConst::$NoId;
            } else {
                $where = "m_id=$m_id AND yesno=$yesno";
                $Content = $this->getMultTable('vote_status_', $m_id, $this->selstr, $where, 1, $page);
            }
            $this->mc->add($mc_name, $Content);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function Checkuservote()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : $this->getCustomId();
        $m_id = isset($_REQUEST['vote_id']) ? trim($_REQUEST['vote_id']) : '';
        $mc_name = $this->getMcName() . 'Checkuservote' . $user_id . $m_id;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            if (empty($m_id) || !is_numeric($m_id)) {
                $ErrCode = HintConst::$NoId;
            } else {
                $where = "m_id=$m_id AND user_id=$user_id";
                $Content = $this->getMultTable('vote_status_', $m_id, 'count(id) as num', $where);
                $Content['opt'] = $this->getMultTable('vote_opt_status_', $m_id, 'count(id) as num', $where);
            }
            $this->mc->add($mc_name, $Content);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
}
