<?php

namespace app\modules\Admin\Articles\models;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\CommonFun;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "cookbook_info".
 * @property integer $id
 * @property string $breakfast
 * @property string $addone
 * @property string $lunch
 * @property string $addtwo
 * @property string $dinner
 * @property integer $school_id
 * @property string $date
 */
class CookbookInfo extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cookbook_info';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id', 'date'], 'required'],
            [['school_id'], 'integer'],
            [['date'], 'safe'],
            [['breakfast', 'addone', 'lunch', 'addtwo', 'dinner'], 'string', 'max' => 1000]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'breakfast' => 'Breakfast',
            'addone' => 'Addone',
            'lunch' => 'Lunch',
            'addtwo' => 'Addtwo',
            'dinner' => 'Dinner',
            'school_id' => 'School ID',
            'date' => 'Date',
        ];
    }
    protected function checkCookbook($date)
    {
        $mc_name = $this->getMcName() . 'checkCookbook' . $date . $this->getCustomSchool_id();
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            $query = new Query();
            $result = $query->select('ci.breakfast,ci.addone,ci.lunch,ci.addtwo,ci.dinner')
                ->from('cookbook_info as ci')
                ->where(['date' => $date, 'school_id' => $this->getCustomSchool_id()])
                ->one();
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
    //检查今天又没有添加食谱  没有就添加一个
    public function add_cookbook($date)
    {
        //获取今天的食谱数据
        $weekday = date('w', strtotime($date)) - 1;
        $query_indition = array();
        switch ($weekday) {
            case 0:
                $query_indition = [96, 97, 98, 99, 100];
                break;
            case 1:
                $query_indition = [116, 117, 118, 119, 120];
                break;
            case 2:
                $query_indition = [126, 127, 128, 129, 130];
                break;
            case 3:
                $query_indition = [136, 137, 138, 139, 140];
                break;
            case 4:
                $query_indition = [147, 148, 149, 150, 160];
                break;
            case 5:
                $query_indition = [166, 167, 168, 169, 170];
                break;
            case 6:
                $query_indition = [176, 177, 178, 179, 180];
                break;
            default:
                break;
        }
        $query = new Query();
        $cook_list = $query->select('name_zh')->from('catalogue')->where(['in', 'cat_default_id', $query_indition])->andwhere(['school_id' => $this->getCustomSchool_id()])->orderby(['id' => SORT_ASC])->column();
        $cook_model = new self();
        $cook_model->breakfast = isset($cook_list[0]) ? $cook_list[0] : '未设置';
        $cook_model->addone = isset($cook_list[1]) ? $cook_list[1] : '未设置';
        $cook_model->lunch = isset($cook_list[2]) ? $cook_list[2] : '未设置';
        $cook_model->addtwo = isset($cook_list[3]) ? $cook_list[3] : '未设置';
        $cook_model->dinner = isset($cook_list[4]) ? $cook_list[4] : '未设置';
        $cook_model->school_id = $this->getCustomSchool_id();
        $cook_model->date = $date;
        $cook = ["breakfast" => $cook_model->breakfast,
            "addone" => $cook_model->addone,
            "lunch" => $cook_model->lunch,
            "addtwo" => $cook_model->addtwo,
            "dinner" => $cook_model->dinner];
        $cook_model->save();
        return $cook;
    }
    public function getCookbook($date)
    {
        $mc_name = $this->getMcName() . 'getCookbook' . $this->getCustomSchool_id() . $date;
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            //not to set if beyond today
            if (!CommonFun::BeyondDate(CommonFun::getCurrentDate(), $date)) {
                if (!$result = $this->checkCookbook($date)) {
                    $result = $this->add_cookbook($date);
                }
            } else {
                $result = [];
            }
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
}
