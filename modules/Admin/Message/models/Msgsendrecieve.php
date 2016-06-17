<?php

namespace app\modules\Admin\Message\models;
use app\modules\AppBase\base\appbase\base\BaseMsgSR;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "{{%msg_send_recieve}}".
 * @property integer $id
 * @property integer $message_id
 * @property integer $sender_id
 * @property integer $reciever_id
 * @property integer $isreaded
 * @property string $createtime
 * @property string $updatetime
 */
class Msgsendrecieve extends BaseMsgSR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%msg_send_recieve}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'sender_id', 'reciever_id', 'isreaded'], 'integer'],
            [['createtime', 'updatetime'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_id' => 'Message ID',
            'sender_id' => 'Sender ID',
            'reciever_id' => 'Reciever ID',
            'isreaded' => 'isreaded',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
    public function getMessages()
    {
        return $this::hasOne(Messages::className(), ['id' => 'message_id']);
    }
    /*
   * 添加消息后,添加发送接收者
   */
    public function addSenderAndReciever($msg_id, $reciever_id)
    {
        $sender_id = Yii::$app->session['custominfo']->custom->id;
        $reciever_id_array = CommonFun::explodeString('-', $reciever_id);
        foreach ($reciever_id_array as $v) {
            $msgsr = new Msgsendrecieve();
            $msgsr->message_id = $msg_id;
            $msgsr->sender_id = $sender_id;
            $msgsr->reciever_id = $v;
            $msgsr->createtime = CommonFun::getCurrentDateTime();
            $msgsr->updatetime = CommonFun::getCurrentDateTime();
            $msgsr->isreaded = HintConst::$YesOrNo_NO;
            $msgsr->save(false);
        }
    }
    /*
    * 分页获取消息列表
    */
    public function getMsgSR($page, $size)
    {
        if (!$this->checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
        } else {
            $reciever_id = Yii::$app->session['custominfo']->custom->id;
            $query = new Query();
            $msgList = $query->select(['msg_send_recieve.id', 'msg_send_recieve.isreaded', 'msg_send_recieve.sender_id', 'customs.name_zh as sender_name', 'msg_send_recieve.reciever_id', 'messages.contents', 'messages.createtime'])
                ->from('msg_send_recieve')
                ->where("msg_send_recieve.sender_id=$reciever_id or msg_send_recieve.reciever_id=$reciever_id")
                ->leftJoin('messages', 'messages.id = msg_send_recieve.message_id')
                ->leftJoin('customs', 'customs.id = msg_send_recieve.sender_id')
                ->orderBy("msg_send_recieve.id desc")
                ->limit($size)
                ->offset($size * ($page - 1))
                ->all();
//            $no = HintConst::$YesOrNo_NO;
//            Msgsendrecieve::updateAll(['isreaded' => HintConst::$YesOrNo_YES], "reciever_id = $reciever_id and isreaded=$no");//在取得数据后,直接将状态改为已读
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $Content = parent::getArray2No_Password($msgList);
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    /*
     * 获取未读消息列表
     */
    public function getMsgSRNoRead()   //no use
    {
        if (!$this->checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
        } else {
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $reciever_id = Yii::$app->session['custominfo']->custom->id;
            $query = new Query();
            $msgList = $query->select(['msg_send_recieve.id', 'msg_send_recieve.sender_id', 'customs.name_zh as sender_name', 'messages.contents', 'messages.createtime'])
                ->from('msg_send_recieve')
                ->where(['msg_send_recieve.isreaded' => HintConst::$YesOrNo_NO, 'msg_send_recieve.reciever_id' => $reciever_id])
                ->leftJoin('messages', 'messages.id = msg_send_recieve.message_id')
                ->leftJoin('customs', 'customs.id = msg_send_recieve.sender_id')
                ->all();
            $no = HintConst::$YesOrNo_NO;
            Msgsendrecieve::updateAll(['isreaded' => HintConst::$YesOrNo_YES], "reciever_id = $reciever_id and isreaded=$no");//在取得数据后,直接将状态改为已读
            $Content = parent::getArray2No_Password($msgList);
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    /*
     * 获取未读消息列表
     */
    public function getMsgrelationcustom()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $reciever_id = $this->getCustomId();
        $mc_name = 'getMsgrelationcustom' . $reciever_id . $this->getMcName();
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select(['sr.sender_id', 'customs.name_zh as sender_name', 'customs.cat_default_id', 'count(*) as num'])
                ->from('msg_send_recieve as sr')
                ->where(['sr.reciever_id' => $reciever_id])//isreaded没用了,新消息说已经推送过了
//                ->andWhere(['customs.ispassed' => HintConst::$YesOrNo_YES, 'customs.isdeleted' => HintConst::$YesOrNo_NO, 'customs.isout' => HintConst::$YesOrNo_NO])//这些限制了其不能登陆,就不能发短信
                ->leftJoin('customs', 'customs.id = sr.sender_id')
                ->groupBy('customs.id')
                ->orderBy('sr.createtime desc')
                ->limit(100)
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    /*
     * 获取未读消息列表_50条:结构和上面的一样
     */
    public function getMsgSR50($id)
    {
        if (!$this->checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
        } else {
            $msg_one_id = Yii::$app->session['custominfo']->custom->id;
            $msg_another_id = $id;
            $query = new Query();
            $msgList = $query->select(['msg_send_recieve.id', 'msg_send_recieve.sender_id', 'customs.name_zh as sender_name', 'messages.contents', 'messages.createtime'])
                ->from('msg_send_recieve')
                ->where("(msg_send_recieve.sender_id=$msg_one_id and msg_send_recieve.reciever_id=$msg_another_id) or (msg_send_recieve.sender_id=$msg_another_id and msg_send_recieve.reciever_id=$msg_one_id)")//注意筛选条件
                ->leftJoin('messages', 'messages.id = msg_send_recieve.message_id')
                ->leftJoin('customs', 'customs.id = msg_send_recieve.sender_id')
                ->orderBy("msg_send_recieve.id desc")
                ->limit(HintConst::$R_50)
                ->all();
//            $no = HintConst::$YesOrNo_NO;
//            Msgsendrecieve::updateAll(['isreaded' => HintConst::$YesOrNo_YES], "reciever_id = $msg_one_id and isreaded=$no");//在取得数据后,直接将状态改为已读,推送出去了,没有必要设置isread
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $Content = parent::getArray2No_Password($msgList);
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    /*
     * 获取未读消息列表_50条:结构和上面的一样
     */
    public function getMsgSR50TwoId($id, $another_id)
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        if (!$this->checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
        } else {
            $mc_name = $this->getMcName() . 'getMsgSR50TwoId' . $id . $another_id;
            if ($val = $this->mc->get($mc_name)) {
                $Content = $val;
            } else {
                $query = new Query();
                $msgList = $query->select(['msg_send_recieve.id', 'msg_send_recieve.sender_id', 'customs.name_zh as sender_name', 'messages.contents', 'messages.createtime'])
                    ->from('msg_send_recieve')
                    ->where("(msg_send_recieve.sender_id=$id and msg_send_recieve.reciever_id=$another_id) or (msg_send_recieve.sender_id=$another_id and msg_send_recieve.reciever_id=$id)")
                    ->leftJoin('messages', 'messages.id = msg_send_recieve.message_id')
                    ->leftJoin('customs', 'customs.id = msg_send_recieve.sender_id')
                    ->orderBy("msg_send_recieve.id desc")
                    ->limit(HintConst::$R_50)
                    ->all();
//                $no = HintConst::$YesOrNo_NO;
//                Msgsendrecieve::updateAll(['isreaded' => HintConst::$YesOrNo_YES], "reciever_id = $id and isreaded=$no");//在取得数据后,直接将状态改为已读
                $Content = parent::getArray2No_Password($msgList);
                $this->mc->add($mc_name, $Content);
            }
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
}
