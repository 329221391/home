<?php

namespace app\modules\Admin\Catalogue\models;
use app\modules\Admin\CatDefalut\models\CatDefalut;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\BaseConst;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "catalogue".
 *
 * @property integer $id
 * @property integer $school_id
 * @property integer $cat_default_id
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
class Catalogue extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalogue';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id', 'cat_default_id', 'parent_id', 'priority', 'last_admin_id', 'ispassed', 'isdeleted'], 'integer'],
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
            'cat_default_id' => 'Cat Default ID',
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
            'isdeleted' => 'Isdelete',
        ];
    }
    /*
         * //园长添加教师的信息,在返回的group中也有,
         */
    public function AddcatalogueAH($path, $name_zh)
    {
        if (!$this->checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$Success;
            $Content = HintConst::$NULLARRAY;
        } else {
            $catalogue = new Catalogue();
            $catalogue->name_zh = $name_zh;
            $catalogue->parent_id = $path;
            $catalogue->path = $path . '-';
            $catalogue->ispassed = HintConst::$YesOrNo_YES;
            $catalogue->school_id = Yii::$app->session['custominfo']->custom->school_id;
            $catalogue->createtime = CommonFun::getCurrentDateTime();
            $catalogue->updatetime = CommonFun::getCurrentDateTime();
            $catalogue->save();
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $id = $catalogue->attributes['id'];
            $where = HintConst::$Field_id . "=$id";
            $new_record = $this->getRecordOne($where)["Content"];
            $Content = $new_record;
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    public function getCatalogueList($path, $school_id = 0)//从cat_default中获取
    {
        if ($school_id == 0) {
            $school_id = Yii::$app->session['custominfo']->custom->school_id;
        }
        $mc_name = $this->getMcName() . 'getCatalogueList' . $path . $school_id;
        if ($val = $this->mc->get($mc_name)) {
            $list = $val;
        } else {
            $query =
                "select id,name_zh from " . BaseConst::$catalogue_T . " where school_id=$school_id  AND path REGEXP '^$path-'";
            $list = Catalogue::findBySql($query)->asArray()->all();
            $this->mc->add($mc_name, $list);
        }
        return $list;
    }
    public function getCatalogueListAll($path, $school_id = 0)//从cat_default中获取
    {
        if ($school_id == 0) {
            $school_id = $this->getCustomSchool_id();
        }
        $mc_name = 'getCatalogueListAll' . json_encode(func_get_args()) . $this->getMcName();
        if ($val = $this->mc->get($mc_name)) {
            $list = $val;
        } else {
            $query =
                "select * from " . BaseConst::$catalogue_T . " where school_id=$school_id  AND path REGEXP '^$path-'";
            $list = self::findBySql($query)->all();
            $this->mc->add($mc_name, $list);
        }
        return $this->getArray2Catalogue($list);
    }
    //Catalogue去重//封装成array//后台使用--仅返回id和name_zh
    public function getCatalogueListByPath($path)
    {
        return $this->getCatalogueList($path);
    }
    /*
   *初始化catalogue:现在catalogue中查找,有就直接读取,没有从cat_default中将分类添加过来(注意修改school_id)
   *需要的分类:83/181/185/189/193/198/202/227
     * 注册园长时,有时候会只初始化了83,其它的没有注册成功
   */
    public function initCatlogue($school_id)
    {
        $this->addToCatlogue($school_id, 83);
        $this->addToCatlogue($school_id, 181);
        $this->addToCatlogue($school_id, 185);
        $this->addToCatlogue($school_id, 189);
        $this->addToCatlogue($school_id, 193);
        $this->addToCatlogue($school_id, 198);
        $this->addToCatlogue($school_id, 202);
        $this->addToCatlogue($school_id, 227);
    }
    public function addToCatlogue($school_id, $path)
    {
        $CatalogueList = $this->getCatalogueListAll($path, $school_id);
        if (count($CatalogueList) == 0) {
            $CatDefaultList = (new CatDefalut())->getCatDefaultListAll($path);
            if ($CatDefaultList != HintConst::$NULL) {
                foreach ($CatDefaultList as $value) {
                    $catalogue = new Catalogue();
                    foreach ($value as $k => $v) {
                        if ($k == 'id') {
                            $catalogue->cat_default_id = $v;
                        } else {
                            $catalogue->$k = $v;
                        }
                        $catalogue->school_id = $school_id;
                        $catalogue->save(false);
                    }
                }
            }
            return $this->getCatalogueListAll(HintConst::$Meal_PATH, $school_id);
        } else {
            return $CatalogueList;
        }
    }
    //处理Meal:现在catalogue中查找,有就直接读取,没有从cat_default中将meal分类添加过来(注意修改school_id)
    public function getMealList()//droplist使用
    {
        $CatalogueList = $this->getCatalogueListAll(HintConst::$Meal_PATH);
        if (count($CatalogueList) == 0) {
            $CatDefaultList = (new CatDefalut())->getCatDefaultListAll(HintConst::$Meal_PATH);
            if ($CatDefaultList != HintConst::$NULL) {
                foreach ($CatDefaultList as $value) {
                    $catalogue = new Catalogue();
                    foreach ($value as $k => $v) {
                        if ($k == 'id') {
                            $catalogue->cat_default_id = $v;
                        } else {
                            $catalogue->$k = $v;
                        }
                        $catalogue->school_id = $this->getCustomSchool_id();
                        $catalogue->save(false);
                    }
                }
            }
            return $this->getCatalogueListAll(HintConst::$Meal_PATH);
        } else {
            return $CatalogueList;
        }
    }
}
