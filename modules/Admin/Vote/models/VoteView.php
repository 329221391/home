<?php

namespace app\modules\Admin\Vote\models;
use app\modules\AppBase\base\appbase\base\BaseView;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "vote_view".
 * @property integer $id
 * @property integer $m_id
 * @property integer $user_id
 * @property string $user_name
 * @property string $createtime
 */
class VoteView extends BaseView
{
    private $sel = 'id,user_id,user_name,createtime';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_view';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'user_id'], 'integer'],
            [['createtime'], 'safe'],
            [['user_name'], 'string', 'max' => 20]
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
            'createtime' => 'Createtime',
        ];
    }
    public function AddView($d)
    {
        $d['user_id'] = $this->getCustomId();
        $d['user_name'] = $this->getCustomNamezh();
        $Content = $this->addNew($d);
        return $Content;
    }
    public function getViewUser()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $d['m_id'] = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $d['page'] = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $d['user_id'] = isset($_REQUEST['user_id']) && is_numeric($_REQUEST['user_id']) ? $_REQUEST['user_id'] : $this->getCustomId();
        if ($d['m_id'] == 0) {
            $ErrCode = HintConst::$NoId;
        } else {
            $Content = $this->get_ViewUser($d);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$WEB_JYQ, 'Content' => $Content];
        return json_encode($result);
    }
    public function get_ViewUser($d)
    {
        $mc_name = $this->getMcName() . $this->tableName() . 'getViewUser' . json_encode($d);
        if ($val = $this->mc->get($mc_name)) {
            $r = $val;
        } else {
            $where = 'm_id=' . $d['m_id'];
            $r = $this->getMultTable('vote_view_', $d['m_id'], $this->sel, $where, 1, $d['page']);
            $this->mc->add($mc_name, $r);
        }
        return $r;
    }
    public function addNew($d)
    {
        $d['createtime'] = CommonFun::getCurrentDateTime();
        return $this->addNewMultiTable('vote_view_', $d);
    }
}
