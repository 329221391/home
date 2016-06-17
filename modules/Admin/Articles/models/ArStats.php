<?php

namespace app\modules\Admin\Articles\models;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "ar_stats".
 * @property integer $id
 * @property integer $ar_id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $isshare
 * @property string $createtime
 * @property string $length
 */
class ArStats extends BaseAR
{
    private $selstr = 'user_id,user_name,isshare,createtime,length';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ar_stats';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_id', 'user_id', 'isshare'], 'integer'],
            [['createtime'], 'safe'],
            [['user_name', 'length'], 'string', 'max' => 11]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ar_id' => 'Ar ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'isshare' => 'Isshare',
            'createtime' => 'Createtime',
            'length' => 'Length',
        ];
    }
    public function addStats($ar_id, $isshare = 212, $length = 0)
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $d['ar_id'] = isset($_REQUEST['ar_id']) ? trim($_REQUEST['ar_id']) : $ar_id;
        $d['user_id'] = Yii::$app->session['custominfo']->custom->id;
        $d['user_name'] = Yii::$app->session['custominfo']->custom->name_zh;
        $d['isshare'] = isset($_REQUEST['isshare']) ? trim($_REQUEST['isshare']) : $isshare;
        $d['length'] = isset($_REQUEST['length']) ? trim($_REQUEST['length']) : $length;
        if (empty($d['ar_id']) || !is_numeric($d['ar_id'])) {
            $ErrCode = HintConst::$No_ar_id;
        } else {
            $Content = $this->addNew($d);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function addNew($d)
    {
        $arStats = new ArStats();
        $mo = $arStats->findIdBy($d['ar_id'], $d['user_id']);
        if ($mo !== null) {
            if ($d['isshare'] == HintConst::$YesOrNo_YES && $mo->isshare != HintConst::$YesOrNo_YES) {
                $mo->isshare = HintConst::$YesOrNo_YES;
                $mo->save(false);
            }
            $id = $mo->id;
        } else {
            foreach ($d as $k => $v) {
                $arStats->$k = $v;
            }
            $arStats->createtime = CommonFun::getCurrentDateTime();
            $arStats->save(false);
            $ar = new Articles();
            $ar->increaseF($d['ar_id'], 'view_times');
            $id = $arStats->attributes['id'];
        }
        return $id;
    }
    public function findIdBy($ar_id, $user_id)
    {
        return ArStats::find()->where(['ar_id' => $ar_id, 'user_id' => $user_id])->one();
    }
    public function Getlist()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $mc_name = $this->getMcName() . 'Getlist' . $id . $page . $size;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            if (empty($id) || !is_numeric($id)) {
                $ErrCode = HintConst::$NoId;
            } else {
                $Content = $this->Get_list($id, $page, $size);
                $this->mc->add($mc_name, $Content);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function Get_list($id, $page, $size)
    {
        $start_line = $size * ($page - 1);
        $re = ArStats::find()
            ->asArray()
            ->select($this->selstr)
            ->where(['ar_id' => $id])
            ->orderBy('id desc')
            ->offset($start_line)
            ->limit($size)
            ->all();
        return $re;
    }
}
