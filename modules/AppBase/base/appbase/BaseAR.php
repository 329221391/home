<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/11/25
 * Time: 10:32
 */
namespace app\modules\AppBase\base\appbase;
use app\modules\Admin\Logs\models\Logs;
use app\modules\AppBase\base\appbase\base\BaseExcept;
use app\modules\AppBase\base\appbase\base\BaseInterface;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Query;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;
class BaseAR extends ActiveRecord implements BaseInterface
{
    const TEN = 10;
    public $mc;
    private $mc_name;//id+url//有的用get有的用post
    private $mc_name_common;//url//有的用get有的用post
    private $mc_name_act;//action//get和post统一了
    private $name;
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    function __construct()
    {
        $this->mc = new BaseMem();
    }
    public function del($id)
    {
        $mo = $this->findId($id);
        if ($mo !== null) {
            return $mo->delete();
        }
        return false;
    }
    public function delMul($where)
    {
        //no continue
        return $this->deleteAll('age > :age AND gender = :gender', [':age' => 20, ':gender' => 'M']);
    }
    public function addNewMultiTable($table_name, $d, $id = 'm_id')
    {
        $tn = $table_name . $this->getTenMod($d[$id]);
        $connection = Yii::$app->db;
        $key = $val = "";
        $len = sizeof($d);
        foreach ($d as $k => $v) {
            if (--$len) {
                $key .= "`$k`,";
                $val .= "'$v',";
            } else {
                $key .= "`$k`";
                $val .= "'$v'";
            }
        }
        $sql = "INSERT INTO  $tn  ($key)  VALUES  ($val)";
        $command = $connection->createCommand($sql);
        $command->execute();//1表示成功
        return Yii::$app->db->lastInsertID;
    }

