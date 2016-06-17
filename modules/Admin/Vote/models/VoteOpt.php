<?php

namespace app\modules\Admin\Vote\models;
use app\modules\AppBase\base\appbase\base\BaseOpt;
use app\modules\AppBase\base\appbase\TransAct;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "vote_opt".
 * @property integer $id
 * @property integer $m_id
 * @property integer $type_id
 * @property integer $parent_id
 * @property string $contents
 * @property integer $yes
 * @property integer $no
 */
class VoteOpt extends BaseOpt
{
    private $selstr = 'vo.id,vo.parent_id,vo.contents,va.url,va.url_thumb,vo.yes,vo.no';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_opt';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'type_id', 'parent_id', 'yes', 'no'], 'integer'],
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
            'm_id' => 'M ID',
            'type_id' => 'Type ID',
            'parent_id' => 'Parent ID',
            'contents' => 'Contents',
            'yes' => 'Yes',
            'no' => 'No',
        ];
    }
    public function Addvoteopt()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $d['m_id'] = isset($_REQUEST['vote_id']) ? trim($_REQUEST['vote_id']) : '';
        $d['type_id'] = isset($_REQUEST['type_id']) ? trim($_REQUEST['type_id']) : 0;
        $doptatt['link_id'] =$d['parent_id'] = isset($_REQUEST['parent_id']) ? trim($_REQUEST['parent_id']) : 0;
        $d['contents'] = isset($_REQUEST['contents']) ? trim($_REQUEST['contents']) : '';
        if (empty($d['m_id']) || !is_numeric($d['m_id'])) {
            $ErrCode = HintConst::$No_vote_id;
        } elseif (empty($d['contents'])) {
            $ErrCode = HintConst::$NoContents;
        } else {
            $school_id = Yii::$app->session['custominfo']->custom->school_id;
            $class_id = Yii::$app->session['custominfo']->custom->class_id;
            $voteoptatt = new VoteOptAtt();
            $file_name = $voteoptatt->create_img($school_id, $class_id, 'images');  //上传图片 并记录文件名
            $Content = $doptatt['m_id'] = $this->addNew($d);
            if ($file_name <> '' && $file_name) {
                $doptatt['url'] = $file_name . '.jpg';
                $doptatt['url_thumb'] = $file_name . '.thumb.jpg';
                $doptatt['type_id'] = CatDef::$vote_att_cat['vote_opt'];
                $voteoptatt->addNew($doptatt);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function addNew($d)
    {
        $voteopt = new VoteOpt();
        foreach ($d as $k => $v) {
            $voteopt->$k = $v;
        }
        $voteopt->save(false);
        return $voteopt->attributes['id'];
    }
    public function Get_opt($id)
    {
        $mc_name = $this->getMcName() . 'Get_opt' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select($this->selstr)
                ->distinct()
                ->from('vote_opt as vo')
                ->leftJoin('vote_opt_att as va', 'va.m_id=vo.id')
                ->where("vo.m_id=$id")
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function increaseF($id, $field, $num = 1)
    {
        $vote = $this->findId($id);
        if ($vote !== null) {
            $vote->$field += $num;
            $vote->save();
        }
    }
    public function Delopt()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $sql = "DELETE FROM vote_opt WHERE id=$id OR parent_id=$id";
            $sql2 = "DELETE FROM vote_opt_att WHERE m_id=$id OR link_id=$id";
            $ErrCode = (new TransAct())->trans($sql, $sql2);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function Deloo()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $sql = "DELETE FROM vote_opt WHERE id=$id";
            $sql2 = "DELETE FROM vote_opt_att WHERE m_id=$id";
            $ErrCode = (new TransAct())->trans($sql, $sql2);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
}
