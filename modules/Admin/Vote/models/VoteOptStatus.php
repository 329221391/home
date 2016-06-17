<?php

namespace app\modules\Admin\Vote\models;
use app\modules\AppBase\base\appbase\base\BaseEdit;
use app\modules\AppBase\base\appbase\base\BaseStatus;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
/**
 * This is the model class for table "vote_opt_status".
 * @property integer $id
 * @property integer $m_id
 * @property integer $user_id
 * @property string $user_name
 * @property string $contents
 * @property integer $yesno
 * @property string $createtime
 */
class VoteOptStatus extends BaseStatus
{
    private $selstr = 'user_id,user_name,contents, yesno, createtime';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_opt_status';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'user_id', 'yesno'], 'integer'],
            [['createtime'], 'safe'],
            [['user_name'], 'string', 'max' => 20],
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
            'm_id' => 'M ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'contents' => 'Contents',
            'yesno' => 'Yesno',
            'createtime' => 'Createtime',
        ];
    }
    /**
     * @return string
     */
    public function Adduservoteopt()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $d['m_id'] = isset($_REQUEST['vote_id']) ? trim($_REQUEST['vote_id']) : '';
        $d['m_opt_id'] = isset($_REQUEST['vote_opt_id']) ? trim($_REQUEST['vote_opt_id']) : '';
        $d['user_id'] = Yii::$app->session['custominfo']->custom->id;
        $d['user_name'] = Yii::$app->session['custominfo']->custom->name_zh;
        $d['contents'] = isset($_REQUEST['contents']) ? trim($_REQUEST['contents']) : '';
        $d['yesno'] = isset($_REQUEST['yesno']) ? trim($_REQUEST['yesno']) : 'a';
        if (empty($d['m_id']) || !is_numeric($d['m_id']) || empty($d['m_opt_id']) || !is_numeric($d['m_opt_id'])) {
            $ErrCode = HintConst::$NoId;
        } elseif (empty($d['yesno']) || !is_numeric($d['yesno'])) {
            $ErrCode = HintConst::$No_yesno;
        } else {
            if ($this->checkIdForOpt('vote_opt_status_', $d['m_id'], $d['m_opt_id'], $d['user_id'])) {
                $ErrCode = HintConst::$AlreadVote;
            } else {
                $d['sys_p'] = Score::getSysP('cast_vote', '');
                $Content = $this->addNew($d);
                $voteopt = new VoteOpt();
                if ($d['yesno'] == HintConst::$YesOrNo_YES) {
                    $voteopt->increaseF($d['m_opt_id'], HintConst::$F_yes);
                } else {
                    $voteopt->increaseF($d['m_opt_id'], HintConst::$F_no);
                }
                $score = new Score();
                $title=json_decode((new BaseEdit())->getProp('vote', $d['m_id'], 'title'));
                $data['contents'] =$title->Content;
                $data['related_id'] = $d['m_id'];
                $data['sub_type_id'] = CatDef::$mod['opt'];
                $score->VoteCast($data);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function addNew($d)
    {
        $d['createtime'] = date('Y-m-d H:i:s', time());
        return $this->addNewMultiTable('vote_opt_status_', $d);
    }
    public function Getuservotelist($yesno)
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $m_id = isset($_REQUEST['vote_id']) ? trim($_REQUEST['vote_id']) : '';
        $m_opt_id = isset($_REQUEST['vote_opt_id']) ? trim($_REQUEST['vote_opt_id']) : '';
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $mc_name = $this->getMcName() . 'optGetuservotelist' . $m_id . $m_opt_id . $page . $page_size . $yesno;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            if (empty($m_id) || !is_numeric($m_id) || empty($m_opt_id) || !is_numeric($m_opt_id)) {
                $ErrCode = HintConst::$NoId;
            } else {
                $where = "m_id=$m_id AND m_opt_id=$m_opt_id AND yesno=$yesno";
                $Content = $this->getMultTable('vote_opt_status_', $m_id, $this->selstr, $where, 1, $page);
            }
            $this->mc->add($mc_name, $Content);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
}
