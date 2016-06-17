<?php

namespace app\modules\Admin\CatDefalut\models;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\appbase\XmlAndJson;
use app\modules\AppBase\base\BaseConst;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "cat_default".
 *
 * @property integer $id
 * @property integer $school_id
 * @property integer $parent_id
 * @property string $path
 * @property string $name
 * @property string $name_zh
 * @property integer $priority
 * @property string $describe
 * @property string $createtime
 * @property string $updatetime
 * @property integer $last_admin_id
 * @property integer $ispassed
 * @property integer $isdelete
 */
class CatDefalut extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_default';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id', 'parent_id', 'priority', 'last_admin_id', 'ispassed', 'isdelete'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['path', 'describe'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 45],
            [['name_zh'], 'string', 'max' => 225]
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
            'parent_id' => 'Parent ID',
            'path' => 'Path',
            'name' => 'Name',
            'name_zh' => 'Name Zh',
            'priority' => 'Priority',
            'describe' => 'Describe',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'last_admin_id' => 'Last Admin ID',
            'ispassed' => 'Ispassed',
            'isdelete' => 'Isdelete',
        ];
    }
    public function GetCatDef()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $conf_file = "config/cat-default.xml";
//        $conf_file = "config/web-conf.xml";
        $Content = XmlAndJson::xml_to_json($conf_file);
//        var_dump($Content);
//        exit;
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    public function getCatDefaultList($path)//从cat_default中获取
    {
        $isdeleted = HintConst::$YesOrNo_NO;
        $mc_name = $path.$this->getMcName() . 'getCatDefaultList';
        if ($val = $this->mc->get($mc_name)) {
            $list = $val;
        } else {
            $query =
                "select id,name_zh from " . BaseConst::$cat_default_T . " where isdeleted=$isdeleted AND path REGEXP '^$path-'";
            $list = self::findBySql($query)->all();
            $this->mc->add($mc_name, $list);
        }
        return $list;
    }
    public function getCatDefaultListAll($path)//从cat_default中获取all
    {
        $isdeleted = HintConst::$YesOrNo_NO;
        $mc_name = $path . $this->getMcName() . 'getCatDefaultListAll';
        if ($val = $this->mc->get($mc_name)) {
            $list = $val;
        } else {
            $query =
                "select * from " . BaseConst::$cat_default_T . " where isdeleted=$isdeleted  AND path REGEXP '^$path-'";
            $list = CatDefalut::findBySql($query)->all();
            $this->mc->add($mc_name, $list);
        }
        return $this->getArray2No_Password($list);
    }
    //begin 精彩瞬间标签/课程标签
    //CatDefault去重//封装成array//后台使用--仅返回id和name_zh
    public function getCatDefaultListByPath($path)
    {
        return $this->getArray2Only_IdNamezh($this->getCatDefaultList($path));
    }
    //分类只有默认的,不能自定义
    public function getRole()//droplist使用
    {
        return $this->getCatDefaultList(HintConst::$ROLE_PATH);
    }
    public function getYesOrNoList()//droplist使用
    {
        return $this->getCatDefaultList(HintConst::$YesOrNo_PATH);
    }
    public function getHighLight()//droplist使用
    {
        return $this->getCatDefaultList(HintConst::$HIGHLIGHT_PATH_NEW);
    }
}
