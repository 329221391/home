<?php

namespace app\modules\Admin\Vote\models;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\base\BaseEdit;
use app\modules\AppBase\base\appbase\base\BaseReply;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\appbase\TransAct;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "vote_replies".
 * @property integer $id
 * @property integer $m_id
 * @property string $contents
 * @property string $createtime
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $link_id
 */
class VoteReplies extends BaseReply
{
    private $sel_reply = 'r.id,r.m_id,r.createtime, r.contents,r.sender_id,c.name_zh as sender_name,r.receiver_id,cc.name_zh as receiver_name,a.author_id,ccc.name_zh as author_name';
    private $selforreply = 'vote_replies.*,c1.name_zh as sender_name,c1.logo as sender_logo,c2.name_zh as receiver_name,c2.logo as receiver_logo';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_replies';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'sender_id', 'receiver_id', 'link_id'], 'integer'],
            [['createtime'], 'safe'],
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
            'contents' => 'Contents',
            'createtime' => 'Createtime',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'link_id' => 'Link ID',
        ];
    }
    public function Reply()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $d['m_id'] = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $d['contents'] = isset($_REQUEST['contents']) ? $_REQUEST['contents'] : '';
        $d['sender_id'] = isset($_REQUEST['sender_id']) ? $_REQUEST['sender_id'] : $this->getCustomId();
        $d['receiver_id'] = isset($_REQUEST['receiver_id']) ? $_REQUEST['receiver_id'] : 0;
        $d['link_id'] = isset($_REQUEST['link_id']) ? $_REQUEST['link_id'] : 0;
        if (empty($d['m_id']) || !is_numeric($d['m_id'])) {
            $ErrCode = HintConst::$No_vote_id;
        } elseif (empty($d['contents'])) {
            $ErrCode = HintConst::$NoContents;
        } else {
            $flag = $this->checkReply($d['m_id'], $d['sender_id']);
            if ($flag) {
                $ErrCode = HintConst::$Not_addscore;
            }
            $Content = $this->addNew($d);
            if (!$flag) {
                $score = new Score();
                $data['related_id'] = $Content;
                $data['sub_type_id'] = (new Vote())->getType($d['m_id'])['pri_type_id'];
                $data['contents'] = $d['contents'];
                $score->ReplyCoin($data);
            }
            if ($d['receiver_id'] == 0) {
                $this->pushReplyByVoteid($d['m_id'], $Content, $d['contents']);
            } else {
                $this->pushReplyByVoteRecieverid($d['m_id'], $d['receiver_id'], $Content, $d['contents']);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return $result;
    }
    public function addNew($d)
    {
        $d['createtime'] = CommonFun::getCurrentDateTime();
        $votereply = new VoteReplies();
        foreach ($d as $k => $v) {
            $votereply->$k = $v;
        }
        $votereply->save(false);
        return $votereply->attributes['id'];
    }
    public function Get_replybyid($id)
    {
        $mc_name = $this->getMcName() . 'Get_replybyid' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select($this->sel_reply)
                ->distinct()
                ->from('vote_replies as r')
                ->leftjoin('customs as c', 'c.id = r.sender_id')
                ->leftjoin('customs as cc', 'cc.id = r.receiver_id')
                ->leftjoin('vote as a', 'a.id = r.m_id')
                ->leftjoin('customs as ccc', 'ccc.id = a.author_id')
                ->where("r.id in ($id)")
                ->orderby(['r.id' => SORT_DESC])
                ->groupBy('r.id')
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function Getreply()
    {
        $this->mc->flush();
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $d['m_id'] = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $start_line = $page_size * ($page - 1);
        $role = $this->getCustomRole();
        if (empty($d['m_id'])) {
            $ErrCode = HintConst::$No_vote_id;
        } else {
            $Content = $this->get_reply_list_one($d['m_id'], $role, $start_line, $page_size);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$WEB_JYQ, 'Content' => $Content];
        return $result;
    }
    protected function get_reply_list_one($id, $type = 207, $start_line, $page_size)
    {
        $mc_name = 'get_reply_list' . json_encode(func_get_args()) . $this->tableName() . $this->getMcName();
        $reply_list = array();
        if ($val = $this->mc->get($mc_name)) {
            $reply_list = $val;
        } else {
            $sender_id = $this->getCustomId();
            if ($id > 0) {
                $query = new Query();
                $reply_list = $query->select($this->selforreply)
                    ->from('vote_replies ')
                    ->leftjoin('customs as c1', 'c1.id = vote_replies.sender_id')
                    ->leftjoin('customs as c2', 'c2.id = vote_replies.receiver_id')
                    ->where(['vote_replies.m_id' => $id, 'vote_replies.receiver_id' => 0]);
                if ($type == HintConst::$ROLE_TEACHER) {
                    $class_id = $this->getCustomClass_id();
                    $reply_list = $reply_list->andWhere("c1.class_id=$class_id or (vote_replies.sender_id=$sender_id or vote_replies.receiver_id =$sender_id) ");
                } elseif ($type == HintConst::$ROLE_PARENT) {
                    $reply_list = $reply_list->andWhere("vote_replies.sender_id=$sender_id or vote_replies.receiver_id =$sender_id");
                }
                $reply_list = $reply_list->orderby(['vote_replies.link_id' => SORT_ASC, 'vote_replies.id' => SORT_ASC])
                    ->offset($start_line)
                    ->limit($page_size)
                    ->all();
                $this->get_reply_list_two($reply_list);
            }
            $this->mc->add($mc_name, $reply_list);
        }
        return $reply_list;
    }
    protected function get_reply_list_two(&$reply_list)
    {
        $reply_list_two_list = [];
        $tmp = [];
        foreach ($reply_list as $k) {
            $reply_list_two_list[] = $this->get_reply_list_two_list($k['id']);
        }
        foreach ($reply_list_two_list as $a) {
            if (count($a) > 0) {
                foreach ($a as $b) {
                    $tmp[] = $b;
                }
            }
        }
        $this->merge_reply($reply_list, $tmp);
    }
    protected function get_reply_list_two_list($link_id)
    {
        $mc_name = 'get_reply_list_two_list' . json_encode(func_get_args()) . $this->tableName() . $this->getMcName();
        $reply_list = array();
        if ($val = $this->mc->get($mc_name)) {
            $reply_list = $val;
        } else {
            if ($link_id > 0) {
                $query = new Query();
                $reply_list = $query->select($this->selforreply)
                    ->from('vote_replies ')
                    ->leftjoin('customs as c1', 'c1.id = vote_replies.sender_id')
                    ->leftjoin('customs as c2', 'c2.id = vote_replies.receiver_id')
                    ->where("vote_replies.link_id=$link_id AND vote_replies.receiver_id>0");
                $reply_list = $reply_list->orderby(['vote_replies.id' => SORT_ASC])
                    ->offset(0)
                    ->limit(10)
                    ->all();
            }
            $this->mc->add($mc_name, $reply_list);
        }
        return $reply_list;
    }
    public function pushReplyByVoteid($id, $reply_id, $con)
    {
        $vote = new Vote();
        $user = $vote->getAuthor($id);
        $type = $vote->getType($id);
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_reply($token, $type['pri_type_id'], $reply_id, $con);
    }
    public function pushReplyByVoteRecieverid($id, $reciever_id, $reply_id, $con)
    {
        $type = (new Vote())->getType($id);
        $user[] = $reciever_id;
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_reply($token, $type['pri_type_id'], $reply_id, $con);
    }
    public function Adopt()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $reward = isset($_REQUEST['reward']) ? $_REQUEST['reward'] : 0;
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } elseif ($reward < 0 || !is_numeric($reward)) {
            $ErrCode = HintConst::$No_reward;
        } else {
            $r = $this->findId($id);
            if ($r !== null) {
                $r->is_ok = HintConst::$YesOrNo_YES;
                $r->save();
                (new BaseEdit())->edit('vote', $r->m_id, 'adopt_id', $id);
                $title = json_decode((new BaseEdit())->getProp('vote', $r->m_id, 'title'));
                $data['contents'] = $title->Content;
                $data['custom_id'] = $r->sender_id;
                $data['related_id'] = $id;
                if(is_numeric($reward) && $reward > 0){
                    $score = new Score();
                    $score->Adopt($data, $reward);
                }

                self::push($data['custom_id'], $r->m_id, $reward);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function push($user_id, $id, $reward)
    {
        $user = explode('-', $user_id);
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_adopt($token, CatDef::$mod['club_help'], $id, $reward);
    }
    public function Delreply()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $sql = "DELETE FROM vote_replies WHERE id=$id OR link_id=$id";
            $sql2 = "DELETE FROM vote_reply_att WHERE m_id=$id OR link_id=$id";
            $ErrCode = (new TransAct())->trans($sql, $sql2);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function Delrr()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $sql = "DELETE FROM vote_replies WHERE id=$id ";
            $sql2 = "DELETE FROM vote_reply_att WHERE m_id=$id";
            $ErrCode = (new TransAct())->trans($sql, $sql2);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    protected function  checkReply($m_id, $sender_id)
    {
        $mo = self::find()
            ->where(['m_id' => $m_id, 'sender_id' => $sender_id])
            ->one();
        if ($mo !== null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
