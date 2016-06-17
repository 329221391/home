<?php

namespace app\modules\Admin\Notes\models;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Message\models\Messages;
use app\modules\AppBase\base\appbase\Asyn;
use app\modules\AppBase\base\appbase\base\BaseMain;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\appbase\TransAct;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
use yii\db\Query;
use app\modules\AppBase\base\appbase\BaseAnalyze;
/**
 * This is the model class for table "{{%notes}}".
 * @property integer $id
 * @property integer $pri_type_id
 * @property integer $note_type_id
 * @property integer $a_p_id
 * @property string $for_someone_id
 * @property integer $user_tpye_id
 * @property integer $author_id
 * @property string $title
 * @property string $contents
 * @property string $thumb
 * @property string $createtime
 * @property string $starttime
 * @property string $endtime
 * @property integer $ispassed
 * @property integer $issend
 * @property integer $isdeleted
 */
class Notes extends BaseMain
{
    private $selstr = 'id,school_id,author_id,user_tpye_id,note_type_id,title,contents,thumb,ispassed,createtime,starttime,endtime,view_times,cus_p,sys_p';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notes';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_type_id', 'obj_id', 'a_p_id', 'user_tpye_id', 'author_id', 'ispassed', 'issend', 'isdeleted', 'cus_p', 'sys_p'], 'integer'],
            [['contents'], 'string'],
            [['createtime', 'starttime', 'endtime'], 'safe'],
            [['for_someone_id', 'thumb'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'obj_id' => 'Pri Type ID',
            'note_type_id' => 'Sub Type ID',
            'a_p_id' => 'School ID',
            'for_someone_id' => 'For Someone ID',
            'user_tpye_id' => 'User Tpye ID',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'contents' => 'Contents',
            'thumb' => 'Thumb',
            'createtime' => 'Createtime',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'ispassed' => 'Ispassed',
            'issend' => 'Issend',
            'isdeleted' => 'Isdeleted',
        ];
    }
    public function mydel()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        $mod = isset($_REQUEST['mod']) ? trim($_REQUEST['mod']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $query = new Query();
            $notes = $query->select('id,title,author_id')->from('notes')->where(['id'=>$id])->one();

            $query = new Query();
            //一级回复列表
            $reply_list = $query->select('id')->from('notes_replies')->where(['note_id'=>$id,'link_id'=>0,'receiver_id'=>0])->all();
            $replyObj = new NotesReplies();
            foreach ($reply_list as $row) {
                $t = \Yii::$app->db->beginTransaction();
                $replyObj->forDeleteReplyScore($row['id']);
                $t->commit();
            }
            $table_name  = 'custom_score_'.$this->getTenMod($this->getCustomSchool_id());
            $sql = "DELETE FROM notes WHERE id=$id";
            $sql2 = "DELETE FROM notes_replies WHERE note_id=$id OR link_id=$id";
            $sql3 = "delete from $table_name where pri_type_id=".CatDef::$act['create']." and related_id=$id and p_s_type_id <> 1  and sub_type_id=".CatDef::$mod['note'];
            $ErrCode = (new TransAct())->trans($sql, $sql2,$sql3);

            if($mod == 'audit'){
                $message = '您发布的通知【'.$notes['title'].'】未通过审核，已被删除';
                $receiver_id = $notes['author_id'];
                //$host = \Yii::$app->request->getHostInfo();
                //http_get($host.'/index.php?r=Message/messages/sendmsg&reciever_id='.$receiver_id.'&contents='.$message);
                $messages = new Messages();
                $result = $messages->Sendmsg($message,$receiver_id);
                //$this->push1($receiver_id, $message);
                $user = explode('-', $receiver_id);
                $custom = new Customs();
                $token = $custom->getToken([], [], $user);
                (new MultThread())->push_msg($token, $message);
            }


        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    /*
   * 添加note
   */
    public function AddNote($d)
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        if ($this->checkSession() || $this->checkAdminSession()) {
            $user_type_id = $this->getUserType();
            $school_id = 0;
            $author_id = 0;
            if ($user_type_id == CatDef::$user_cat[HintConst::$F_jyq]) {
                $author_id = Yii::$app->session['custominfo']->custom->id;
                $school_id = Yii::$app->session['custominfo']->custom->school_id;
            } elseif ($user_type_id == CatDef::$user_cat[HintConst::$F_admin]) {
                $author_id = Yii::$app->session['admin_user']['id'];
            }
            $notes = new Notes();
            $d['school_id'] = $school_id;
            $d['user_tpye_id'] = $user_type_id;
            $d['author_id'] = $author_id;
            $d['ispassed'] = $this->getIsCanSend();
            $d['issend'] = HintConst::$YesOrNo_YES;
            $d['createtime'] = CommonFun::getCurrentDateTime();
            $d['sys_p'] = Score::getSysP('create', CatDef::$mod['note']);
            $newid = [];
            if ($tmp = $this->haschar(',', $d['for_someone_id'])) {
                foreach ($tmp as $v) {
                    $d['for_someone_id'] = $v;
                    $newid = array($notes->addNew($d));
                }
            } else {
                $newid = array($notes->addNew($d));
            }
            if ($this->getCustomRole() == HintConst::$ROLE_TEACHER && $this->getIsCanSend() == HintConst::$YesOrNo_YES) {
                $score = new Score();
                $data['related_id'] = $newid[0];
                $data['contents'] = $d['title'];
                $score->NoteCreate($data);
            }
            $this->push($d, $newid[0]);
            $ErrCode = HintConst::$Zero;
            $Message = HintConst::$Success;
            $Content = $newid[0];
        }
        return array("ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content);
    }
    public function NoteDetail($id = 0)
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$WEB_JYQ;
        $Content = HintConst::$NULLARRAY;
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if ($id > 0) {
            $mc_name = $this->getMcName() . 'NoteDetail' . $id;
            if ($val = $this->mc->get($mc_name)) {
                $Content = $val;
            } else {
                $query = new Query();
                $Content = $query->select($this->selstr)
                    ->from('notes as n')
                    ->where('n.id=' . $id)
                    ->one();
                $this->mc->add($mc_name, $Content);
            }
        } else {
            $ErrCode = HintConst::$NoId;
        }
        return ["ErrCode" => $ErrCode, "Message" => $Message, "Content" => $Content];
    }
    //---------rewrite getNote
    public function Getnote()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : $this->getCustomSchool_id();
        $class_id = isset($_REQUEST['class_id']) ? $_REQUEST['class_id'] : $this->getCustomClass_id();
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : $this->getCustomId();
        $role = Yii::$app->session['custominfo']->custom->cat_default_id;
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $mc_name = $this->getMcName() . 'Getnote' . $school_id . $class_id . $user_id . $role . $page . $page_size;
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
        return $result;
    }
    public function Getnopass()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : $this->getCustomSchool_id();
        $class_id = isset($_REQUEST['class_id']) ? $_REQUEST['class_id'] : $this->getCustomClass_id();
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : $this->getCustomId();
        $role = $this->getCustomRole();
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $mc_name = $this->getMcName() . 'Getnopass' . $school_id . $class_id . $user_id . $role . $page . $page_size;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $start_line = $page_size * ($page - 1);
            if (HintConst::$ROLE_HEADMASTER == $role) {
                $Content = $this->get_nopass($school_id, $user_id, $start_line, $page_size);
            }
            $this->mc->add($mc_name, $Content);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return $result;
    }
    public function get_nopass($school_id, $user_id, $start_line, $page_size)
    {
        $mc_name = $this->getMcName() . 'get_nopass' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select($this->selstr)
                ->distinct()
                ->from('notes as n')
                //本人发起:
                ->where('n.author_id=' . $user_id)
                //全部:没有写完,现在admin先不设计
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['all'])
                //部分:发给学校
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.school_id=' . $school_id)
                ->andWhere(['ispassed' => HintConst::$YesOrNo_NO])
                ->orderBy('n.id desc')
                ->offset($start_line)
                ->limit($page_size)
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function getHeadRec($school_id, $user_id, $start_line, $page_size)
    {
        $mc_name = $this->getMcName() . 'getHeadRec' . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select($this->selstr)
                ->distinct()
                ->from('notes as n')
                //本人发起:
                ->where('n.author_id=' . $user_id)
                //全部:没有写完,现在admin先不设计
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['all'])
                //部分:发给学校
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.school_id=' . $school_id)
                ->andWhere(['n.ispassed' => HintConst::$YesOrNo_YES])
                ->orderBy('n.id desc')
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
            $Content = $query->select($this->selstr)
                ->distinct()
                ->from('notes as n')
                //本人发起:
                ->where('n.author_id=' . $user_id)
                //全部:没有写完,现在admin先不设计
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['all'])
                //部分:发给学校
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['school'] . ' and n.for_someone_type=' . CatDef::$obj_cat['all'] . ' and n.for_someone_id=' . $school_id)
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['all'] . ' and n.for_someone_type=' . CatDef::$obj_cat['school'] . ' and n.for_someone_id=' . $school_id)
                //部分:发给班级
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['class'] . ' and n.for_someone_type=' . CatDef::$obj_cat['all'] . ' and n.for_someone_id REGEXP ' . "'^$class_id'")
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['all'] . ' and n.for_someone_type=' . CatDef::$obj_cat['class'] . ' and n.for_someone_id REGEXP ' . "'^$class_id'")
                //部分:发给学校的全部老师
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['teacher'] . ' and n.for_someone_type=' . CatDef::$obj_cat['school'] . ' and n.for_someone_id=' . $school_id)
                //部分:发给学校的全部家长-------不能查看
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['parent'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['school'] . ' and vsr.for_someone_id=' . $school_id)
                //部分:发给老师本人--不发给个人
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['teacher'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id-$user_id'")
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['teacher'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id-$user_id'")
                ->andWhere(['n.ispassed' => HintConst::$YesOrNo_YES])
                ->orderBy('n.id desc')
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
            $Content = $query->select($this->selstr)
                ->distinct()
                ->from('notes as n')
                //全部:没有写完,现在admin先不设计
                ->where('n.a_p_id=' . CatDef::$ap_cat['all'])
                //部分:发给学校
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['school'] . ' and n.for_someone_type=' . CatDef::$obj_cat['all'] . ' and n.for_someone_id=' . $school_id)
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['all'] . ' and n.for_someone_type=' . CatDef::$obj_cat['school'] . ' and n.for_someone_id=' . $school_id)
                //部分:发给班级
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['class'] . ' and n.for_someone_type=' . CatDef::$obj_cat['all'] . ' and n.for_someone_id REGEXP ' . "'^$class_id'")
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['all'] . ' and n.for_someone_type=' . CatDef::$obj_cat['class'] . ' and n.for_someone_id REGEXP ' . "'^$class_id'")
                // 部分:发给学校的全部家长
                ->orWhere('n.a_p_id=' . CatDef::$ap_cat['part'] . ' and n.obj_id=' . CatDef::$obj_cat['parent'] . ' and n.for_someone_type=' . CatDef::$obj_cat['school'] . ' and n.for_someone_id=' . $school_id)
                //部分:发给家长本人--不发给个人
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['parent'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id-$user_id'")
//                ->orWhere('vsr.a_p_id=' . CatDef::$ap_cat['part'] . ' and vsr.obj_id=' . CatDef::$obj_cat['all'] . ' and vsr.for_someone_type=' . CatDef::$obj_cat['parent'] . ' and vsr.for_someone_id REGEXP ' . "'^$school_id-$class_id-$user_id'")
                ->andWhere(['n.ispassed' => HintConst::$YesOrNo_YES])
                ->orderBy('n.id desc')
                ->offset($start_line)
                ->limit($page_size)
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function addNew($d)
    {
        $note = new Notes();
        foreach ($d as $k => $v) {
            $note->$k = $v;
        }
        $note->save(false);
        return $note->attributes['id'];
    }
    public function  getSchoolAndClassForNote(&$school, &$class, $d)
    {
        if ($d['a_p_id'] == CatDef::$ap_cat['part']) {
            //send to scholl
            if (($d['obj_id'] == CatDef::$obj_cat['school'] && $d['for_someone_type'] == CatDef::$obj_cat['all']) || ($d['obj_id'] == CatDef::$obj_cat['all'] && $d['for_someone_type'] == CatDef::$obj_cat['school'])) {
                $this->getSchoolOrClassArrByString($school, $d['for_someone_id']);
            }
            //send to class
            if (($d['obj_id'] == CatDef::$obj_cat['class'] && $d['for_someone_type'] == CatDef::$obj_cat['all']) || ($d['obj_id'] == CatDef::$obj_cat['all'] && $d['for_someone_type'] == CatDef::$obj_cat['class'])) {
                $this->getSchoolOrClassArrByString($class, $d['for_someone_id']);
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
    public function push($d, $id)
    {
        $d['id'] = $id;
        $asyn = new Asyn();
        $asyn->pushaddnote($d);
    }
    public function getNum($school_id, $startdate, $enddate)
    {
        $mc_name = $this->getMcName() . 'notegetNum' . json_encode(func_get_args());
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
    //审核通知
    public function Pass()
    {
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : Yii::$app->request->get('id');
        //拆分send_to
        $id = explode(',', $id);
        $id = array_filter($id);//过滤为空的值
        $id = array_unique($id);//过滤重复的值
        if (count($id) > 0) {
            foreach ($id as $key => $value) {
                $mo = self::findId($value);
                $mo->ispassed = HintConst::$YesOrNo_YES;
                $author_id = $mo->author_id;
                $sys_p = $mo->sys_p;
                $title = $mo->title;
                $mo->save();
                /*if ($author_id != $this->getCustomId()) {
                    (new Customs())->increaseF($author_id, 'points', $sys_p);
                }*/
                $query = new Query();
                $custom = $query->select('id,name_zh')->from('customs')->where(['id'=>$author_id])->one();
                $score = new Score();
                $data['related_id'] = $value;
                $data['contents'] = $title;
                if (!get_magic_quotes_gpc()) {
                    // 处理字符串，自动添加“\”
                    $data['contents'] = addslashes($title);
                }
                else
                {
                    // 不做任何处理
                    $data['contents'] = $title;
                }
                $data['custom_id'] = $author_id;
                $data['custom_name'] = $custom['name_zh'];
                $score->NoteCreate($data);
                //self::push_pass($author_id, CatDef::$mod['note'], $value, $sys_p, $data['contents']);
                $message = '您发布的通知【'.$title.'】通过审核';
                $receiver_id = $author_id;
                //$host = \Yii::$app->request->getHostInfo();
                //http_get($host.'/index.php?r=Message/messages/sendmsg&reciever_id='.$receiver_id.'&contents='.$message);
                $messages = new Messages();
                $result = $messages->Sendmsg($message, $receiver_id);
                //$this->push1($receiver_id, $message);
                $user = explode('-', $receiver_id);
                $custom = new Customs();
                $token = $custom->getToken([], [], $user);
                (new MultThread())->push_msg($token, $message);
            }
        }
        self::pushAuditById($id[0], $title);
        $result = ['ErrCode' => '0', 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return (json_encode($result));
    }
    public function getSR(&$d, $id)
    {
        $r = $this->findId($id);
        $d['a_p_id'] = $r->a_p_id;
        $d['obj_id'] = $r->obj_id;
        $d['for_someone_type'] = $r->for_someone_type;
        $d['for_someone_id'] = $r->for_someone_id;
    }
    public function push_pass($user_id, $type, $id, $reward, $con)
    {
        $asyn = new Asyn();
        $asyn->note_push_pass(['user_id' => $user_id, 'type' => $type, 'id' => $id, 'reward' => $reward, 'con' => $con]);
    }
    public function pushAuditById($id, $title)//used for audit
    {
        $asyn = new Asyn();
        $asyn->note_pushAuditById(['id' => $id, 'title' => $title]);
    }
}
