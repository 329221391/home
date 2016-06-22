<?php

namespace app\modules\Admin\Articles\models;
use app\models\HbPush;
use app\modules\AppBase\base\appbase\base\BaseReply;
use app\modules\AppBase\base\appbase\TransAct;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use app\modules\AppBase\base\xgpush\XgPush;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "article_replies".
 * @property integer $id
 * @property integer $article_id
 * @property integer $repliers_id
 * @property string $title
 * @property string $contents
 * @property string $createtime
 * @property string $updatetime
 * @property integer $ispassed
 * @property integer $isdelete
 * @property integer $isview
 * @property integer $reply_id
 */
class ArticleReplies extends BaseReply
{
    private $sel_reply = 'r.id,r.article_id as m_id,r.createtime, r.contents,r.repliers_id as sender_id,c.name_zh as sender_name,r.reply_id as receiver_id,cc.name_zh as receiver_name,a.author_id,ccc.name_zh as author_name';
    private $reply_list = 'ar.*,customs.name_zh as repliers_name,customs.cat_default_id as repliers_role_id,c.name_zh as reply_name,c.cat_default_id as reply_role_id';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_replies';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'repliers_id', 'ispassed', 'isdelete', 'isview', 'reply_id', 'cus_p', 'sys_p'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['contents'], 'string', 'max' => 500]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'repliers_id' => 'Repliers ID',
            'title' => 'Title',
            'contents' => 'Contents',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'ispassed' => 'Ispassed',
            'isdelete' => 'Isdelete',
            'isview' => 'Isview',
            'reply_id' => 'Reply ID',
        ];
    }
    public function Delreply()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {

            //先获得该用户在这个文章下的所有评论的列表,按时间排序,如果删除的是第一条回复,则删除回复文章对应的积分记录,并减积分
            /*$query = new Query();
            $article = $query->select('articles.id')
                ->from('article_replies')
                ->leftJoin('articles','articles.id = article_replies.article_id')
                ->where(['article_replies.id'=>$id])->one();

            $article_id = $article['id'];
            $currentUserId = $this->getCustomId();
            $query = new Query();
            $first_reply = $query->select('id')
                ->from('article_replies')
                ->where(['article_id'=>$article_id,'repliers_id'=>$currentUserId])
                ->orderBy('id asc')
                ->limit('0,1')->one();
            //如果删除的id是该用户第一条回复的id
            if($first_reply['id'] == $id){//删除该文章的积分记录数据
                $connection = \Yii::$app->db;
                $table_name  = 'custom_score_'.$this->getTenMod($this->getCustomSchool_id());
                //$command = $connection->createCommand("delete from $table_name where pri_type_id=".CatDef::$act['reply']." and ");
                //$command->execute();
            }*/

            //获得回复的子回复列表,递归删除
            $t = \Yii::$app->db->beginTransaction();
            $this->forDeleteReplyScore($id);
            $t->commit();
            $ErrCode = 0;
            //$sql = "DELETE FROM article_replies WHERE id=$id OR link_id=$id";
            //$ErrCode = (new TransAct())->trans($sql);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }


    public function forDeleteReplyScore($link_id){

        $query = new Query();
        $list = $query->select('id')
            ->from('article_replies')
            ->where(['link_id'=>$link_id])
            ->all();
        if(!empty($list)){
            foreach ($list as $item) {
                $this->forDeleteReplyScore($item['id']);
            }
        }


        $connection = \Yii::$app->db;
        //删除积分记录,排除园长加分
        $query = new Query();
        $art = $query->select('id,article_type_id')->from('articles')->where(['id'=>$link_id])->one();
        $table_name  = 'custom_score_'.$this->getTenMod($this->getCustomSchool_id());
        $command = $connection->createCommand("delete from $table_name where pri_type_id=".CatDef::$act['reply']." and related_id=$link_id and p_s_type_id <> 1 and sub_type_id=".$art['article_type_id']);
        $command->execute();
        //删除回复
        $command = $connection->createCommand("delete from article_replies where id=$link_id");
        $command->execute();
    }


    public function Delrr()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
//            $sql = "DELETE FROM article_replies WHERE id=$id ";
//            $ErrCode = (new TransAct())->trans($sql);
            $t = \Yii::$app->db->beginTransaction();
            $this->forDeleteReplyScore($id);
            $t->commit();
            $ErrCode = 0;
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function Get_replybyid($id)
    {
        $mc_name = $this->getMcName() . 'Get_replybyid' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select($this->sel_reply)
                ->distinct()
                ->from('article_replies as r')
                ->leftjoin('customs as c', 'c.id = r.repliers_id')
                ->leftjoin('customs as cc', 'cc.id = r.reply_id')
                ->leftJoin('articles as a', 'a.id=r.article_id')
                ->leftjoin('customs as ccc', 'ccc.id = a.author_id')
                ->where("r.id in ($id)")
                ->orderby(['r.id' => SORT_DESC])
                ->groupBy('r.id')
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function Reply()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $d['article_id'] = isset($_REQUEST['article_id']) && is_numeric($_REQUEST['article_id']) ? $_REQUEST['article_id'] : 0;
        $d['reply_id'] = isset($_REQUEST['reply_id']) && is_numeric($_REQUEST['reply_id']) ? $_REQUEST['reply_id'] : 0;
        $d['link_id'] = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $d['contents'] = isset($_REQUEST['content']) ? $_REQUEST['content'] : 0;
        if (!$d['article_id']) {
            $ErrCode = HintConst::$No_ar_id;
            $Message = '缺少ID';
        } elseif (!$d['contents']) {
            $ErrCode = HintConst::$NoContents;
            $Message = '缺少Content';
        } elseif ($d['article_id'] && $d['contents']) {
            $d['sys_p'] = Score::getSysP('reply', '');
            $flag = $this->checkReply($d['article_id']);
            if ($flag) {
                $ErrCode = HintConst::$Not_addscore;
                $d['sys_p'] = 0;
            }
            $newid = self::addNew($d);
            $Message = $newid;
            $Content = $d['contents'];
            if (!$flag) {
                $score = new Score();
                //$data['related_id'] = $d['article_id'];
                //related_id应该是回复id
                $data['related_id'] = $newid;
                $data['pri_type_id'] = CatDef::$act['reply'];
                $data['sub_type_id'] = (new Articles())->getTypeAndTitle($d['article_id'])['article_type_id'];
                $data['contents'] = $d['contents'];
                $score->ReplyPoint($data);
            }

            //新的推送逻辑
            $hbPush = new HbPush();

            $query = new Query();
            $art = $query->select('')->from('articles')->where(['id'=>$d['article_id']])->one();
            if($art['article_type_id'] == CatDef::$mod['article']){ //回复文章
                $hbPush->replyArtContentPush($newid);
            }elseif($art['article_type_id'] == CatDef::$mod['moneva']){ //回复月评价
                $hbPush->replyBabyPingjiaReply($newid,$art['article_type_id']);
            }elseif($art['article_type_id'] == CatDef::$mod['termeva']) { //回复年评价
                $hbPush->replyBabyPingjiaReply($newid,$art['article_type_id']);
            }elseif($art['article_type_id'] == CatDef::$mod['pic']){ //回复照片
                //TODO
            }


//            $m = (new Articles())->getFeild('id', $d['article_id']);
//            $receiver = (new ArticleSendRevieve())->getFeild('article_id', $d['article_id']);
//            if ($m !== null) {//月评价和年终总结回复
//                if ($m->article_type_id == CatDef::$mod['moneva'] || $m->article_type_id == CatDef::$mod['termeva']) {
//                    //推送给评价或总结的的接受人
//                    if ($d['reply_id'] == 0 || $d['link_id'] == 0) {
//                        /*张亮说先暂时不要回复的推送了(new Articles())->pushReplyForEva($d['article_id'], $receiver->reciever_id, $d['contents']);*/
//
//                    }else{//如果是二级回复,只推送给reply_id指定的人
//                        //需要推送给园长
//                        //查询园长的id
//                        /*$query = new Query();
//                        $ret = $query->select('schools.headmaster_id')
//                            ->from('articles')
//                            ->leftJoin('schools','schools.id=articles.school_id')
//                            ->where(['articles.id'=>$d['article_id']])
//                            ->one();
//                        (new BaseAnalyze())->writeToAnal("aaaaaaaaaaa:".var_export($ret,true));
//                        if($ret){
//                            (new BaseAnalyze())->writeToAnal("bbbbbbbbbb:".$ret['headmaster_id']);
//                            (new Articles())->pushReplyForEva($d['article_id'], $ret['headmaster_id'], $d['contents']);
//                        }*/
//                        //建超原来的，能推送给老师
//                        //(new Articles())->pushReplyForEva($d['article_id'], $receiver->reciever_id, $d['contents']);
//                        //推送给被回复人
//
//
//                        /*张亮说先暂时不要回复的推送了$query = new Query();
//                        $receive_user  = $query->select('id,token,school_id,token_type,class_id,cat_default_id')->from('customs')->where(['id'=>$d['reply_id']])->one();
//                        if($receive_user){
//                            //这里的class_id应该条评价记录的class_id
//                            $query = new Query();
//                            $pingjia = $query->select('id,class_id')->from('articles')->where(['id'=>$d['article_id']])->one();
//                            if($pingjia){
//                                $content_str = '65-'.$m->article_type_id.'-'.$d['article_id'].'-'.$receive_user['school_id'].'-'.$pingjia['class_id'].'-'.$receiver['reciever_id'];
//                                $ret = XgPush::PushSingleToken(['type'=>$content_str,'head'=>'','body'=>'收到新的评价:'.$d['contents']],$receive_user);
//                            }
//
//                        }*/
//                    }
//
//
//
//
//
//                } else {//文章回复
//                    /*张亮说先暂时不要回复的推送了if ($d['reply_id'] > 0 || $d['link_id'] > 0) {//如果是二级回复,只推送给reply_id指定的人
//                        //建超以前的 wfk!
//                        //(new Articles())->pushReplyReplyByArid($d['article_id'], $newid, $d['reply_id'], $d['contents']);
//                        $query = new Query();
//                        $receive_user  = $query->select('id,token,school_id,token_type,class_id,cat_default_id')->from('customs')->where(['id'=>$d['reply_id']])->one();
//                        if($receive_user){
//                            $content_str = '65-73-'.$newid.'-'.$receive_user['school_id'].'-'.$receive_user['class_id'].'-'.$receive_user['id'];
//                            $ret = XgPush::PushSingleToken(['type'=>$content_str,'head'=>'','body'=>'文章新回复:'.$d['contents']],$receive_user);
//                            //die(var_export($ret,true));
//                        }
//
//                    } else {
//                    	(new BaseAnalyze())->writeToAnal('reply()');
//                        (new Articles())->pushReplyByArid($d['article_id'], $newid, $d['contents']);
//                        //(new BaseAnalyze())->writeToAnal(var_export(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT,5),true));
//                    }*/
//                }
//            }
        } else {
            $ErrCode = HintConst::$ReplyNoData;
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    protected function addNew($d)
    {
        $d['repliers_id'] = $this->getCustomId();
        $d['ispassed'] = HintConst::$YesOrNo_YES;
        $d['isview'] = $d['isdelete'] = HintConst::$YesOrNo_NO;
        $d['createtime'] = CommonFun::getCurrentDateTime();
        $vote = new self();
        foreach ($d as $k => $v) {
            $vote->$k = $v;
        }
        $vote->save(false);
        return $vote->attributes['id'];
    }
    public function ReplyList()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $page_size = Yii::$app->request->get('size') ? Yii::$app->request->get('size') : 10;
        $start_line = $page_size * ($page - 1);
        if ($id == 0) {
            $result = ['ErrCode' => 1, 'Message' => '文章ID不存在', 'Content' => []];
            return json_encode($result);
        }
        //得到文章 判断用户角色 根据角色取不同的回复
        $article = Articles::findOne($id);
        if (isset($article->id)) {
            Yii::$app->session['article_id'] = $article->id;
            $user_id = $this->getCustomId();
            $user_role_id = $this->getCustomRole();
            $mc_name = $this->getMcName() . 'ReplyList' . $user_id . $id . $page . $page_size;
            if ($val = $this->mc->get($mc_name)) {
                $result = $val;
            } else {
                $query = new Query();
                $reply_list = $query->select($this->reply_list)
                    ->distinct()
                    ->from('article_replies as ar')
                    ->leftjoin('customs', 'customs.id = ar.repliers_id')
                    ->leftjoin('customs as c', 'c.id = ar.reply_id')
                    ->leftJoin('article_send_revieve as sr', 'sr.article_id=ar.article_id');
                if ($user_role_id == HintConst::$ROLE_HEADMASTER || ($article->author_id == $user_id && $user_role_id == HintConst::$ROLE_TEACHER) || (($article->article_type_id == HintConst::$YUEPINGJIA_PATH || $article->article_type_id == HintConst::$NIANPINGJIA_PATH) && $this->getCustomRole() == HintConst::$ROLE_PARENT)) {  //可以查看全部回复及回复的回复:园长;老师是作者; 发给家长的评价
                    $reply_list = $query->where(['ar.article_id' => $id, 'ar.link_id' => 0, 'ar.reply_id' => 0]);
                } else {
                    $reply_list = $query->where(['ar.article_id' => $id, 'ar.repliers_id' => $user_id, 'ar.link_id' => 0, 'ar.reply_id' => 0])
                        ->orWhere(['ar.article_id' => $id, 'sr.role' => CatDef::$obj_cat['parent'], 'sr.reciever_id' => $user_id, 'ar.link_id' => 0, 'ar.reply_id' => 0]);
                }
                $reply_list = $query->orderby(['ar.id' => SORT_ASC])
                    ->offset($start_line)
                    ->limit($page_size)
                    ->all();
                if ($reply_list) {
                    foreach ($reply_list as $key => $value) {
                        $query = new Query();
                        $reply_list[$key]['reply_list'] = $query->select($this->reply_list)
                            ->from('article_replies as ar')
                            ->leftjoin('customs', 'customs.id = ar.repliers_id')
                            ->leftjoin('customs as c', 'c.id = ar.reply_id')
                            ->where(['ar.article_id' => $id, 'ar.link_id' => $value['id']]);
                        $reply_list[$key]['reply_list'] = $reply_list[$key]['reply_list']->orderby(['ar.id' => SORT_ASC])
                            ->all();
                    }
                }
                $result = ['ErrCode' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $reply_list];
                $this->mc->add($mc_name, $result);
            }
            return json_encode($result);
        } else {
            Yii::$app->session['article_id'] = 0;
            $result = ['ErrCode' => 1, 'Message' => '文章不属于该用户下', 'Content' => []];
            return json_encode($result);
        }
    }
    protected function  checkReply($article_id)
    {
        $mo = self::find()
            ->where(['article_id' => $article_id, 'repliers_id' => $this->getCustomId()])
            ->one();
        if ($mo !== null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
