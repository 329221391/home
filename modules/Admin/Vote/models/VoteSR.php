<?php

namespace app\modules\Admin\Vote\models;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\base\BaseSr;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use Yii;
/**
 * This is the model class for table "vote_s_r".
 * @property integer $id
 * @property integer $m_id
 * @property integer $a_p_id
 * @property integer $obj_id
 * @property integer $for_someone_type
 * @property integer $for_someone_id
 */
class VoteSR extends BaseSr
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_s_r';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'a_p_id', 'obj_id', 'for_someone_type', 'for_someone_id'], 'integer']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'm_id' => 'M ID',
            'a_p_id' => 'A P ID',
            'obj_id' => 'Obj ID',
            'for_someone_type' => 'For Someone Type',
            'for_someone_id' => 'For Someone ID',
        ];
    }
    public function  addSR($d)
    {
        if ($tmp = $this->haschar(',', $d['for_someone_id'])) {
            foreach ($tmp as $v) {
                $d['for_someone_id'] = $v;
                $this->addNew($d);
            }
        } else {
            $this->addNew($d);
        }
    }
    public function addNew($d)
    {
        $votesr = new VoteSR();
        foreach ($d as $k => $v) {
            $votesr->$k = $v;
        }
        $votesr->save(false);
        return $votesr->attributes['id'];
    }
    public function getSum()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $role = Yii::$app->session['custominfo']->custom->cat_default_id;
        $d['m_id'] = isset($_REQUEST['vote_id']) ? trim($_REQUEST['vote_id']) : '';
        if (empty($d['m_id']) || !is_numeric($d['m_id'])) {
            $ErrCode = HintConst::$NoId;
        } elseif (!($role == HintConst::$ROLE_HEADMASTER || $role == HintConst::$ROLE_TEACHER || $role == HintConst::$ROLE_PARENT)) {
            $ErrCode = HintConst::$No_must;
            $Message = HintConst::$No_must_M;
        } else {
            $Content = $this->get_Sum($d['m_id']);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function  get_Sum($m_id)
    {
        $school = [];
        $class = [];
        $query = VoteSR::find()->asArray()
            ->select('id,a_p_id,obj_id,for_someone_type,for_someone_id')
            ->where(['m_id' => $m_id])
            ->all();
        $f1 = $f2 = $f3 = $f4 = '';
        foreach ($query as $k) {
            if ($k['a_p_id'] == CatDef::$ap_cat['part']) {
                //学校人数
                if (($k['obj_id'] == CatDef::$obj_cat['school'] && $k['for_someone_type'] == CatDef::$obj_cat['all']) || ($k['obj_id'] == CatDef::$obj_cat['all'] && $k['for_someone_type'] == CatDef::$obj_cat['school'])) {
                    $f3 = 'school';
                    $school[] = $k['for_someone_id'];
                }
                //班级人数
                if (($k['obj_id'] == CatDef::$obj_cat['class'] && $k['for_someone_type'] == CatDef::$obj_cat['all']) || ($k['obj_id'] == CatDef::$obj_cat['all'] && $k['for_someone_type'] == CatDef::$obj_cat['class'])) {
                    $f4 = 'class';
                    $tmp = explode('-', $k['for_someone_id']);
                    $class[] = $tmp[1];
                }
                //学校老师人数
                if ($k['obj_id'] == CatDef::$obj_cat['teacher'] && $k['for_someone_type'] == CatDef::$obj_cat['school']) {
                    $f1 = 'teacher';
                    $school[] = $k['for_someone_id'];
                }
                //学校家长人数
                if ($k['obj_id'] == CatDef::$obj_cat['parent'] && $k['for_someone_type'] == CatDef::$obj_cat['school']) {
                    $f2 = 'parent';
                    $school[] = $k['for_someone_id'];
                }
            }
        }
        $custom = new Customs();
        $sum = 0;
        if ($f3 == 'school') {
            $sum += $custom->getSum_School($school);
        }
        if ($f4 == 'class') {
            $sum += $custom->getSum_Class($class);
        }
        if ($f1 == 'teacher') {
            $sum += $custom->getSum_School_Teacher($school);
        }
        if ($f2 == 'parent') {
            $sum += $custom->getSum_School_Parent($school);
        }
        return $sum;
    }
}
