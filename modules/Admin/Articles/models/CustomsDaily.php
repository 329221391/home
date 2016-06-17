<?php

namespace app\modules\Admin\Articles\models;
use app\modules\AppBase\base\appbase\base\BaseMain;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "customs_daily".
 *
 * @property integer $id
 * @property integer $custom_id
 * @property integer $daily_type_id
 * @property string $daily_contents
 * @property string $date
 * @property string $createtime
 * @property integer $class_id
 * @property integer $article_id
 */
class CustomsDaily extends BaseMain
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customs_daily';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_id', 'daily_type_id', 'class_id', 'article_id'], 'integer'],
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
            'custom_id' => 'Custom ID',
            'daily_type_id' => 'Daily Type ID',
            'daily_contents' => 'Daily Contents',
            'date' => 'Date',
            'createtime' => 'Createtime',
            'class_id' => 'Class ID',
            'article_id' => 'Article ID',
        ];
    }
    public function getDayLable($custom_id, $date)
    {
        $query = new Query();
        $p_list = $query->select('customs_daily.*')
            ->from('customs_daily')
            ->where(['customs_daily.custom_id' => $custom_id, 'customs_daily.date' => $date])
            ->orderby(['customs_daily.daily_type_id' => SORT_ASC])
            ->limit(6)
            ->all();
        $summary = ['eat' => '', 'sleep' => '', 'course' => '', 'outdoor' => '', 'lessons' => '', 'homework' => ''];
        if (count($p_list) > 0) {
            foreach ($p_list as $key => $value) {
                switch ($value['daily_type_id']) {
                    case HintConst::$LABLE_LIFE_EAT_PATH:
                        $summary['eat'] = $value['daily_contents'];
                        break;
                    case HintConst::$LABLE_LIFE_SLEEP_PATH:
                        $summary['sleep'] = $value['daily_contents'];
                        break;
                    case HintConst::$LABLE_LIFE_COURSE_PATH:
                        $summary['course'] = $value['daily_contents'];
                        break;
                    case HintConst::$LABLE_LIFE_OUTDOOR_PATH:
                        $summary['outdoor'] = $value['daily_contents'];
                        break;
                    case HintConst::$LABLE_LESSONS_PATH:
                        $summary['lessons'] = $value['daily_contents'];
                        break;
                    case HintConst::$DAILY_HOMEWORK_PATH:
                        $summary['homework'] = $value['daily_contents'];
                        break;
                    default:
                        break;
                }
            }
        }
        return $summary;
    }
    public function getCustomLifeLable($custom, $lable, $date)
    {
        $user = CommonFun::array2to1($custom, 'id');
        $mc_name = $this->getMcName() . 'getCustomLifeLable' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $mo = $val;
        } else {
            $mo = self::find()->asArray()
                ->select('custom_id,daily_contents')
                ->where(['daily_type_id' => $lable, 'date' => $date])
                ->andFilterWhere(['in', 'custom_id', $user])
                ->all();
            $this->mc->add($mc_name, $mo);
        }
        return $mo;
    }
}
