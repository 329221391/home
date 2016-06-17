<?php

namespace app\modules\Admin\Custom\models;
use app\modules\Admin\Classes\models\Classes;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "{{%customs_daily}}".
 *
 * @property integer $id
 * @property integer $custom_id
 * @property integer $daily_type_id
 * @property string $daily_contents
 * @property string $createtime
 */
class Customsdaily extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customs_daily}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_id', 'daily_type_id'], 'integer'],
            [['date', 'createtime'], 'safe'],
            [['daily_contents'], 'string', 'max' => 255]
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
            'daily_type_id' => 'Daily Type ID',
            'daily_contents' => 'Daily Contents',
            'date' => 'Date',
            'createtime' => 'Createtime',
        ];
    }
    /*
 * 添加的custom 的daily信息
 */
    public function OperateDaily($data)
    {
        //做了一半发现是精彩瞬间的发送模块
        if (!$this->checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
        } else {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            if (!count(Customs::getCustomByPhone($data['phone'])) == 0) {
                $ErrCode = HintConst::$PhoneAlreadExist;
            } elseif (count((new Schools())->getRecordOne(HintConst::$Field_id . "=" . $data[HintConst::$Field_school_id])["Content"]) == 0) {
                $ErrCode = HintConst::$NoSchoolId_Record;
            } elseif (count((new Classes())->getRecordOne(HintConst::$Field_school_id . "=" . $data[HintConst::$Field_school_id] . " and " . HintConst::$Field_id . "=" . $data[HintConst::$Field_class_id])["Content"]) == 0) {
                $ErrCode = HintConst::$NoClassesId_Record;
            } else {
                $custom = new Customs();
                foreach ($data as $k => $v) {
                    if ($k == HintConst::$Field_password) {
                        $custom->$k = CommonFun::encrypt($v);
                    } else {
                        $custom->$k = $v;
                    }
                }
                $custom->ispassed = HintConst::$YesOrNo_YES;
                $custom->isdeleted = HintConst::$YesOrNo_NO;
                $custom->isout = HintConst::$YesOrNo_NO;
                $custom->iscansend = HintConst::$YesOrNo_NO;
                $custom->isstar = HintConst::$YesOrNo_NO;
                $custom->createtime = CommonFun::getCurrentDateTime();
                $custom->updatetime = CommonFun::getCurrentDateTime();
                $custom->starttime = CommonFun::getCurrentDateTime();
                $custom->endtime = CommonFun::getCurrentDateTime();
                $custom->save(false);
                $ErrCode = HintConst::$Zero;
                $Message = HintConst::$Success;
                $id = $custom->attributes['id'];
                $where = HintConst::$Field_id . "=$id";
                $new_record = (new Customs())->getRecordOne($where)["Content"];
                $Content = $new_record;
            }
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
}
