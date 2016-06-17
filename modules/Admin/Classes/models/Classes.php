<?php

namespace app\modules\Admin\Classes\models;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
/**
 * This is the model class for table "{{%classes}}".
 * @property integer $id
 * @property integer $school_id
 * @property integer $teacher_id
 * @property integer $subteacher1_id
 * @property integer $subteacher2_id
 * @property integer $cat_default_id
 * @property integer $catalogue_des_id
 * @property string $name
 * @property string $namenick
 * @property string $code
 * @property string $logo
 * @property integer $ispassed
 * @property integer $isdeleted
 * @property integer $isgraduated
 * @property integer $isout
 * @property string $createtime
 * @property string $updatetime
 */
class Classes extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%classes}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_id', 'name'], 'required'],
            [['school_id', 'teacher_id', 'subteacher1_id', 'subteacher2_id', 'cat_default_id', 'catalogue_des_id', 'ispassed', 'isdeleted', 'isgraduated', 'isout', 'isstar'], 'integer'],
            [['logo', 'code', 'name', 'namenick', 'school_id', 'teacher_id', 'subteacher1_id', 'subteacher2_id', 'cat_default_id', 'catalogue_des_id', 'ispassed', 'isdeleted', 'isgraduated', 'isout', 'isstar', 'createtime', 'updatetime'], 'safe'],
            [['name', 'namenick'], 'string', 'max' => 45],
            [['code'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '班级名称',
            'code' => '班级码',
            'school_id' => '学校码',
            'teacher_id' => '班主任ID',
            'subteacher1_id' => '辅班老师',
            'subteacher2_id' => '生活老师',
            'cat_default_id' => 'Cat Default ID',
            'catalogue_des_id' => 'Catalogue Des ID',
            'namenick' => '班级昵称',
            'logo' => 'Logo',
            'ispassed' => HintConst::$AUDIT,
            'isdeleted' => HintConst::$IS . HintConst::$DELETE,
            'isout' => HintConst::$IS . HintConst::$OUT,
            'isstar' => HintConst::$IS . HintConst::$START,
            'isgraduated' => HintConst::$IS . HintConst::$GRADUATED,
            'createtime' => HintConst::$CREAT . HintConst::$TIME,
            'updatetime' => HintConst::$UPDATE . HintConst::$TIME,
        ];
    }
    public function  getCustoms()
    {
        return $this->hasMany(Customs::className(), ['class_id' => 'id']);
    }
    public function getClassesListBySchoolid($school_id)//封装成array
    {
        $mc_name = $this->getMcNameAct('getClassesListBySchoolid') . $school_id;
        if ($val = $this->mc->get($mc_name)) {
            return $val;
        } else {
            $query = Classes::find()->where([HintConst::$Field_school_id => $school_id,
                HintConst::$Field_isdeleted => HintConst::$YesOrNo_NO,
                HintConst::$Field_isgraduated => HintConst::$YesOrNo_NO])->all();
            $result = parent::getArray2No_Password($query);
            $this->mc->add($mc_name, $result);
            return $result;
        }
    }
    public function AddclassesAH($class_name, $teacher_id)
    {
        if (!$this->checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$Success;
            $Content = HintConst::$NULLARRAY;
        } else {
            $classes = new Classes();
            $classes->name = $class_name;
            $classes->teacher_id = $teacher_id;
            $classes->school_id = Yii::$app->session['custominfo']->custom->school_id;
            $classes->cat_default_id = 0;
            $classes->code = CommonFun::generate_code(HintConst::$CLASS, 8);
            $classes->ispassed = HintConst::$YesOrNo_YES;
            $classes->isdeleted = HintConst::$YesOrNo_NO;
            $classes->isout = HintConst::$YesOrNo_NO;
            $classes->isstar = HintConst::$YesOrNo_NO;
            $classes->isgraduated = HintConst::$YesOrNo_NO;
            $classes->createtime = CommonFun::getCurrentDateTime();
            $classes->updatetime = CommonFun::getCurrentDateTime();
            $classes->save(false);
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $id = $classes->attributes['id'];
            $where = HintConst::$Field_id . "=$id";
            $new_record = $this->getRecordOne($where)["Content"];
            $Content = $new_record;
            $custom = new Customs();
            $custom->updateClassId($teacher_id, $id);
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    public function GetclasseslistA()//封装json
    {
        if (!parent::checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Message = HintConst::$Success;
            $Content = HintConst::$NULLARRAY;
        } else {
            $school_id = Yii::$app->session['custominfo']->custom->school_id;
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $Content = $this->getClassesListBySchoolid($school_id);
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    /*
     * 下面暂时没用
     */
    public function addClass($school_code, $class_name)//暂时没用
    {
        $school = new Schools();
        $school_id = $school->getSchoolId($school_code);
        if ($school_id == 0) {
            $ErrCode = HintConst::$NoSchoolCode;
            $Message = HintConst::$NULL;
        } else {
            $this->school_id = $school_id;
            $this->name = $class_name;
            $this->createtime = CommonFun::getCurrentDateTime();
            $this->code = CommonFun::generate_code(HintConst::$CLASS, 8);
            $this->save(false);
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
        }
        $Content = HintConst::$NULLARRAY;
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    public function checkClassCode($class_code)
    {
        $yes = HintConst::$YesOrNo_YES;
        $no = HintConst::$YesOrNo_NO;
        $field = HintConst::$Field_code;
        $isdeleted = HintConst::$Field_isdeleted;
        $ispassed = HintConst::$Field_ispassed;
        $isgraduated = HintConst::$Field_isgraduated;
        $isout = HintConst::$Field_isout;
        $where = "$field=$class_code and $isdeleted=$no and $ispassed=$yes and $isgraduated=$no and $isout=$no";
        return $this->getRecordByOneNoSession($where);
    }
    public function getClassStatus($school_id = 0)
    {
        $mc_name = $this->getMcName() . 'getClassStatus' . $school_id;
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $query = new Query();
            $data = $query
                ->select('id,code,name,createtime')
                ->from('classes')
                ->where("school_id=$school_id")
                ->all();
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);
            $d['pages'] = $pages;
            $data = $query->offset($pages->offset)
                ->orderby(['id' => SORT_DESC])
                ->limit($pages->limit)
                ->all();
            $d['data'] = $data;
            $this->mc->add($mc_name, $d);
        }
        return $d;
    }
    public function  getClassInfo($class_id)
    {
        $mc_name = 'getClassInfo' . $class_id . $this->getMcName();
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $mo = [self::find()->asArray()
                ->where(['classes.id' => $class_id])
                ->one()];
            $this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
    public function  getClassList($school_id)
    {
        $mc_name = 'getClassList' . $school_id . $this->getMcName();
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $mo = Classes::find()->asArray()
                ->where(['school_id' => $school_id, 'isgraduated' => HintConst::$YesOrNo_NO])
                ->orderBy("name asc")
                ->all();
            $this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
}