    /**
     * @param $table_name
     * @param $m_id
     * @param $select
     * @param string $where
     * @param int $more
     * @param string $page
     * @param string $order
     * @param int $limit
     * @return array|bool
     */
    public function getMultTable($table_name, $m_id, $select, $where = '', $more = 0, $page = '', $order = 'DESC', $limit = 10)
    {
        $tn = $table_name . $this->getTenMod($m_id);
        $connection = Yii::$app->db;
        $sql = "SELECT $select FROM  $tn";
        if (isset($where)) {
            $sql .= " WHERE $where";
        }
        if ($more == 1) {
            $sql .= " ORDER BY id $order";
            if (isset($page)) {
                $sql .= " LIMIT $limit OFFSET " . ($page - 1) * $limit;
            }
            $command = $connection->createCommand($sql);
            return $command->queryAll();
        } else {
            $command = $connection->createCommand($sql);
            return $command->queryOne();
        }
    }
    public function queryAll($sql)
    {
        $connection = Yii::$app->db;
        $command = $connection->createCommand($sql);
        return $command->queryAll();
    }
    public function queryOne($sql)
    {
        $connection = Yii::$app->db;
        $command = $connection->createCommand($sql);
        return $command->queryOne();
    }
    protected function getTenMod($num)
    {
        return $this->getMode($num, self::TEN);
    }
    protected function getMode($num, $mode)
    {
        return $num % $mode;
    }
    public function getMcName()
    {
        $this->mc_name = Yii::$app->request->getUrl();
        return $this->mc_name;
    }
    public function getMcNameAct($act)
    {
        $this->mc_name_act = Yii::$app->request->getUrl();
        return $this->mc_name_act;
    }
    public function getMcNameCommon()
    {
        $this->mc_name_common = Yii::$app->request->getUrl();
        return $this->mc_name_common;
    }
    public function closesys()
    {
        $this->mc->close(2);
    }
    public function checkSession()//检测session
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return true;
        } else {
            return false;
        }
    }
    public function checkAdminSession()//检测session
    {
        if (isset(Yii::$app->session['admin_user'])) {
            return true;
        } else {
            return false;
        }
    }
    //get user type by session
    public function  getUserType()
    {
        if (isset(Yii::$app->session['admin_user'])) {
            return CatDef::$user_cat['admin'];
        }
        if (isset(Yii::$app->session['custominfo'])) {
            return CatDef::$user_cat['jyq'];
        }
    }
    //get user type by custom_id
    public function  getUserTypeByCustId()
    {
        if (isset(Yii::$app->session['admin_user'])) {
            return HintConst::$User_Admin;
        }
        if (isset(Yii::$app->session['custominfo'])) {
            return HintConst::$User_Jyq;
        }
    }
    //检测custom中的phone是否存在
    public static function checkPhone($phone)
    {
        $result = self::find()->where(['phone' => $phone])->one();
        if (is_null($result)) {
            $flag = false;
        } else {
            $flag = true;
        }
        return $flag;
    }
    /*
     * 检查字段是否存在
     */
    public function checkField($model, $field)
    {
        foreach ($model->attributes() as $v) {
            if ($field == $v) {
                return true;
                break;
            }
        }
        return false;
    }
    public static function checkId($id)
    {
        if (self::findId($id) !== null) {
            return true;
        } else {
            return false;
        }
    }
    public function checkPassed($id)
    {
        $r = false;
        $mo = $this->findId($id);
        if ($mo !== null) {
            if ($mo->ispassed == HintConst::$YesOrNo_YES) {
                $r = true;
            }
        }
        return $r;
    }
    public function findId($id)
    {
        return $this->getFeild('id', $id);
    }
    /**
     * use mem,but now no using,because not to user CRUD
     * @param $class
     * @param $id
     * @return mixed
     */
    public function findIdInMem($id)
    {
        $mc_name = $this->getMcName() . $this->tableName() . 'findIdInMem' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $mo = $this->findOne(['id' => $id]);
            $this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
    public function increaseF($id, $field, $num = 1)
    {
        $mo = $this->findId($id);
        if ($mo !== null) {
            $mo->$field += $num;
            $mo->save(false);
        }
    }
    public function updateF($id, $field, $val)
    {
        $ErrCode = HintConst::$Zero;
        $mo = $this->findId($id);
        if ($mo !== null) {
            try {
                (new Logs())->addLogs(HintConst::$UPDATE, $id, $field, $mo->attributes[$field], $val);
                if ($field == HintConst::$Field_password) {
                    $mo->setAttributes([$field => $val]);//对相关属性$flag进行设定值$v
                } elseif ($field == HintConst::$Field_path) {
                    $mo->setAttributes([$field => $val . "-"]);//对相关属性$flag进行设定值$v
                } else {
                    $mo->setAttributes([$field => $val]);//对相关属性$flag进行设定值$v
                }
                $mo->save();
            } catch (Exception $e) {
                $ErrCode = HintConst::$Err_type;
            }
        } else {
            $ErrCode = HintConst::$NoRecord;
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function getF($id, $field)
    {
        $Content = HintConst::$NULLARRAY;
        $ErrCode = HintConst::$Zero;
        $mo = $this->findId($id);
        if ($mo !== null) {
            try {
                $Content = $mo->getAttribute($field);
            } catch (Exception $e) {
                $ErrCode = HintConst::$Err_type;
            }
        } else {
            $ErrCode = HintConst::$NoRecord;
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$NULL, 'Content' => $Content];
        return json_encode($result);
    }
    public function updateMultiF($id, $d)
    {
        $mo = $this->findId($id);
        if ($mo !== null) {
            foreach ($d as $k => $v) {
                $mo->$k = $v;
            }
            $mo->save(false);
        }
        return json_encode(['ErrCode' => HintConst::$Zero, 'Message' => HintConst::$NULL, 'Content' => HintConst::$NULLARRAY]);
    }
    public static function  getArray2Catalogue($query)
    {
        if (count($query) == 0) {
            return HintConst::$NULLARRAY;
        } else {
            foreach ($query as $v) {
                foreach ($v as $k => $v1) {
                    if ($k == 'id' || $k == 'name_zh' || $k == 'cat_default_id' || $k == 'parent_id' || $k == 'path') {
                        $data[$k] = $v1;
                    }
                }
                $result[] = $data;
            }
            return $result;
        }
    }
    public static function  getArray2Only_IdName($query)
    {
        if (count($query) == 0) {
            return HintConst::$NULLARRAY;
        } else {
            foreach ($query as $v) {
                foreach ($v as $k => $v1) {
                    if ($k == 'id' || $k == 'name') {
                        $data[$k] = $v1;
                    }
                }
                $result[] = $data;
            }
            return $result;
        }
    }
    public static function  getArray2Only_IdNamezh($query)
    {
        if (count($query) == 0) {
            return HintConst::$NULLARRAY;
        } else {
            foreach ($query as $v) {
                foreach ($v as $k => $v1) {
                    if ($k == 'id' || $k == 'name_zh') {
                        $data[$k] = $v1;
                    }
                }
                $result[] = $data;
            }
            return $result;
        }
    }
    public static function  getArray2No_Password($query)//二维:如果没有password字段返回的就是全部
    {
        if (count($query) == 0) {
            return HintConst::$NULLARRAY;
        } else {
            foreach ($query as $v) {
                foreach ($v as $k => $v1) {
                    if ($k != 'password') {
                        $data[$k] = $v1;
                    }
                }
                $result[] = $data;
            }
            return $result;
        }
    }
    public static function  getArray1No_Password($query)//一维:如果没有password字段返回的就是全部
    {
        if (count($query) == 0) {
            return HintConst::$NULLARRAY;
        } else {
            foreach ($query as $k => $v) {
                if ($k != 'password') {
                    $result[$k] = $v;
                }
            }
            return $result;
        }
    }
    /*
    * 根据$where获取记录:多条记录
    */
    public function getRecordList($where)
    {
        $query = $this->find()->where($where)->all();
        $result = $this->getArray2No_Password($query);
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = $result;
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    /*
     * 根据id获取记录:只有一条记录
     */
    public function getRecordOne($where)
    {
        $model = $this->find()->asarray()->where($where)->one();
        if (!count($model) == 0) {
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $Content = $this->getArray1No_Password($model);
        } else {
            $ErrCode = HintConst::$NoRecord;
            $Message = HintConst::$NoRecord_m;
            $Content = HintConst::$NULLARRAY;
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    /*
     * 根据id获取记录:只有一条记录
     */
    public function getRecordByOneNoSession($where)
    {
        $model = $this->find()->where($where)->one();
        if (!count($model) == 0) {
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $Content = $this->getArray1No_Password($model);
        } else {
            $ErrCode = HintConst::$NoRecord;
            $Message = HintConst::$NoRecord_m;
            $Content = HintConst::$NULLARRAY;
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    /*
     * 合并数组:给定两个二维数组
     * 以某个可以为条件,相同的将一个数据中的某个赋值给另一个数组
    */
    /**
     * @param $a1
     * @param $a2
     */
    public function combinA($a1, $a2, $k1, $k2)
    {
        foreach ($a1 as $item) {
            $temp_key = $item[$k1];
            $count = 0;
            foreach ($a2 as $item2) {
                if ($temp_key == $item2[$k1]) {
                    $a2[$count][$k2] = $item[$k2];
                    break;
                }
                $count++;
            }
        }
        return $a2;
    }
    public function haschar($need, $str)
    {
        $arr = explode($need, $str);
        if (count($arr) > 1) {
            return $arr;
        } else {
            return false;
        }
    }
    public function create_img($school_id, $class_id, $images_lable)
    {
        try {
            if (!$images_lable) {
//            $result = ['ErrCode' => HintConst::$No_image, 'Message' => '缺少参数', 'Content' => []];
                return '';
            }
            $thumb = UploadedFile::getInstanceByName($images_lable);
            if ($thumb) {
                $img_path = 'uploads/';
                $img_path .= date('Y-m-d') . '/';
                if ($school_id) {
                    $img_path .= $school_id . '/';
                }
                if ($class_id) {
                    $img_path .= $class_id . '/';
                }
                if (!is_dir($img_path)) {
                    if (BaseFileHelper::createDirectory($img_path)) {
                    } else {
                        $result = ['ErrCode' => '7474', 'Message' => '权限不足，无法上传图片', 'Content' => []];
                        die (json_encode($result));
                    }
                }
                $base_filename = rand(1000, 9999) . time();
                $pic_url = $img_path . $base_filename . '.jpg';
                $thumb->saveAs($pic_url);   //保存图片到指定路径
                //根据图片路径打上水印
                $query = new Query();
                $school = $query->select('name')->from('schools')->where(['id' => $this->getCustomSchool_id()])->one();//得到用户的学校名称
                if (false === ($image_size = getimagesize($pic_url))) {
                    (new BaseExcept())->execpt_notimage("error for image_size");
                }
                if ($school['name']) {
                    $font_long = strlen($school['name']) * 5 + 20;
                    $position_x = $image_size[0] - $font_long;
                    $position_y = $image_size[1] - 26;
                    Image::text($pic_url, $school['name'], 'ms_black.ttf', [$position_x + 1, $position_y + 1], ['size' => 12, 'color' => '000'])->save($pic_url, ['quality' => HintConst::$Pic_Quality]);
                    Image::text($pic_url, $school['name'], 'ms_black.ttf', [$position_x, $position_y], ['size' => 12])->save($pic_url, ['quality' => HintConst::$Pic_Quality]);
                }
                //根据图片路径  生成缩略图
                $thumb_url = $img_path . $base_filename . '.thumb.jpg';
                if ($image_size) {
                    //计算宽高比  得出图片高度
                    $thumb_height = floor(HintConst::$Pic_Width * ($image_size[1] / $image_size[0]));
                    Image::thumbnail($pic_url, HintConst::$Pic_Width, $thumb_height)
                        ->save($thumb_url, ['quality' => HintConst::$Pic_Quality]); //保存缩略图片到指定路径
                }
                $file_path = $img_path . $base_filename;
                return $file_path;
            } else {
                return '';
            }
        } catch (Exception $e) {
            (new BaseExcept())->execpt_nosuccess($e->getMessage());
        }
    }
    public function getSchoolOrClassArrByString(&$school, $d)
        //same for school or class :fit format  "18,19,20"
    {
        if ($d != 0) {
            $tmp2 = explode(',', $d);
            if ($tmp2) {
                $school = $tmp2;
            } else {
                $school[] = $d;
            }
        }
    }
    public function getClassArrayByString(&$class, $d)
        //for class :fit format  "18-181,18-182,18-186"
    {
        if ($d != 0) {
            $tmp2 = explode(',', $d);
            if ($tmp2) {
                foreach ($tmp2 as $k) {
                    $tmp = explode('-', $k);
                    $class[] = $tmp[1];
                }
            } else {
                $tmp = explode('-', $d);
                $class[] = $tmp[1];
            }
        }
    }
    public function getUserArrayByString(&$user, $d)
        //for user :fit format  "18-181-1,18-182-2,18-186-3"
    {
        if ($d != 0) {
            $tmp2 = explode(',', $d);
            if ($tmp2) {
                foreach ($tmp2 as $k) {
                    $tmp = explode('-', $k);
                    $user[] = $tmp[2];
                }
            } else {
                $tmp = explode('-', $d);
                $user[] = $tmp[2];
            }
        }
    }
    public function getCustomId()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->id;
        }
        return isset($_REQUEST['my_id']) ? $_REQUEST['my_id'] : 0;
    }
    public function getCustomNamezh()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->name_zh;
        }
        return 0;
    }
    public function getCustomRole()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->cat_default_id;
        }
        return isset($_REQUEST['cat_default_id']) ? $_REQUEST['cat_default_id'] : 0;
    }
    public function getCustomSchool_id()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->school_id;
        }
        return isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 0;
    }
    public function getCustomClass_id()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->class_id;
        }
        return 0;
    }
    public function getCustomCity()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->zh_citie_id;
        }
        return 0;
    }
    public function getCustomDistrict()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->zh_district_id;
        }
        return 0;
    }
    public function getIsCanSend()
    {
        if (isset(Yii::$app->session['custominfo'])) {
            return Yii::$app->session['custominfo']->custom->iscansend;
        }
        return 0;
    }
    public function getFeild($field, $v)
    {
        return $this->findOne([$field => $v]);
    }
    public function removeKey($source, $feild)
    {
        $aim = [];
        foreach ($source as $key) {
            $aim[] = $key[$feild];
        }
        return $aim;
    }

    public static function getPos($role)
    {
        switch ($role) {
            case HintConst::$ROLE_HEADMASTER:
                return 0;
                break;
            case HintConst::$ROLE_TEACHER:
                return 1;
                break;
            case HintConst::$ROLE_PARENT:
                return 2;
                break;
            default :
                return 0;
                break;
        }
    }
}