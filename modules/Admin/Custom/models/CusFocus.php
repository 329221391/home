<?php

namespace app\modules\Admin\Custom\models;
use app\modules\AppBase\base\appbase\base\BaseFocus;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "cus_focus".
 * @property integer $id
 * @property integer $custom_id
 * @property integer $focused_id
 * @property string $createtime
 */
class CusFocus extends BaseFocus
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cus_focus';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_id', 'focused_id'], 'integer'],
            [['createtime'], 'safe']
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
            'focused_id' => 'Focused ID',
            'createtime' => 'Createtime',
        ];
    }
    protected function addNew($d)
    {
        $d['createtime'] = CommonFun::getCurrentDateTime();
        return $this->addNewMultiTable('cus_focus_', $d, 'custom_id');
    }
    public function Addfocus()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $d['focused_id'] = isset($_REQUEST['focused_id']) ? $_REQUEST['focused_id'] : '';
        if (empty($d['focused_id']) || !is_numeric($d['focused_id'])) {
            $ErrCode = HintConst::$NoId;
        } else {
            $d['custom_id'] = $this->getCustomId();
            if ($this->checkIdBy('cus_focus_', $d['custom_id'], $d['focused_id'])) {
                $ErrCode = HintConst::$AlreadExist;
            } else {
                $Content = $this->addNew($d);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => $Content];
        return json_encode($result);
    }
}
