<?php

namespace app\modules\Admin\Message\models;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "{{%messages}}".
 * @property integer $id
 * @property integer $school_id
 * @property integer $class_id
 * @property string $contents
 * @property integer $ispassed
 * @property integer $isdeleted
 * @property integer $isview
 * @property integer $istimer
 * @property string $starttime
 * @property string $endtime
 * @property string $createtime
 * @property string $updatetime
 */
class Messages extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%messages}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id', 'class_id', 'ispassed', 'isdeleted', 'isview', 'istimer'], 'integer'],
            [['contents', 'school_id', 'class_id', 'ispassed', 'isdeleted', 'isview', 'istimer', 'starttime', 'endtime', 'createtime', 'updatetime'], 'safe'],
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
            'school_id' => 'School ID',
            'class_id' => 'Class ID',
            'contents' => 'Contents',
            'ispassed' => 'ispassed',
            'isdeleted' => 'Isdeleted',
            'isview' => 'Isview',
            'istimer' => 'Istimer',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
    public function getMsgsendrecieve()
    {
        return $this::hasMany(Msgsendrecieve::className(), ['message_id', 'id'])->orderBy('id desc');
    }
    /*
    * //园长添加教师的信息,在返回的group中也有,
    */
    public function Sendmsg($contents, $reciever_id)
    {
        if (!$this->checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$Success;
            $Content = HintConst::$NULLARRAY;
        } else {
            $messages = new Messages();
            $messages->contents = $contents;
            $messages->school_id = Yii::$app->session['custominfo']->custom->school_id;
            $messages->class_id = Yii::$app->session['custominfo']->custom->class_id;
            $messages->ispassed = HintConst::$YesOrNo_YES;
            $messages->isdeleted = HintConst::$YesOrNo_NO;
            $messages->isview = HintConst::$YesOrNo_YES;
            $messages->istimer = HintConst::$YesOrNo_NO;
            $messages->createtime = CommonFun::getCurrentDateTime();
            $messages->updatetime = CommonFun::getCurrentDateTime();
            $messages->starttime = CommonFun::getCurrentDateTime();
            $messages->endtime = CommonFun::getCurrentDateTime();
            $messages->save(false);
            $newid = $messages->attributes['id'];
            $msgSR = new Msgsendrecieve();
            $msgSR->addSenderAndReciever($newid, $reciever_id);
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $Content = [HintConst::$Field_id => $newid];
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    public function getNum($school_id, $startdate, $enddate)
    {
        $mc_name = $this->getMcName() . 'msggetNum' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $d = $this->find()->asArray()
                ->select('count(id) as num')
                ->where("createtime between '$startdate' and '$enddate'");
            if ($school_id) {
                $d = $d->andWhere("school_id=$school_id");
            }
            $d = $d->one();
            $this->mc->add($mc_name, $d);
        }
        return $d;
    }
}
