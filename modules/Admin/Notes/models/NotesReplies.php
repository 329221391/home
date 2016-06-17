<?php

namespace app\modules\Admin\Notes\models;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\base\BaseReply;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\appbase\TransAct;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use app\modules\AppBase\base\xgpush\XgPush;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "notes_replies".
 * @property integer $id
 * @property integer $note_id
 * @property string $contents
 * @property string $createtime
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $link_id
 */
class NotesReplies extends BaseReply
{
    private $sel_reply = 'r.id,r.note_id as m_id,r.createtime, r.contents,r.sender_id,c.name_zh as sender_name,r.receiver_id,cc.name_zh as receiver_name,a.author_id,ccc.name_zh as author_name';
    private $selforreply = 'notes_replies.*,customs.name_zh as sender_name,customs.cat_default_id as sender_role_id,c.name_zh as receiver_name,c.cat_default_id as receiver_role_id';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notes_replies';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_id', 'sender_id', 'receiver_id', 'link_id', 'cus_p', 'sys_p'], 'integer'],
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
            'note_id' => 'Note ID',
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
        $d['note_id'] = isset($_REQUEST['note_id']) ? $_REQUEST['note_id'] : '';
        $d['contents'] = isset($_REQUEST['contents']) ? $_REQUEST['contents'] : '';
        $d['sender_id'] = isset($_REQUEST['sender_id']) ? $_REQUEST['sender_id'] : $this->getCustomId();
        $d['receiver_id'] = isset($_REQUEST['receiver_id']) ? $_REQUEST['receiver_id'] : 0;
        $d['link_id'] = isset($_REQUEST['link_id']) ? $_REQUEST['link_id'] : 0;
        if (empty($d['note_id']) || !is_numeric($d['note_id'])) {
            $ErrCode = HintConst::$No_vote_id;
        } elseif (empty($d['contents'])) {
            $ErrCode = HintConst::$NoContents;
        } else {
            $d['sys_p'] = Score::getSysP('reply', '');
            $flag = $this->checkReply($d['note_id'], $d['sender_id']);
            if ($flag) {
                $ErrCode = HintConst::$Not_addscore;
                $d['sys_p'] = 0;
            }
            $Content = $this->addNew($d);
            if (!$flag) {
                $score = new Score();
                $data['related_id'] = $Content;
                $data['pri_type_id'] = CatDef::$act['note_reply'];
                $data['sub_type_id'] = CatDef::$mod['note'];
                $data['contents'] = $d['contents'];
                $score->ReplyPoint($data);
            }
            if ($d['receiver_id'] == 0) {
                $this->pushReplyByNoteid($d['note_id'], $d['contents']);
            } else {
                //$this->pushReplyByRecieverid($d['note_id'], $d['receiver_id'], $d['contents']);
                $query = new Query();
                $receive_user  = $query->select('id,token,school_id,token_type,class_id,cat_default_id')->from('customs')->where(['id'=>$d['receiver_id']])->one();
                if($receive_user){
                    $content_str = '65-252-'.$d['note_id'].'-'.$receive_user['school_id'].'-'.$receive_user['class_id'].'-'.$receive_user['id'];
                    $ret = XgPush::PushSingleToken(['type'=>$content_str,'head'=>'','body'=>'通知新回复:'.$d['contents']],$receive_user);
                    //die(var_export($ret,true));
                }
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return $result;
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
                ->from('notes_replies as r')
                ->leftjoin('customs as c', 'c.id = r.sender_id')
                ->leftjoin('customs as cc', 'cc.id = r.receiver_id')
                ->leftJoin('notes as a', 'a.id=r.note_id')
                ->leftjoin('customs as ccc', 'ccc.id = a.author_id')
                ->where("r.id in ($id)")
                ->orderby(['r.id' => SORT_DESC])
                ->groupBy('r.id')
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function addNew($d)
    {
        $d['createtime'] = CommonFun::getCurrentDateTime();
        $notereply = new NotesReplies();
        foreach ($d as $k => $v) {
            $notereply->$k = $v;
        }
        $notereply->save(false);
        return $notereply->attributes['id'];
    }
    public function Getreply()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $dd['m_id'] = $d['note_id'] = isset($_REQUEST['note_id']) ? $_REQUEST['note_id'] : '';
        $d['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        if (empty($d['note_id'])) {
            $ErrCode = HintConst::$No_vote_id;
        } else {
            (new Notes())->increaseF($d['note_id'], 'view_times');
            (new NotesView())->AddView($dd);
            $Content = $this->get_reply_list($d['note_id'], $d['page']);
        }
        return json_encode(['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content]);
    }
    public function get_reply_list($note_id, $page)
    {
        $type = $this->getCustomRole();
        $sender_id = $this->getCustomId();
        $mc_name = 'get_reply_list' . $sender_id . json_encode(func_get_args()) . $this->getMcName();
        $reply_list = array();
        if ($val = $this->mc->get($mc_name)) {
            $reply_list = $val;
        } else {
            if ($note_id > 0) {
                $query = new Query();
                $reply_list = $query->select($this->selforreply)
                    ->from('notes_replies')
                    ->distinct()
                    ->leftjoin('customs', 'customs.id = notes_replies.sender_id')
                    ->leftjoin('customs as c', 'c.id = notes_replies.receiver_id')
                    ->leftJoin('notes as n', 'n.id=notes_replies.note_id')
                    ->where(['notes_replies.note_id' => $note_id]);
                if ($type == HintConst::$ROLE_TEACHER) {
                    $reply_list = $reply_list->andWhere("n.author_id=$sender_id or notes_replies.sender_id=$sender_id or notes_replies.receiver_id =$sender_id ");
                } elseif ($type == HintConst::$ROLE_PARENT) {
                    $reply_list = $reply_list->andWhere("notes_replies.sender_id=$sender_id or notes_replies.receiver_id =$sender_id");
                }
                $reply_list = $reply_list->orderby(['notes_replies.link_id' => SORT_ASC, 'notes_replies.id' => SORT_ASC])
                    ->limit(10)
                    ->offset(($page - 1) * 10)
                    ->all();
            }
            $this->mc->add($mc_name, $reply_list);
        }
        return $reply_list;
    }
    public function pushReplyByNoteid($id, $con)
    {
        $note = new Notes();
        $user = $note->getAuthor($id);
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_reply($token, HintConst::$NOTE_PATH, $id, $con);
    }
    public function pushReplyByRecieverid($id, $reciever_id, $con)
    {
        $user[] = $reciever_id;
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_reply($token, HintConst::$NOTE_PATH, $id, $con);
    }
    public function Delreply()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
//            $sql = "DELETE FROM notes_replies WHERE id=$id OR link_id=$id";
//            $ErrCode = (new TransAct())->trans($sql);
            $t = \Yii::$app->db->beginTransaction();
            $this->forDeleteReplyScore($id);
            $t->commit();
            $ErrCode = 0;
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
//            $sql = "DELETE FROM notes_replies WHERE id=$id ";
//            $ErrCode = (new TransAct())->trans($sql);
            $t = \Yii::$app->db->beginTransaction();
            $this->forDeleteReplyScore($id);
            $t->commit();
            $ErrCode = 0;
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }


    public function forDeleteReplyScore($link_id){

        $query = new Query();
        $list = $query->select('id')
            ->from('notes_replies')
            ->where(['link_id'=>$link_id])
            ->all();
        if(!empty($list)){
            foreach ($list as $item) {
                $this->forDeleteReplyScore($item['id']);
            }
        }

        
        $connection = \Yii::$app->db;

        //删除积分记录,排除园长加分
        $table_name  = 'custom_score_'.$this->getTenMod($this->getCustomSchool_id());
        $command = $connection->createCommand("delete from $table_name where pri_type_id=".CatDef::$act['note_reply']." and related_id=$link_id and p_s_type_id <> 1  and sub_type_id=".CatDef::$mod['note']);
        $command->execute();
        //删除回复
        $command = $connection->createCommand("delete from notes_replies where id=$link_id");
        $command->execute();
    }

    protected function  checkReply($note_id, $sender_id)
    {
        $mo = self::find()
            ->where(['note_id' => $note_id, 'sender_id' => $sender_id])
            ->one();
        if ($mo !== null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
