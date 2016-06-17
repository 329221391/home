<?php

namespace app\modules\Admin\Admin\models;
use app\modules\AppBase\base\appbase\base\BaseEdit;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\appbase\XmlAndJson;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "admins".
 * @property integer $id
 * @property string $name
 * @property string $nickname
 * @property string $password
 * @property string $createtime
 * @property string $updatetime
 * @property integer $ispassed
 * @property integer $isdeleted
 */
class Admins extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{admins}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime'], 'safe'],
            [['ispassed', 'isdeleted'], 'integer'],
            [['name', 'nickname', 'password'], 'string', 'max' => 45]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'nickname' => 'Nickname',
            'password' => 'Password',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'ispassed' => 'Ispassed',
            'isdeleted' => 'Isdeleted',
        ];
    }
    public function GetConf()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $mc_name = $this->getMcNameCommon();
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $conf_file = "config/web-conf.xml";
            $Content = XmlAndJson::xml_to_json($conf_file);
            $this->mc->add($mc_name, $Content);
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    public function Myflush()
    {
//        $this->mc->flush();
        die("mem clear ok!");
    }

}
