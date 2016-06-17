<?php

namespace app\modules\Admin\School\models;
use app\modules\Admin\Articles\models\ArticleAttachment;
use app\modules\Admin\Articles\models\Articles;
use app\modules\Admin\Catalogue\models\Catalogue;
use app\modules\Admin\CatDefalut\models\CatDefalut;
use app\modules\Admin\Classes\models\Classes;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Message\models\Messages;
use app\modules\Admin\Notes\models\Notes;
use app\modules\Admin\Vote\models\Vote;
use app\modules\AppBase\base\appbase\base\BaseExcept;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\BaseConst;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Exception;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use app\modules\Admin\Redfl\models\Redfl;
/**
 * This is the model class for table "{{%schools}}".
 * @property integer $id
 * @property integer $cat_default_id
 * @property integer $catalogue_des_id
 * @property integer $headmaster_id
 * @property integer $creater_id
 * @property string $creater_name
 * @property string $code
 * @property string $name
 * @property string $nickname
 * @property string $logo
 * @property string $tel
 * @property string $phone
 * @property string $createtime
 * @property string $starttime
 * @property string $endtime
 * @property integer $ispassed
 * @property integer $isdeleted
 * @property integer $isout
 */
class Schools extends BaseAR
{
    private $sel_customlist = 'cu.id,cu.school_id,cu.class_id,
            cu.cat_default_id,cu.name_zh,cu.logo,cu.description,cu.rftoken,
            cu.token_type,cu.token,cu.phone,cu.iscansend,cu.redflower';
    private $sel_sch = 's.id,s.name,s.createtime,s.ispassed,p.name as province,ct.name as city,ds.name as district';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schools}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['name'], 'required'],
            [['zh_province_id', 'zh_citie_id', 'zh_district_id', 'phone', 'cat_default_id', 'catalogue_des_id', 'headmaster_id', 'creater_id', 'ispassed', 'isdeleted', 'isout'], 'integer'],
            [['name', 'nickname', 'tel', 'phone', 'zh_province_id', 'zh_citie_id', 'zh_district_id', 'cat_default_id', 'catalogue_des_id', 'headmaster_id', 'creater_id', 'creater_name', 'ispassed', 'isdeleted', 'isout', 'createtime', 'starttime', 'endtime', 'code', 'logo'], 'safe'],
            [['phone'], 'string', 'max' => 11],
            [['creater_name', 'name', 'nickname', 'tel'], 'string', 'max' => 45],
            [['code'], 'string', 'max' => 50],
            [['logo','address'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_default_id' => 'Cat Default ID',
            'catalogue_des_id' => 'Catalogue Des ID',
            'headmaster_id' => '园长ID',
            'custom_name_zh' => '园长姓名',
            'creater_id' => 'Creater ID',
            'creater_name' => 'Creater Name',
            'code' => '学校码',
            'name' => '学校名称',
            'nickname' => '学校别名',
            'logo' => '学校Logo',
            'tel' => '学校座机',
            'phone' => '学校手机',
            'zh_province_id' => HintConst::$PROVINCE,
            'zh_citie_id' => HintConst::$CITY,
            'zh_district_id' => HintConst::$DISTRICT,
            'createtime' => HintConst::$CREAT . HintConst::$TIME,
            'starttime' => HintConst::$START . HintConst::$TIME,
            'endtime' => HintConst::$END . HintConst::$TIME,
            'ispassed' => HintConst::$AUDIT,
            'isdeleted' => HintConst::$IS . HintConst::$DELETE,
            'isout' => HintConst::$IS . HintConst::$OUT,
        ];
    }
    public function  getCustoms()
    {
        return $this->hasOne(Customs::className(), ['id' => 'headmaster_id']);
    }
    public function beforeSave($insert)
    {
        if (is_null($this->ispassed)) {
            $this->ispassed = flase;
        }
        if (is_null($this->isdeleted)) {
            $this->isdeleted = false;
        }
        if (is_null($this->isout)) {
            $this->isout = false;
        }
        if (is_null($this->code)) {
            $this->code = CommonFun::generate_code(HintConst::$SCHOOL, 8);
        }
        if (is_null($this->createtime)) {
            $this->createtime = CommonFun::getCurrentDateTime();
        }
        if (is_null($this->starttime)) {
            $this->starttime = CommonFun::getCurrentDateTime();
        }
        if (is_null($this->endtime)) {
            $this->endtime = CommonFun::getCurrentDateTime();
        }
        return parent::beforeSave($insert); // TODO: Change thetogenerated stub
    }
    public function getSchoolId($school_code)
    {
        $mc_name = $this->getMcName() . 'getSchoolId' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            $query =
                "select id from " . BaseConst::$school_T . " where code=$school_code";
            $list = Schools::findBySql($query)->one();
            if (is_null($list)) {
                $result = 0;
            } else {
                $result = $list->primaryKey;
            }
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
    public function getSchoolInfoBySchoolid($school_id)//封装成array
    {
        $mc_name = 'getSchoolInfoBySchoolid' . json_encode(func_get_args()) . $this->getMcName();
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            $query = Schools::find()
                ->asArray()
                ->where(['id' => $school_id])->one();
            if (is_null($query)) {
                $result = 0;
            } else {
                $result = $query;
            }
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
    public static function  getSchoolList()
    {
        $modle = Schools::find()->where([HintConst::$Field_isdeleted => HintConst::$YesOrNo_NO])->all();
        return $modle;
    }
    //园长端获取group消息
    public function GetschoolgroupinfoAH()//封装json
    {
        if (!parent::checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Content = HintConst::$NULL;
        } else {
            $ErrCode = HintConst::$Zero;
            $Content = $this->getSchoolGroupInfo();
        }
        return array("ErrCode" => $ErrCode, "Message" => HintConst::$WEB_USER, "Content" => $Content);
    }
    public function getSchoolGroupInfo()
    {
        $school_id = $this->getCustomSchool_id();
        $mc_name = $this->getMcName() . $school_id;
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            $customs = new Customs();
            $result['HeadmasterInfo'] = $customs->GetcustominfoAH()['Content'];
            $result['SchoolInfo'] = $this->getSchoolInfoBySchoolid($school_id);
            $result['ClassesList'] = (new Classes())->getClassList($school_id);
            $result['HeadList'] = $customs->getHeadList(HintConst::$ROLE_HEADMASTER, $school_id);
            $result['TeacherList'] = $customs->getCustomList(HintConst::$ROLE_TEACHER, $school_id);
            $result['ParentList'] = $customs->getCustomList(HintConst::$ROLE_PARENT, $school_id);
            $result['HighLightList'] = (new CatDefalut())->getCatDefaultListByPath(HintConst::$HIGHLIGHT_PATH_NEW);
            $catlogue = new Catalogue();
            $result['EatList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_EAT_PATH);
            $result['SleepList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_SLEEP_PATH);
            $result['CourseList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_COURSE_PATH);
            $result['OutdoorList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_OUTDOOR_PATH);
            $result['LessonsList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LESSONS_PATH);
            $result['MealList'] = $catlogue->getMealList();
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
    //老师端获取group消息
    public function getTeacherGroupInfoA()//封装json
    {
        if (!parent::checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Content = HintConst::$NULL;
        } else {
            $ErrCode = HintConst::$Zero;
            $Content = $this->getTeacherGroupInfo();
        }
        return array("ErrCode" => $ErrCode, "Message" => HintConst::$WEB_USER, "Content" => $Content);
    }
    public function getTeacherGroupInfo()
    {
        $school_id = $this->getCustomSchool_id();
        $class_id = $this->getCustomClass_id();
        $mc_name = $this->getMcName() . $school_id . $class_id;
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            $customs = new Customs();
            $result['TeacherInfo'] = $customs->GetcustominfoAH()['Content'];
            $result['HeadmastInfo'] = $customs->getHeadList(HintConst::$ROLE_HEADMASTER, $school_id);
            $result['SchoolInfo'] = $this->getSchoolInfoBySchoolid($school_id);
            $result['ClassInfo'] = (new Classes())->getClassInfo($class_id);
            $result['HeadList'] = $customs->getHeadList(HintConst::$ROLE_HEADMASTER, $school_id);
            $result['TeacherList'] = $customs->getCustomList(HintConst::$ROLE_TEACHER, $school_id, $class_id);
            $result['ParentList'] = $customs->getCustomList(HintConst::$ROLE_PARENT, $school_id, $class_id);
            $result['HighLightList'] = (new CatDefalut())->getCatDefaultListByPath(HintConst::$HIGHLIGHT_PATH_NEW);
            $catlogue = new Catalogue();
            $result['EatList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_EAT_PATH);
            $result['SleepList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_SLEEP_PATH);
            $result['CourseList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_COURSE_PATH);
            $result['OutdoorList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_OUTDOOR_PATH);
            $result['LessonsList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LESSONS_PATH);
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
    //家长端获取group消息
    public function getParentGroupInfoA()//封装json
    {
        if (!parent::checkSession()) {
            $ErrCode = HintConst::$NoSession;
            $Content = HintConst::$NULL;
        } else {
            $ErrCode = HintConst::$Zero;
            $Content = $this->getParentGroupInfo();
        }
        return array("ErrCode" => $ErrCode, "Message" => HintConst::$WEB_USER, "Content" => $Content);
    }
    public function getParentGroupInfo()
    {
        $school_id = $this->getCustomSchool_id();
        $class_id = $this->getCustomClass_id();
        $mc_name = $this->getMcName() . 'getParentGroupInfo' . $school_id . $class_id;
        $result = '';
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            try {
                $customs = new Customs();
                $result['ParentInfo'] = $customs->GetcustominfoAH()['Content'];
                $result['SchoolInfo'] = $this->getSchoolInfoBySchoolid($school_id);
                $result['ClassInfo'] = (new Classes())->getClassInfo($class_id);
                $result['HeadmastInfo'] = $customs->getHeadList(HintConst::$ROLE_HEADMASTER, $school_id);
                $result['TeacherInfo'] = $customs->getCustomList(HintConst::$ROLE_TEACHER, $school_id, $class_id);
                $result['HeadList'] = $customs->getHeadList(HintConst::$ROLE_HEADMASTER, $school_id);
                $result['TeacherList'] = $customs->getCustomList(HintConst::$ROLE_TEACHER, $school_id, $class_id);
                $result['HighLightList'] = (new CatDefalut())->getCatDefaultListByPath(HintConst::$HIGHLIGHT_PATH_NEW);
                $catlogue = new Catalogue();
                $result['EatList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_EAT_PATH);
                $result['SleepList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_SLEEP_PATH);
                $result['CourseList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_COURSE_PATH);
                $result['OutdoorList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LIFE_OUTDOOR_PATH);
                $result['LessonsList'] = $catlogue->getCatalogueListByPath(HintConst::$LABLE_LESSONS_PATH);
                $result['MealList'] = $catlogue->getMealList();
                Yii::$app->session['phone'] = $result['TeacherInfo'][0][HintConst::$Field_phone];
            } catch (Exception $e) {
                (new BaseExcept())->execpt_noteacherinfo($e->getMessage());
            }
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
    public function getSchByDT($startdate, $enddate)
    {
        $mc_name = $this->getMcName() . 'getSch' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $d['date'] = $startdate;
            $query = new Query();
            $data = $query
                ->select($this->sel_sch)
                ->from('schools as s')
                ->leftJoin('zh_provinces as p', 'p.id=s.zh_province_id')
                ->leftJoin('zh_cities as ct', 'ct.id=s.zh_citie_id')
                ->leftJoin('zh_districts as ds', 'ds.id=s.zh_district_id')
                ->where("s.createtime between '$startdate' and '$enddate'")
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
    public function getSchByName($name)
    {
        $mc_name = $this->getMcName() . 'getSchByName' . $name;
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $query = new Query();
            $data = $query
                ->select($this->sel_sch)
                ->from('schools as s')
                ->leftJoin('zh_provinces as p', 'p.id=s.zh_province_id')
                ->leftJoin('zh_cities as ct', 'ct.id=s.zh_citie_id')
                ->leftJoin('zh_districts as ds', 'ds.id=s.zh_district_id')
                ->where("s.name like '%$name%'")
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
    public function getSchByProvince($province_id)
    {
        $mc_name = $this->getMcName() . 'getSchByProvince' . $province_id;
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $query = new Query();
            $data = $query
                ->select($this->sel_sch)
                ->from('schools as s')
                ->leftJoin('zh_provinces as p', 'p.id=s.zh_province_id')
                ->leftJoin('zh_cities as ct', 'ct.id=s.zh_citie_id')
                ->leftJoin('zh_districts as ds', 'ds.id=s.zh_district_id')
                ->where("s.zh_province_id=$province_id")
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
    public function getSchByType($startdate, $enddate, $type)
    {
        $mc_name = $this->getMcName() . 'getSchByType' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $d['date'] = $startdate;
            $query = new Query();
            $data = $query
                ->distinct()
                ->select($this->sel_sch)
                ->from('schools as s')
                ->leftJoin('zh_provinces as p', 'p.id=s.zh_province_id')
                ->leftJoin('zh_cities as ct', 'ct.id=s.zh_citie_id')
                ->leftJoin('zh_districts as ds', 'ds.id=s.zh_district_id');
            switch ($type) {
                case CatDef::$mod['custom']:
                    $data = $data->leftJoin('customs as cc', 'cc.school_id=s.id')
                        ->where("cc.updatetime between '$startdate' and '$enddate'");
                    break;
                case CatDef::$mod['pic']://if send 222 but no img,here will display,but show zero for num in schinfo
                case CatDef::$mod['article']:
                case CatDef::$mod['moneva']:
                case CatDef::$mod['termeva']:
                    $data = $data->leftJoin('articles as a', 'a.school_id=s.id')
                        ->where("a.createtime between '$startdate' and '$enddate'")
                        ->andWhere(['a.article_type_id' => $type]);
                    break;
                case CatDef::$mod['msg']:
                    $data = $data->leftJoin('messages as m', 'm.school_id=s.id')
                        ->where("m.createtime between '$startdate' and '$enddate'");
                    break;
                case CatDef::$mod['note']:
                    $data = $data->leftJoin('notes as n', 'n.school_id=s.id')
                        ->where("n.createtime between '$startdate' and '$enddate'");
                    break;
                case CatDef::$mod['vote']:
                    $data = $data->leftJoin('vote as v', 'v.school_id=s.id')
                        ->where("v.createtime between '$startdate' and '$enddate'");
                    break;
                case CatDef::$mod['rf']:
                    $data = $data->leftJoin('redfl as rf', 'rf.school_id=s.id')
                        ->where("rf.createtime between '$startdate' and '$enddate'");
                    break;
            }
            $data = $data->all();
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
    public function getStatusBySchid($school_id, $startdate, $enddate)
    {
        $mc_name = $this->getMcName() . 'getStatusBySchid' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $custom = new Customs();
            $d['custom'] = $custom->getNum($school_id, $startdate, $enddate);
            $article = new Articles();
            $d['article'] = $article->getNum($school_id, HintConst::$ARTICLE_PATH, $startdate, $enddate);
            $d['moneva'] = $article->getNum($school_id, HintConst::$YUEPINGJIA_PATH, $startdate, $enddate);
            $d['termeva'] = $article->getNum($school_id, HintConst::$NIANPINGJIA_PATH, $startdate, $enddate);
            $ar_att = new ArticleAttachment();
            $d['pic'] = $ar_att->getNum($school_id, HintConst::$HIGHLIGHT_PATH_NEW, $startdate, $enddate);
            $msg = new Messages();
            $d['msg'] = $msg->getNum($school_id, $startdate, $enddate);
            $note = new Notes();
            $d['note'] = $note->getNum($school_id, $startdate, $enddate);
            $vote = new Vote();
            $d['vote'] = $vote->getNum($school_id, $startdate, $enddate);
            $redfl = new Redfl();
            $d['redfl'] = $redfl->getNum($school_id, $startdate, $enddate);

            $this->mc->add($mc_name, $d);
        }
        return $d;
    }
}
