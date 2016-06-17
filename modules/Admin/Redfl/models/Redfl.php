<?php

namespace app\modules\admin\Redfl\models;
use app\modules\Admin\CheckIn\models\CheckIn;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\Asyn;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "redfl".
 * @property integer $id
 * @property integer $author_id
 * @property integer $author_tpye_id
 * @property integer $pri_type_id
 * @property integer $sub_type_id
 * @property integer $school_id
 * @property integer $class_id
 * @property integer $for_someone_id
 * @property string $contents
 * @property string $date
 * @property string $createtime
 */
class Redfl extends BaseAR
{
    private $sel_fl = 'id,author_id,author_name,pri_type_id,receiver_id,receiver_name,createtime';
    private $sel_flist = "count(if(pri_type_id=249,true,null)) as 'rf',count(if(pri_type_id=248,true,null)) as 'gf', DATE_FORMAT(createtime,'%Y-%m-%d') as 'createtime'";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'redfl';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'author_tpye_id', 'pri_type_id', 'sub_type_id', 'school_id', 'class_id', 'for_someone_id'], 'integer'],
            [['date', 'createtime'], 'safe'],
            [['contents'], 'string', 'max' => 100]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'author_tpye_id' => 'Author Tpye ID',
            'pri_type_id' => 'Pri Type ID',
            'sub_type_id' => 'Sub Type ID',
            'school_id' => 'School ID',
            'class_id' => 'Class ID',
            'for_someone_id' => 'For Someone ID',
            'contents' => 'Contents',
            'date' => 'Date',
            'createtime' => 'Createtime',
        ];
    }
    public function Addrf()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $d['receiver_id'] = isset($_REQUEST['receiver_id']) ? $_REQUEST['receiver_id'] : '';
        $d['author_id'] = isset($_REQUEST['author_id']) ? $_REQUEST['author_id'] : '';
        $d['pri_type_id'] = isset($_REQUEST['pri_type_id']) ? $_REQUEST['pri_type_id'] : CatDef::$mod['rf'];
        $d['createtime'] = isset($_REQUEST['createtime']) ? $_REQUEST['createtime'] : CommonFun::getCurrentDateTime();
        if (empty($d['receiver_id'])) {
            $ErrCode = HintConst::$NoRecieverId;
        } elseif (empty($d['author_id'])) {
            $ErrCode = HintConst::$No_author_id;
        } elseif ($d['pri_type_id'] == CatDef::$mod['gf'] && self::checkGf($d)) {
            $ErrCode = HintConst::$AlreadExist;
        } else {
            $custom = new Customs();
            $receiver_info = $custom->Get_cusbyf('id', $d['receiver_id']);
            $author_info = $custom->Get_cusbyf('id', $d['author_id']);
            if (count($receiver_info) > 0 && count($author_info)) {
                $d['author_name'] = $author_info['name_zh'];
                $d['receiver_name'] = $receiver_info['name_zh'];
                $d['school_id'] = $receiver_info['school_id'];
                $d['class_id'] = $receiver_info['class_id'];
                $d['contents'] = isset($_REQUEST['contents']) ? trim($_REQUEST['contents']) : '';
                $Content = self::addNew($d);
                if ($d['pri_type_id'] == CatDef::$mod['gf']) {
                    $dd['contents'] = '发了一朵小金花';
                    $custom->increaseF($d['receiver_id'], 'gf', 1);
                } else {
                    $dd['contents'] = '发了一朵小红花';
                    $custom->increaseF($d['receiver_id'], 'redflower', 1);
                }
                $score = new Score();
                $dd['sub_type_id'] = $d['pri_type_id'];
                $dd['related_id'] = $Content;
                $dd['custom_id'] = $d['author_id'];
                $score->addRf($dd);
                $this->push($d['receiver_id'], $d['pri_type_id'], $Content);


                //添加考勤功能
                $checkin = new CheckIn();
                $check_date = strtotime($d['createtime']);
                $checkin->create($d['receiver_id'],$d['author_id'],0,$check_date,1);

            } else {
                $ErrCode = HintConst::$NoRecord;
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => $Content];
        return json_encode($result);
    }
    protected function checkGf($d)
    {
        $mc_name = $this->getMcName() . 'checkGf' . json_encode($d);
        $myday = $d['createtime'];
        if ($val = $this->mc->get($mc_name)) {
            $r = $val;
        } else {
            $sql = "SELECT id FROM redfl where pri_type_id=" . CatDef::$mod['gf'] . " AND author_id=" . $d['author_id'] . " AND receiver_id=" . $d['receiver_id'] . "  AND TO_DAYS('$myday')-TO_DAYS(createtime)=0 limit 1 offset 0";
            $conn = Yii::$app->db;
            $command = $conn->createCommand($sql);
            $mo = $command->queryOne();
            if ($mo) {
                $r = true;
            } else {
                $r = false;
            }
            $this->mc->add($mc_name, $r);
        }
        return $r;
    }
    protected function addNew($d)
    {
        $rf = new Redfl();
        foreach ($d as $k => $v) {
            $rf->$k = $v;
        }
        $rf->save(false);
        return $rf->attributes['id'];
    }
    public function Getfldetail()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $this->getCustomId();
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : CommonFun::getCurrentDate();
        if (!is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $Content = self::Get_fldetail($id, $date);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => $Content];
        return json_encode($result);
    }
    public function Getfldebyid()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        if (!is_numeric($id) || $id == 0) {
            $ErrCode = HintConst::$NoId;
        } else {
            $Content = self::Get_fldetail($id);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => $Content];
        return json_encode($result);
    }
    public function Get_fldetail($id, $date = 0)
    {
        $mc_name = $this->getMcName() . 'Get_fldetail' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $r = $val;
        } else {
            $r = (new Query())->select($this->sel_fl)
                ->from('redfl');
            if ($date) {
                $dater = CommonFun::getDateRight($date);
                $r = $r->where("receiver_id=$id and (createtime between '$date' and '$dater')")
                    ->all();
            } else {
                $r = $r->where("id=$id")
                    ->one();
            }
            $this->mc->add($mc_name, $r);
        }
        return $r;
    }
    public function Getflist()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $this->getCustomId();
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        if (!is_numeric($id) || !is_numeric($page)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $Content = self::Get_flist($id, $page);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => $Content];
        return json_encode($result);
    }
    public function Get_flist($id, $page)
    {
        $mc_name = $this->getMcName() . 'Get_flist' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $r = $val;
        } else {
            $sql = "SELECT count(if (pri_type_id = 249,true,null)) as rf,count(if (pri_type_id = 248,true,null)) as gf, DATE_FORMAT(createtime, '%Y-%m-%d') as createtime FROM home . redfl where receiver_id = $id AND TO_DAYS(now()) - TO_DAYS(createtime) > 0 group by TO_DAYS(createtime) order by createtime desc limit 10 offset " . ($page - 1) * 10;
            $conn = Yii::$app->db;
            $command = $conn->createCommand($sql);
            $r = $command->queryAll();
            $this->mc->add($mc_name, $r);
        }
        return $r;
    }
    public function push($user_id, $type, $id)
    {
        $asyn = new Asyn();
        $asyn->pushrf(['user_id' => $user_id, 'type' => $type, 'id' => $id]);
    }
    public function getEvaReceiver($id)
    {
        $m = $this->findId($id);
        if ($m !== null) {
            return $m->school_id . '-' . $m->class_id . '-' . $m->receiver_id;
        }
    }


    public function getNum($school_id, $startdate, $enddate){
        $mc_name = $this->getMcName() . 'rfgetNum' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $d = $this->find()->asArray()
                ->select('count(id) as num')
                ->where("createtime between '$startdate' and '$enddate'");
            if ($school_id) {
                $d = $d->andWhere("school_id=$school_id");
            }
            $d = $d->one();
            $this->mc->add($mc_name, $d);
        }
        return $d;
    }
}
