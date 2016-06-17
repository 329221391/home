<?php

namespace app\modules\Admin\Articles\models;
use app\modules\AppBase\base\appbase\base\BaseMain;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "classes_daily".
 * @property integer $id
 * @property integer $class_id
 * @property integer $daily_type_id
 * @property string $daily_contents
 * @property string $date
 * @property string $createtime
 * @property integer $article_id
 */
class ClassesDaily extends BaseMain
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classes_daily';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_id', 'daily_type_id', 'article_id'], 'integer'],
            [['date', 'createtime'], 'safe'],
            [['daily_contents'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_id' => 'Class ID',
            'daily_type_id' => 'Daily Type ID',
            'daily_contents' => 'Daily Contents',
            'date' => 'Date',
            'createtime' => 'Createtime',
            'article_id' => 'Article ID',
        ];
    }
    public function getDayLable($custom_id, $date)
    {
        $class_summary = ['eat' => '', 'sleep' => '', 'course' => '', 'outdoor' => '', 'lessons' => '', 'homework' => ''];
        $query = new Query();
        $school = $query->select('class_id')->from('customs')->where(['id' => $custom_id])->one();
        if (isset($school["class_id"]) && $school["class_id"] > 0) {
            $class_id = isset($school["class_id"]) ? $school["class_id"] : 0;
            $query = new Query();
            $class_daily = $query->select('*')
                ->from('classes_daily')
                ->where(['class_id' => $class_id, 'date' => $date])
                ->all();
            if (count($class_daily) > 0 && is_array($class_daily)) {
                foreach ($class_daily as $key => $value) {
                    switch ($value['daily_type_id']) {
                        case HintConst::$LABLE_LIFE_EAT_PATH:
                            $class_summary['eat'] = $value['daily_contents'];
                            break;
                        case HintConst::$LABLE_LIFE_SLEEP_PATH:
                            $class_summary['sleep'] = $value['daily_contents'];
                            break;
                        case HintConst::$LABLE_LIFE_COURSE_PATH:
                            $class_summary['course'] = $value['daily_contents'];
                            break;
                        case HintConst::$LABLE_LIFE_OUTDOOR_PATH:
                            $class_summary['outdoor'] = $value['daily_contents'];
                            break;
                        case HintConst::$LABLE_LESSONS_PATH:
                            $class_summary['lessons'] = $value['daily_contents'];
                            break;
                        case HintConst::$DAILY_HOMEWORK_PATH:
                            $class_summary['homework'] = $value['daily_contents'];
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        return $class_summary;
    }
    public function getClassLifeLable($class_id, $lable, $date)
    {
        $mc_name = $this->getMcName() . 'getClassLifeLable' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $mo = self::find()->asArray()
                ->select('daily_contents')
                ->where(['class_id' => $class_id, 'daily_type_id' => $lable, 'date' => $date])
                ->one();
            if (is_null($mo)) {
                $mo = [];
            }
            $this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
}
