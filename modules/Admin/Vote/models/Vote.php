<?php

namespace app\modules\Admin\Vote\models;
use app\models\HbPush;
use app\modules\Admin\Articles\models\Articles;
use app\modules\Admin\Articles\models\ArticlesFav;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\Asyn;
use app\modules\AppBase\base\appbase\base\BaseMain;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\appbase\TransAct;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use app\modules\AppBase\base\appbase\BaseAnalyze;
/**
 * This is the model class for table "vote".
 * @property integer $id
 * @property integer $author_id
 * @property integer $author_type_id
 * @property integer $pri_type_id
 * @property integer $sub_type_id
 * @property integer $school_id
 * @property integer $class_id
 * @property string $title
 * @property string $contents
 * @property string $date
 * @property string $createtime
 * @property integer $yes
 * @property integer $no
 */
class Vote extends BaseMain
{
    private $sel_vote = 'v.id,v.author_id,v.pri_type_id,v.sub_type_id,v.title,vcon.contents,v.date,v.createtime,v.yes,v.no';
    private $sel_vote_detail = 'v.id,v.author_id,c.name_zh,c.logo,v.pri_type_id,v.sub_type_id,v.title,vcon.contents,v.date,v.createtime,v.reward,v.adopt_id,v.view_times,v.praise_times,v.share_times,v.yes,v.no';
    private $sel_club = 'v.id,v.author_id,c.name_zh,c.logo,v.url_thumb,v.title,vcon.contents,v.createtime,v.reward,v.adopt_id,v.isdeleted,v.view_times,v.praise_times,v.share_times';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'author_type_id', 'pri_type_id', 'sub_type_id', 'yes', 'no', 'isdeleted'], 'integer'],
            [['date', 'createtime'], 'safe'],
            [['title'], 'string', 'max' => 100],
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
            'author_type_id' => 'Author Tpye ID',
            'pri_type_id' => 'Pri Type ID',
            'sub_type_id' => 'Sub Type ID',
            'title' => 'Title',
            'date' => 'Date',
            'createtime' => 'Createtime',
            'yes' => 'Yes',
            'no' => 'No',
        ];
    }
    public function mydel()//for club
    {
        $ErrCode = HintConst::$Zero;
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $m = $this->findId($id);
            if ($m !== null) {
                $m->isdeleted = HintConst::$YesOrNo_YES;
                $m->save(false);
                if ($m->pri_type_id != 250) {
                    $this->mc->flush();
                }
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function votedel()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {

        	$table_name  = 'custom_score_'.($this->getCustomSchool_id() % 10);
            $sql6 = "delete from $table_name where pri_type_id=".CatDef::$act['cast_vote']." and sub_type_id=".CatDef::$mod['opt']." and related_id=".$id;

            $sql = "DELETE FROM vote WHERE id=$id";
            $sql2 = "DELETE FROM vote_att WHERE m_id=$id";
            $sql3 = "DELETE FROM vote_con WHERE m_id=$id";
            $sql4 = "DELETE FROM vote_opt WHERE m_id=$id";
            $sql5 = "DELETE FROM vote_opt_att WHERE m_id=$id";
            
            $ErrCode = (new TransAct())->trans($sql, $sql2, $sql3, $sql4, $sql5,$sql6);
            //(new BaseAnalyze())->writeToAnal('aaaaaaaaaaaaaa:'.$id);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function Addvote($pri_type_id)
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $user_type_id = 0;
        $school_id = 0;
        $author_id = 0;
        if ($this->checkSession() || $this->checkAdminSession()) {
            $user_type_id = $this->getUserType();
            $author_id = 0;
            if ($user_type_id == CatDef::$user_cat[HintConst::$F_jyq]) {
                $author_id = $this->getCustomId();
                $school_id = $this->getCustomSchool_id();
            } elseif ($user_type_id == CatDef::$user_cat[HintConst::$F_admin]) {
                $author_id = Yii::$app->session['admin_user']['id'];
            }
        }
        $d['school_id'] = $school_id;
        $d['author_id'] = $author_id;
        $d['author_type_id'] = $user_type_id;
        $d['pri_type_id'] = $pri_type_id;
        $d['sub_type_id'] = isset($_REQUEST['sub_type_id']) ? trim($_REQUEST['sub_type_id']) : 0;
        $d['title'] = isset($_REQUEST['title']) ? trim($_REQUEST['title']) : '';
        $d['reward'] = isset($_REQUEST['reward']) ? trim($_REQUEST['reward']) : 0;
        $dcon['contents'] = isset($_REQUEST['contents']) ? trim($_REQUEST['contents']) : '';
        $dsr['a_p_id'] = isset($_REQUEST['a_p_id']) ? $_REQUEST['a_p_id'] : '0';
        $dsr['obj_id'] = isset($_REQUEST['obj_id']) ? $_REQUEST['obj_id'] : '0';
        $dsr['for_someone_type'] = isset($_REQUEST['for_someone_type']) ? $_REQUEST['for_someone_type'] : '0';
        $dsr['for_someone_id'] = isset($_REQUEST['for_someone_id']) ? $_REQUEST['for_someone_id'] : '0';
        if (!is_numeric($d['pri_type_id'])) {
            $ErrCode = HintConst::$No_pri_type_id;
        } elseif (empty($d['title'])) {
            $ErrCode = HintConst::$No_title;
        } elseif (empty($dcon['contents'])) {
            $ErrCode = HintConst::$NoContents;
        } elseif (empty($dcon['contents'])) {
            $ErrCode = HintConst::$NoContents;
        } elseif ($dsr['for_someone_id'] == HintConst::$Zero && $dsr['a_p_id'] != 0) {
            $ErrCode = HintConst::$No_for_someone_id;
        } else {
            $custom = new Customs();
            if ($custom->checkCoin($d['reward'])) {
                $Content = $dcon['m_id'] = $dsr['m_id'] = $this->addNew($d);
                $votecon = new VoteCon();
                $votecon->addNew($dcon);

                if (!($pri_type_id == CatDef::$mod['club_arti'] || $pri_type_id == CatDef::$mod['club_teacher'] || $pri_type_id == CatDef::$mod['club_parent'] || $pri_type_id == CatDef::$mod['club_topic'] || $pri_type_id == CatDef::$mod['club_help'] || $pri_type_id == CatDef::$mod['club_se'] || $pri_type_id == CatDef::$mod['club_po'])) {
                    $votesr = new VoteSR();
                    $votesr->addSR($dsr);
                    //新的推送
                    $hbPush = new HbPush();
                    $hbPush->createVotePush($Content);
                    //$this->push($dsr, $Content, $d['title']);
                    //园长只有coin没有point.所以园长发调查既没有积分也没有金币
                } else {//发布俱乐部
                    $score = new Score();
                    $data['sub_type_id'] = $d['pri_type_id'];
                    $data['related_id'] = $Content;
                    $data['contents'] = $d['title'];
                    $score->ClubArtiCreate($data);
                    //新的推送
                    $hbPush = new HbPush();
                    $hbPush->createClubPush($Content,$pri_type_id);
                    //$this->pushaddclub($d['pri_type_id'] . '-' . $Content, $d['title']);
                }
            } else {
                $ErrCode = HintConst::$No_more_point;
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    protected function addNew($d)
    {
        $d['date'] = date('Y-m-d');
        $d['createtime'] = date('Y-m-d H:i:s', time());
        $vote = new Vote();
        foreach ($d as $k => $v) {
            $vote->$k = $v;
        }
        $vote->save(false);
        return $vote->attributes['id'];
    }
    public function Clublist()
    {
        $d['pri_type_id'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : CatDef::$mod['club_arti'];
        $d['filt'] = isset($_REQUEST['filt']) ? $_REQUEST['filt'] : CatDef::$filt['latest'];
        $d['my'] = isset($_REQUEST['my']) ? $_REQUEST['my'] : CatDef::$my['all'];
        $d['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $d['page_size'] = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $d['start_line'] = $d['page_size'] * ($d['page'] - 1);
        $result = ['ErrCode' => HintConst::$Zero, 'Message' => HintConst::$WEB_JYQ, 'Content' => $this->Club_list($d)];
        return json_encode($result);
    }
    public function Club_list($d)
    {
        $mc_name = 'Club_list' . json_encode($d) . $this->getMcName();
        if ($val = $this->mc->get($mc_name)) {
            $r = $val;
        } else {
            $r['sum'] = 0;
            $query = new Query();
            $Content = $query->select($this->sel_club)
                ->distinct()
                ->from('vote as v')
                ->leftJoin('customs as c', 'v.author_id=c.id')
                ->leftJoin('vote_con as vcon', 'vcon.m_id=v.id')
                ->where(['v.pri_type_id' => $d['pri_type_id'], 'v.isdeleted' => HintConst::$YesOrNo_NO]);
            if ($d['my']) {
                $Content = $Content->andWhere('v.author_id=' . $this->getCustomId());
                $r['sum'] = $this->getSum($d);
            }
            if ($d['filt'] == CatDef::$filt['latest']) {
                $Content = $Content->orderBy('v.id desc');
            } else {
                $Content = $Content->orderBy(['v.view_times' => SORT_DESC, 'v.praise_times' => SORT_DESC]);
            }
            $Content = $Content->offset($d['start_line'])
                ->limit($d['page_size'])
                ->all();
            $r['list'] = $Content;
            $this->mc->add($mc_name, $r);
        }
        return $r;
    }
    public function Club_list_for_audit($d)
    {
        $mc_name = 'Club_list_for_audit' . json_encode($d) . $this->getMcName();
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $query = new Query();
            $data = $query->select($this->sel_club)
                ->distinct()
                ->from('vote as v')
                ->leftJoin('customs as c', 'v.author_id=c.id')
                ->leftJoin('vote_con as vcon', 'vcon.m_id=v.id')
                ->where(['v.pri_type_id' => $d['pri_type_id'], 'v.isdeleted' => HintConst::$YesOrNo_NO])
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
    public function getSum($d)
    {
        $mc_name = $this->getMcName() . 'getSum' . json_encode($d);
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select('count(id) as sum')
                ->distinct()
                ->from('vote as v')
                ->where('v.pri_type_id=' . $d['pri_type_id']);
            if ($d['my']) {
                $Content = $Content->andWhere('v.author_id=' . $this->getCustomId());
            }
            $Content = $Content->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content[0]['sum'];
    }
    public function Getvotelist()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : Yii::$app->session['custominfo']->custom->school_id;
        $class_id = isset($_REQUEST['class_id']) ? $_REQUEST['class_id'] : Yii::$app->session['custominfo']->custom->class_id;
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : Yii::$app->session['custominfo']->custom->id;
        $role = Yii::$app->session['custominfo']->custom->cat_default_id;
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $mc_name = $this->getMcName() . 'Getvotelist' . $school_id . $class_id . $user_id . $role . $page . $page_size;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $start_line = $page_size * ($page - 1);
            if (HintConst::$ROLE_HEADMASTER == $role) {
                $Content = $this->getHeadRec($school_id, $user_id, $start_line, $page_size);
            } elseif (HintConst::$ROLE_TEACHER == $role) {
                $Content = $this->getTeachRec($school_id, $class_id, $user_id, $start_line, $page_size);
            } elseif (HintConst::$ROLE_PARENT == $role) {
                $Content = $this->getParentRec($school_id, $class_id, $user_id, $start_line, $page_size);
            }
            $this->mc->add($mc_name, $Content);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function getHeadRec($school_id, $user_id, $start_line, $page_size)
    {
        $mc_name = $this->getMcName() . 'getHeadRec' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select($this->sel_vote)
                ->distinct()
                ->from('vote as v')
                ->leftJoin('vote_s_r as vsr', 'vsr.m_id=v.id')
                ->leftJoin('vote_con as vcon', 'vcon.m_id=v.id')
                //本人发起:
                ->where('v.author_id=' . $user_id)
                //全部:没有写完,现在admin先不设计
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['all'])
                //部分:发给学校
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id=' . $school_id)
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给班级
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['class'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-'")
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['class'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-'")
                //部分:发给学校的全部老师
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['teacher'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给学校的全部家长
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['parent'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给校长本人--不发给个人
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['headmast'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-0-$user_id'")
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['headmast'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-0-$user_id'")
                ->andWhere('pri_type_id=' . CatDef::$mod['vote'])
                ->orderBy('v.id desc')
                ->offset($start_line)
                ->limit($page_size)
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function getTeachRec($school_id, $class_id, $user_id, $start_line, $page_size)
    {
        $mc_name = $this->getMcName() . 'getTeachRec' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select($this->sel_vote)
                ->distinct()
                ->from('vote as v')
                ->leftJoin('vote_s_r as vsr', 'vsr.m_id=v.id')
                ->leftJoin('vote_con as vcon', 'vcon.m_id=v.id')
                //全部:没有写完,现在admin先不设计
                ->where('vsr.a_p_id=' . CatDef::$ap_cat['all'])
                //部分:发给学校
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id=' . $school_id)
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给班级
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['class'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id'")
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['class'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id'")
                //部分:发给学校的全部老师
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['teacher'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给学校的全部家长-------不能查看
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['parent'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给老师本人--不发给个人
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['teacher'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id-$user_id'")
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['teacher'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id-$user_id'")
                ->andWhere('pri_type_id=' . CatDef::$mod['vote'])
                ->orderBy('v.id desc')
                ->offset($start_line)
                ->limit($page_size)
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function getParentRec($school_id, $class_id, $user_id, $start_line, $page_size)
    {
        $mc_name = $this->getMcName() . 'getParentRec' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select($this->sel_vote)
                ->distinct()
                ->from('vote as v')
                ->leftJoin('vote_s_r as vsr', 'vsr.m_id=v.id')
                ->leftJoin('vote_con as vcon', 'vcon.m_id=v.id')
                //全部:没有写完,现在admin先不设计
                ->where('vsr.a_p_id=' . CatDef::$ap_cat['all'])
                //部分:发给学校
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id=' . $school_id)
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给班级
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['class'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id'")
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['class'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id'")
                // 部分:发给学校的全部家长
                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['parent'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给家长本人--不发给个人
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['parent'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id-$user_id'")
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['parent'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id-$user_id'")
                ->andWhere('pri_type_id=' . CatDef::$mod['vote'])
                ->orderBy('v.id desc')
                ->offset($start_line)
                ->limit($page_size)
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function Praise()
    {
        $ErrCode = HintConst::$Zero;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $this->increasePraisewTimes($id);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$WEB_JYQ, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function Getdetail()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$WEB_JYQ;
        $Content = HintConst::$NULLARRAY;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $Content = $this->Get_detail($id);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function Get_detail($id)
    {
        $mc_name = $this->getMcName() . $this->tableName() . 'Get_detail' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
            $this->increaseViewTimes($id);
            $voteView = new VoteView();
            $d['m_id'] = $id;
            $voteView->AddView($d);
        } else {
            $query = new Query();
            $Content = $query->select($this->sel_vote_detail)
                ->distinct()
                ->from('vote as v')
                ->leftJoin('vote_con as vcon', 'vcon.m_id=v.id')
                ->leftJoin('customs as c', 'c.id=v.author_id')
                ->where("v.id=$id")
                ->one();
            if ($this->getName() == 'vote') {
                if ($Content['id'] != 0 || !empty($Content['id'])) {
                    $opt = new VoteOpt();
                    $Content['opt'] = $opt->Get_opt($Content['id']);
                }
            } else {
                $Content = array_slice($Content, 0, count($Content) - 2);
                $Content['att'] = null;
                $Content['isfav'] = 0;
                $r = $this->findId($id);
                if ($r !== null) {
                    $Content['att'] = (new VoteAtt())->getAtt($id);
                    $data['costom_id'] = $this->getCustomId();
                    $data['pri_type_id'] = $r->pri_type_id;
                    $data['article_id'] = $id;
                    $data['article_att_id'] = 0;
                    $c = (new ArticlesFav())->CheckFav($data);
                    if ($c) {
                        $dd = $c['id'];
                    } else {
                        $dd = 0;
                    }
                    $Content['isfav'] = $dd;
                }
            }
            $voteView = new VoteView();
            $d['m_id'] = $id;
            $voteView->AddView($d);
            $this->increaseViewTimes($id);
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    protected function  getSchoolAndClassForVote(&$school, &$class, $d)
    {
        if ($d['a_p_id'] == CatDef::$ap_cat['part']) {
            //send to scholl
            if (($d['obj_id'] == CatDef::$obj_cat['school'] && $d['for_someone_type'] == CatDef::$obj_cat['all']) || ($d['obj_id'] == CatDef::$obj_cat['all'] && $d['for_someone_type'] == CatDef::$obj_cat['school'])) {
                $this->getSchoolOrClassArrByString($school, $d['for_someone_id']);
            }
            //send to class
            if (($d['obj_id'] == CatDef::$obj_cat['class'] && $d['for_someone_type'] == CatDef::$obj_cat['all']) || ($d['obj_id'] == CatDef::$obj_cat['all'] && $d['for_someone_type'] == CatDef::$obj_cat['class'])) {
                $this->getClassArrayByString($class, $d['for_someone_id']);
            }
            //send to teacher of school
            if ($d['obj_id'] == CatDef::$obj_cat['teacher'] && $d['for_someone_type'] == CatDef::$obj_cat['school']) {
                $this->getSchoolOrClassArrByString($school, $d['for_someone_id']);
            }
            //send to parent of school
            if ($d['obj_id'] == CatDef::$obj_cat['parent'] && $d['for_someone_type'] == CatDef::$obj_cat['school']) {
                $this->getSchoolOrClassArrByString($school, $d['for_someone_id']);
            }
        }
    }
    public function push($d, $id, $title)
    {
        $school = [];
        $class = [];
        $this->getSchoolAndClassForVote($school, $class, $d);
        $custom = new Customs();
        $token = $custom->getToken($school, $class, [], $d['obj_id']);
        (new MultThread())->push_vote($token, $id, $title);
    }
    public function getNum($school_id, $startdate, $enddate)
    {
        $mc_name = $this->getMcName() . 'votegetNum' . json_encode(func_get_args());
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
    public function Share()
    {
        return (new Articles())->AddAHE(CatDef::$mod['article']);
    }
    public function getClub($id)
    {
        $mc_name = $this->getMcName() . 'getClub' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $r = $val;
        } else {
            $r = Vote::find()->asArray()
                ->from('vote as v')
                ->select($this->sel_club)
                ->leftJoin('customs as c', 'c.id=v.author_id')
                ->leftJoin('vote_con as vcon', 'vcon.m_id=v.id')
                ->where(['v.id' => $id])
                ->one();
            $this->mc->add($mc_name, $r);
        }
        return $r;
    }
    public function getClubBySharedId(&$con)
    {
        $r = $this->getClub($con['o_link_id']);
        if (count($r) > 0) {
            $con['author_id'] = $r['author_id'];
            $con['author_name'] = $r['name_zh'];
            $con['title'] = $r['title'];
            $con['thumb'] = $r['url_thumb'];
            if ($r['isdeleted'] != HintConst::$YesOrNo_YES) {
                $con['contents'] = $r['contents'];
            } else {
                $con['contents'] = '很抱歉,文章已经被作者删除了!';
                $con['author_id'] = '0';
            }
        } else {
            $con['author_id'] = '0';
            $con['author_name'] = '';
            $con['title'] = $con['contents'] = '很抱歉,文章已经被作者删除了!';
            $con['thumb'] = '';
        }
    }
    public function getType($id)
    {
        $mc_name = $this->getMcName() . 'getType' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $d = self::find()->asArray()
                ->select('pri_type_id,sub_type_id')
                ->where("id=$id")
                ->one();
            if ($d === null) {
                $d['pri_type_id'] = 0;
                $d['sub_type_id'] = 0;
            }
            $this->mc->add($mc_name, $d);
        }
        return $d;
    }
    public function  pushaddclub($pri_type_id, $title)
    {
        $asyn = new Asyn();
        $asyn->pushaddclub(['pri_type_id' => $pri_type_id, 'title' => $title]);
    }
}
