<?php

namespace app\modules\Admin\Apkversion\models;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "{{%apkversion}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $describe
 * @property string $primary_version
 * @property string $sub_version
 * @property string $url
 * @property integer $times
 * @property string $createtime
 * @property integer $isdeleted
 * @property integer $ispassed
 * @property integer $ismust_update
 */
class Apkversion extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%apkversion}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            [['cat_default_id','times', 'isdeleted', 'ispassed', 'ismust_update'], 'integer'],
            [['createtime'], 'safe'],
            [['name', 'primary_version', 'sub_version'], 'string', 'max' => 45],
            [['describe'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 100]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'cat_default_id' => '客户端类别ID',
            'name' => '名称',
            'describe' => '描述',
            'primary_version' => 'Primary Version',
            'sub_version' => 'Sub Version',
            'url' => '上传文件',
            'times' => '下载次数',
            'createtime' => '创建时间',
            'isdeleted' => '删除',
            'ispassed' => '通过',
            'ismust_update' => '必须更新',
        ];
    }
    public function getApkinfo($role)
    {
        $result = Apkversion::find()
            ->where([HintConst::$Field_cat_default_id =>$role,HintConst::$Field_isdeleted =>HintConst::$YesOrNo_NO,HintConst::$Field_ispassed =>HintConst::$YesOrNo_YES])
            ->orderBy("id desc")->one();
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = parent::getArray1No_Password($result);
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
}
