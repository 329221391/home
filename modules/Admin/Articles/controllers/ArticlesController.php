<?php

namespace app\modules\Admin\Articles\controllers;
use app\modules\Admin\Articles\models\ArticleAttachment;
use app\modules\Admin\Articles\models\ArticleReplies;
use app\modules\Admin\Articles\models\Articles;
use app\modules\Admin\Articles\models\ArticleSendRevieve;
use app\modules\Admin\Articles\models\ArticlesFav;
use app\modules\Admin\Articles\models\ArticlesSearch;
use app\modules\Admin\Articles\models\ClassesDaily;
use app\modules\Admin\Articles\models\CookbookInfo;
use app\modules\Admin\Articles\models\CustomsDaily;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Message\models\Messages;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\appbase\TransAct;
use Yii;
use yii\db\Query;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\modules\AppBase\base\appbase\BaseAnalyze;
/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends BaseController
{
    public $layout = 'main';
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                ],
//            ],
//        ];
//    }
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new ArticlesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

//================================================================================================================================================================
//===========================界面显示==========================================================================================================================
//================================================================================================================================================================    /**
    // 园长首页红点提示
    public function actionIndexDisplay()
    {
        $user_id = Yii::$app->session['custominfo']->custom->id;
        $school_id = Yii::$app->session['custominfo']->custom->school_id;
        $result = ['ywxg' => 0, 'dswz' => 0, 'pending_pic' => 0, 'pending_eva' => 0, 'ysq' => 0, 'sx' => 0]; //与我相关  待审文章  院所圈  私信
        //检查自己发表的文章是不是有新回复
        $query = new \yii\db\Query();
        $check_wz_reply = $query->select('count(*) as number')
            ->from('article_replies')
            ->leftjoin('articles', 'article_replies.article_id = articles.id')
            ->where(['articles.author_id' => $user_id, 'articles.article_type_id' => HintConst::$ARTICLE_PATH, 'article_replies.isview' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->one();
        if ($check_wz_reply['number'] > 0) {
            $result['ywxg'] = $check_wz_reply['number'];
        }
        //检查 是不是有新的待审核文章
        $query = new \yii\db\Query();
        $check_dsh = $query->select('count(*) as number')
            ->from('articles')
            ->where(['articles.school_id' => $school_id, 'ispassed' => HintConst::$YesOrNo_NO, 'isdelete' => HintConst::$YesOrNo_NO, 'article_type_id' => HintConst::$ARTICLE_PATH])
            ->one();
        if ($check_dsh['number'] > 0) {
            $result['dswz'] = $check_dsh['number'];
        }
        //pinding_pic  and pinding_eva
        $article_att = new ArticleAttachment();
        $result['pending_pic'] = $article_att->PendingPic();
        $article = new Articles();
        $result['pending_eva'] = $article->PendingEva();
        //院所圈是不是有新文章发布
        $query = new \yii\db\Query();
        $check_ysq = $query->select('count(*) as number')
            ->from('articles')
            ->where('(article_type_id=.' . HintConst::$ARTICLE_PATH . ') and school_id=' . $school_id . ' and ispassed=' . HintConst::$YesOrNo_YES . ' and isview=' . HintConst::$YesOrNo_NO)
            ->one();
        if ($check_ysq['number'] > 0) {
            $result['ysq'] = $check_ysq['number'];
        }
        //检查是不是有新私信
        $query = new \yii\db\Query();
        $check_sx = $query->select('count(*) as number')
            ->from('msg_send_recieve')
            ->where(['reciever_id' => $user_id, 'isreaded' => HintConst::$YesOrNo_NO])
            ->one();
        if ($check_sx['number'] > 0) {
            $result['sx'] = $check_sx['number'];
        }
        //通知
//        $note = new Notes();
        $result['note'] = 0;
        $result2 = ['ErrCode' => '0', 'Message' => HintConst::$WEB_JYQ, 'Content' => $result];
        return (json_encode($result2));
    }
    //老师首页红点提示
    public function actionDisplayPoint()
    {
        $user_id = Yii::$app->session['custominfo']->custom->id;
        $school_id = Yii::$app->session['custominfo']->custom->school_id;
        $result = ['ywxg' => 0, 'ysq' => 0, 'sx' => 0]; //与我相关  待审文章  院所圈
        //检查自己发表的文章是不是有新回复
        $query = new \yii\db\Query();
        $check_wz_reply = $query->select('count(*) as number')
            ->from('article_replies')
            ->leftjoin('articles', 'article_replies.article_id = articles.id')
            ->where(['articles.article_type_id' => HintConst::$ARTICLE_PATH, 'articles.author_id' => $user_id, 'article_replies.isview' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->one();
        if ($check_wz_reply['number'] > 0) {
            $result['ywxg'] = $check_wz_reply['number'];
        }
        //院所圈是不是有新文章指定给自己
        $query = new \yii\db\Query();
        $check_ysq = $query->select('count(*) as number')
            ->from('article_send_revieve')
            ->leftjoin('articles', 'article_send_revieve.article_id = articles.id')
            ->where(['articles.article_type_id' => HintConst::$ARTICLE_PATH, 'article_send_revieve.reciever_id' => $user_id, 'article_send_revieve.isread' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->one();
        if ($check_ysq['number'] > 0) {
            $result['ysq'] = $check_ysq['number'];
        }
        //检查是不是有新私信
        $query = new \yii\db\Query();
        $check_sx = $query->select('count(*) as number')
            ->from('msg_send_recieve')
            ->where(['reciever_id' => $user_id, 'isreaded' => HintConst::$YesOrNo_NO])
            ->one();
        if ($check_sx['number'] > 0) {
            $result['sx'] = $check_sx['number'];
        }
        //通知
//        $note = new Notes();
        $result['note'] = 0;
        $result2 = ['ErrCode' => '0', 'Message' => HintConst::$WEB_JYQ, 'Content' => $result];
        return (json_encode($result2));
    }
    //家长首页红点提示
    public function actionJiazhangPoint()
    {
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : Yii::$app->session['custominfo']->custom->id;
        //$user_id = Yii::$app->session['custominfo']->custom->id;
        $school_id = Yii::$app->session['custominfo']->custom->school_id;
        //初始化已读最大数组
        $max_arr = ['article_max_id' => 0, 'reply_max_id' => 0, 't_message_max_id' => 0, 'm_message_max_id' => 0, 'pingjia_max_id' => 0];
        $msg = ['headmaster' => 0, 'teacher' => 0]; //私信 园长  和  家长
        $article = ['circle' => 0, 'evaluation' => 0, 'hf_num' => 0]; //文章的数量 和 回复数
        //院所圈是不是有新文章指定给自己
        $query = new \yii\db\Query();
        $check_ysq = $query->select('*')
            ->from('article_send_revieve asr')
            ->leftjoin('articles', 'asr.article_id = articles.id')
            ->where(['articles.article_type_id' => HintConst::$ARTICLE_PATH, 'asr.reciever_id' => $user_id, 'asr.isread' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->andwhere(['>', 'articles.id', Yii::$app->session['custominfo']->custom->article_max_id]);
        $max_query = clone $query;
        $max_arr['article_max_id'] = $max_query->max('articles.id');
        $num = $query->count();
        $article['circle'] = $num;
        //检查回复是不是有新的
        $query = new \yii\db\Query();
        $check_hf_num = $query->select('*')
            ->from('article_replies as ar')
            ->leftjoin('articles', 'ar.article_id = articles.id')
            ->where(['articles.article_type_id' => HintConst::$ARTICLE_PATH, 'ar.reply_id' => $user_id, 'ar.isview' => HintConst::$YesOrNo_NO, 'ar.ispassed' => HintConst::$YesOrNo_YES, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->andwhere(['>', 'ar.id', Yii::$app->session['custominfo']->custom->reply_max_id]);
        $max_query = clone $query;
        $max_arr['reply_max_id'] = $max_query->max('ar.id');
        $num = $query->count();
        $article['hf_num'] = $num;
        //院所圈是不是有新的评价指定给自己
        $query = new \yii\db\Query();
        $check_ysq = $query->select('*')
            ->from('article_send_revieve as ars')
            ->leftjoin('articles', 'ars.article_id = articles.id')
            ->where(['and', 'ars.reciever_id=' . $user_id, 'articles.ispassed=' . HintConst::$YesOrNo_YES, 'ars.isread=' . HintConst::$YesOrNo_NO, 'articles.isdelete=' . HintConst::$YesOrNo_NO, ['or', 'articles.article_type_id=' . HintConst::$NIANPINGJIA_PATH, 'articles.article_type_id=' . HintConst::$YUEPINGJIA_PATH]])
            ->andwhere(['>', 'articles.id', Yii::$app->session['custominfo']->custom->reply_max_id]);
        $max_query = clone $query;
        $max_arr['pingjia_max_id'] = $max_query->max('articles.id');
        $num = $query->count();
        $article['evaluation'] = $num;
        //检查 园长的新私信
        $query = new \yii\db\Query();
        $check_sx = $query->select('*')
            ->from('msg_send_recieve as msr')
            ->leftjoin('customs', 'customs.id=msr.sender_id')
            ->where(['customs.cat_default_id' => HintConst::$ROLE_HEADMASTER, 'msr.reciever_id' => $user_id, 'msr.isreaded' => HintConst::$YesOrNo_NO])
            ->andwhere(['>', 'msr.id', Yii::$app->session['custominfo']->custom->m_message_max_id]);
        $max_query = clone $query;
        $max_arr['m_message_max_id'] = $max_query->max('msr.id');
        $num = $query->count();
        $msg['headmaster'] = $num;
        //检查 老师的新私信
        $query = new \yii\db\Query();
        $check_sx = $query->select('count(*) as number')
            ->from('msg_send_recieve as msr')
            ->leftjoin('customs', 'customs.id=msr.sender_id')
            ->where(['customs.cat_default_id' => HintConst::$ROLE_TEACHER, 'msr.reciever_id' => $user_id, 'msr.isreaded' => HintConst::$YesOrNo_NO])
            ->andwhere(['>', 'msr.id', Yii::$app->session['custominfo']->custom->t_message_max_id]);
        $max_query = clone $query;
        $max_arr['t_message_max_id'] = $max_query->max('msr.id');
        $num = $query->count();
        $msg['teacher'] = $num;
//        $custom = new Customs;
//        $custom->update_max($user_id, $max_arr);
        //通知
//        $note = new Notes();
        $re = ['msg' => $msg, 'article' => $article, 'note' => 0];
        $result = ['ErrCode' => '0', 'Message' => HintConst::$WEB_JYQ, 'Content' => $re];
        return (json_encode($result));
    }



//================================================================================================================================================================
//===========================文章操作==========================================================================================================================
//================================================================================================================================================================    /**
    //add praise
    public function actionAddpraise()
    {
        return  (new Articles())->AddAHE(CatDef::$mod['praise']);
    }
    //add letter
    public function actionAddletter()
    {
        return  (new Articles())->AddAHE(CatDef::$mod['letter']);
    }
    public function actionAddhigh()
    {
        $article = new Articles();
        $result = $article->AddAHE(HintConst::$HIGHLIGHT_PATH_NEW);
        return ($result);
    }
    //发表文章
    public function actionAddar()
    {
        $article = new Articles();
        $result = $article->AddAHE(HintConst::$ARTICLE_PATH);
        return ($result);
    }
    //发表学期总结(学期评价)
    public function actionAddtermeva()
    {
        $article = new Articles();
        $result = $article->AddAHE(HintConst::$NIANPINGJIA_PATH);
        return ($result);
    }
    //发表月总结(月评价)
    public function actionAddmoneva()
    {
        $article = new Articles();
        $result = $article->AddAHE(HintConst::$YUEPINGJIA_PATH);
        return ($result);
    }
    //家长端发布月评价
    public function actionAddMonevaParent(){
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$WEB_JYQ;
        $Content = HintConst::$NULLARRAY;
        $d['article_type_id'] = HintConst::$YUEPINGJIA_PATH;
        $d['o_link_id'] = isset($_REQUEST['o_link_id']) ? $_REQUEST['o_link_id'] : 0;
        $d['sub_type_id'] = isset($_REQUEST['sub_type_id']) ? $_REQUEST['sub_type_id'] : 0;
        $d['title'] = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $d['contents'] = isset($_REQUEST['contents']) ? $_REQUEST['contents'] : '';
        $role = isset($_REQUEST['role']) ? $_REQUEST['role'] : 0;
        $school = isset($_REQUEST['school']) ? $_REQUEST['school'] : 0;
        $class = isset($_REQUEST['class']) ? $_REQUEST['class'] : 0;
        $user = isset($_REQUEST['user']) ? $_REQUEST['user'] : 0;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;

        if (empty($d['title'])) {
            $ErrCode = HintConst::$No_title;
        } elseif (empty($d['contents'])) {
            $ErrCode = HintConst::$NoContents;
        } else {

        }
    }
    //家长端发布年评价
    public function actionAddTermevaParent(){
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$WEB_JYQ;
        $Content = HintConst::$NULLARRAY;
        $d['article_type_id'] = HintConst::$NIANPINGJIA_PATH;
        $d['o_link_id'] = isset($_REQUEST['o_link_id']) ? $_REQUEST['o_link_id'] : 0;
        $d['sub_type_id'] = isset($_REQUEST['sub_type_id']) ? $_REQUEST['sub_type_id'] : 0;
        $d['title'] = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $d['contents'] = isset($_REQUEST['contents']) ? $_REQUEST['contents'] : '';
        $role = isset($_REQUEST['role']) ? $_REQUEST['role'] : 0;
        $school = isset($_REQUEST['school']) ? $_REQUEST['school'] : 0;
        $class = isset($_REQUEST['class']) ? $_REQUEST['class'] : 0;
        $user = isset($_REQUEST['user']) ? $_REQUEST['user'] : 0;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;


    }
    //发表文章  和  发表  瞬间---原来的
    public function actionCreate()
    {
        $article_type_id = HintConst::$ARTICLE_PATH;
        $sub_type_id = isset($_REQUEST['sub_type_id']) ? $_REQUEST['sub_type_id'] : 0;
        if ($sub_type_id > 0) {
            $article_type_id = HintConst::$HIGHLIGHT_PATH_NEW; //精彩瞬间标识
        }
        //检查如果存在class_id  就根据class_id取得班级下学生列表 以及老师的id
        $class_id = isset($_REQUEST['class_id']) && trim($_REQUEST['class_id']) <> '' ? trim($_REQUEST['class_id']) : 0;
        if ($class_id) {
            $class_arr = explode(',', $class_id);
            $stu_list = array();
            if (is_array($class_arr) && count($class_arr)) {
                foreach ($class_arr as $key => $value) {
                    $query = new \yii\db\Query();
                    $list = $query->select('id')->from('customs')->where(['class_id' => $value, 'cat_default_id' => HintConst::$ROLE_PARENT, 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO])->column();
                    $stu_list = array_merge($stu_list, $list);
                    //加上老师的ID
                    $teacher = $query->select('teacher_id')->from('classes')->where(['id' => $value, 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO])->column();
                    $stu_list = array_merge($stu_list, $teacher);
                    if (is_array($stu_list) && count($stu_list) < 1) {
                        $result = ['ErrCode' => '1', 'Message' => '该班级下没有学生，发了也白发，别发了', 'Content' => ''];
                        return (json_encode($result));
                    }
                }
                $_REQUEST['send_to'] = isset($_REQUEST['send_to']) ? $_REQUEST['send_to'] . ',' . implode(',', $stu_list) : implode(',', $stu_list);
            }
        }
        //all_teacher == 234234234  家长
        //all_parent == 122222 老师
        $school_id = Yii::$app->session['custominfo']->custom->school_id;
        $all_teacher = isset($_REQUEST['all_teacher']) && is_numeric($_REQUEST['all_teacher']) ? $_REQUEST['all_teacher'] : 0;
        $all_parent = isset($_REQUEST['all_parent']) && is_numeric($_REQUEST['all_parent']) ? $_REQUEST['all_parent'] : 0;
        if ($all_teacher) {
            $query = new \yii\db\Query();
            $list = $query->select('id')->from('customs')->where(['school_id' => $school_id, 'cat_default_id' => HintConst::$ROLE_TEACHER, 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO])->column();
            $_REQUEST['send_to'] = isset($_REQUEST['send_to']) ? $_REQUEST['send_to'] . ',' . implode(',', $list) : implode(',', $list);
        }
        if ($all_parent) {
            $query = new \yii\db\Query();
            $list = $query->select('id')->from('customs')->where(['school_id' => $school_id, 'cat_default_id' => HintConst::$ROLE_PARENT, 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO])->column();
            $_REQUEST['send_to'] = isset($_REQUEST['send_to']) ? $_REQUEST['send_to'] . ',' . implode(',', $list) : implode(',', $list);
        }
        $send_to = isset($_REQUEST['send_to']) ? trim($_REQUEST['send_to']) : 0;
        // 检查send_to格式
        $check_send_to = $this->chekc_send_to($send_to);
        if (!$check_send_to) {
            $result = ['ErrCode' => '1', 'Message' => 'send_to参数格式错误。例：1,2,3,4,5', 'Content' => ''];
            return (json_encode($result));
        }
        $insert_result = $this->addarticle($article_type_id, $sub_type_id);
        if ($insert_result) {
            $result = ['ErrCode' => '0', 'Message' => '上传成功', 'Content' => $insert_result];
            return (json_encode($result));
        } else {
            $result = ['ErrCode' => '1', 'Message' => '缺少参数', 'Content' => ''];
            return (json_encode($result));
        }
    }
    /**
     *批量上传图片
     */
    public function actionMulUpload()
    {
        return (new ArticleAttachment())->MulUpload();
    }
    /**
     *删除文章
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $mod = isset($_REQUEST['mod']) ? trim($_REQUEST['mod']) : '';
        //拆分id
        $id = explode(',', $id);
        $id = array_filter($id);//过滤为空的值
        $id = array_unique($id);//过滤重复的值
        if (count($id) > 0) {
            foreach ($id as $key => $value) {

            	$art_id = $value;

            	$query = new Query();
	        	$article = $query->select('id,author_id,article_type_id,title')->from('articles')->where(['id'=>$art_id])->one();
	        	if(!$article){
	        		return 'error';
	        	}
	        	
	            $query = new Query();
	            //一级回复列表
	            $reply_list = $query->select('id')->from('article_replies')->where(['article_id'=>$art_id])->all();
	            $replyObj = new ArticleReplies();

	            foreach ($reply_list as $row) {
	                $query = new Query();
	                $connection = \Yii::$app->db;

        			//删除积分记录,排除园长加分
        			$table_name  = 'custom_score_'.($this->getCustomSchool_id() % 10);
        			$command = $connection->createCommand("delete from $table_name where pri_type_id=".CatDef::$act['reply']." and related_id=".$row['id']." and p_s_type_id <> 1  and sub_type_id=".$article['article_type_id']);
        			$command->execute();
	            }


	            $table_name  = 'custom_score_'.($this->getCustomSchool_id() % 10);//$this->getTenMod($this->getCustomSchool_id());
	            
	            //$sql = "DELETE FROM articles WHERE id=$art_id";
	            //$sql2 = "DELETE FROM article_attachment WHERE article_id=$art_id";
	            $sql3 = "DELETE FROM article_replies WHERE article_id=$art_id";
	            $sql4 = "DELETE FROM article_send_revieve WHERE article_id=$art_id";

	            $sql5 = "delete from $table_name where pri_type_id=".CatDef::$act['create']." and related_id=$art_id and p_s_type_id <> 1  and sub_type_id=".$article['article_type_id'];
	            
	            $ErrCode = (new TransAct())->trans($sql3, $sql4,$sql5);

                $model = $this->findModel($value);
                $model->isdelete = HintConst::$YesOrNo_YES;
                $model->save();
                //把相关的附件也删除
                $article_a = new ArticleAttachment;
                $article_a->deleteAll('article_id = ' . $value);

                if($mod == 'audit'){
                    $receiver_id = $article['author_id'];
                    $type = $article['article_type_id'];
                    $message = '您的内容审核未通过，已被删除';
                    if($type == HintConst::$ARTICLE_PATH){
                        $message = '您发布的文章【'.$article['title'].'】未通过审核，已被删除';
                    }elseif($type == HintConst::$YUEPINGJIA_PATH){
                        $message = '您发布的月评价【'.$article['title'].'】未通过审核，已被删除';
                    }elseif($type == HintConst::$NIANPINGJIA_PATH){
                        $message = '您发布的学期总结【'.$article['title'].'】未通过审核，已被删除';
                    }elseif($type == HintConst::$HIGHLIGHT_PATH_NEW){
                        $message = '您发布的图片【'.$article['title'].'】未通过审核，已被删除';
                    }
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
        } else {
            $result = ['ErrCode' => '1', 'Message' => '缺少ID参数', 'Content' => ''];
            return (json_encode($result));
        }
        $result = ['ErrCode' => '0', 'Message' => '删除成功', 'Content' => ''];
        return (json_encode($result));
    }
    //审核文章
    public function actionReview()
    {
        return (new Articles())->Review();
    }
    //家长的文章列表
    public function actionJarticleList()
    {
        return (new Articles())->JarticleList();
    }
    //家长的文章 是不是有新文章
    public function actionIfJarticle()
    {
        $user_id = Yii::$app->session['custominfo']->custom->id; //得到session登录用户的session信息的id
        $school_id = Yii::$app->session['custominfo']->custom->school_id; //得到session登录用户的session信息的id
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $start_line = $page_size * ($page - 1);
        $query = new \yii\db\Query();
        $p_list = $query->select('articles.*,customs.name_zh as author_name,customs.cat_default_id as author_role_id,c.name_zh as author_role_name')
            ->from('articles')
            ->leftjoin('article_send_revieve', 'article_send_revieve.article_id = articles.id')
            ->leftjoin('customs', 'article_send_revieve.sender_id = customs.id')
            ->leftjoin('cat_default as c', 'c.id = customs.cat_default_id')
            ->where(['article_send_revieve.reciever_id' => $user_id, 'articles.article_type_id' => HintConst::$ARTICLE_PATH, 'articles.isdelete' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'article_send_revieve.isread' => HintConst::$YesOrNo_NO])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        if ($p_list) {
            $server_host = $_SERVER['HTTP_HOST'];
            foreach ($p_list as $key => $value) {
                $p_list[$key]['thumb'] = !empty($p_list[$key]['thumb']) ? $server_host . '/' . $p_list[$key]['thumb'] : '';
                $p_list[$key]['att_list'] = $this->get_att_list($value['id']);
                $p_list[$key]['reply_list'] = (new Articles())->get_reply_list($value['id']);
            }
        }
        $result = ['ErrCode' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $p_list];
        return (json_encode($result));
    }
    //家长的与我相关 即是家长的回复有人又回复了
    public function actionRelateMe()
    {
        $article = new Articles();
        $result = $article->RelateMe();
        return ($result);
    }
    //老师的文章列表
    public function actionTeaArticleList()
    {
        $user_id = Yii::$app->session['custominfo']->custom->id; //得到session登录用户的session信息的id
        $school_id = Yii::$app->session['custominfo']->custom->school_id; //得到session登录用户的session信息的id
        $type_id = HintConst::$ARTICLE_PATH;
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $start_line = $page_size * ($page - 1);
        $query = new \yii\db\Query();
        $p_list = $query->select('articles.*,customs.name_zh as author_name,customs.cat_default_id as author_role_id,c.name_zh as author_role_name')
            ->distinct()
            ->from('articles')
            ->leftjoin('article_send_revieve', 'articles.id=article_send_revieve.article_id')
            ->leftjoin('customs', 'articles.author_id=customs.id')
            ->leftjoin('cat_default as c', 'customs.cat_default_id=c.id')
            ->where(['article_send_revieve.reciever_id' => $user_id, 'articles.school_id' => $school_id, 'articles.article_type_id' => $type_id, 'articles.isdelete' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES])
            ->orwhere(['article_send_revieve.sender_id' => $user_id, 'articles.school_id' => $school_id, 'articles.article_type_id' => $type_id, 'articles.isdelete' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        if ($p_list) {
            $server_host = $_SERVER['HTTP_HOST'];
            $ar_s_r = new ArticleSendRevieve();
            foreach ($p_list as $key => $value) {
                $p_list[$key]['thumb'] = $server_host . '/' . $p_list[$key]['thumb'];
                $p_list[$key]['att_list'] = $this->get_att_list($value['id']);
                //$p_list[$key]['reply_list'] =$this->get_reply_list($value['id'],2);
            }
        }
        //更新园长查看过的文章 及回复  保证园长操作首页的小红点是有效的
        $ar = new Articles();
        $ar->updateArticleIsView();
        $result = ['errorcod' => 0, 'messasge' => '', 'Content' => $p_list];
        return (json_encode($result));
    }
    //园长的文章列表
    public function actionArticleList()
    {
        $user_id = Yii::$app->session['custominfo']->custom->id; //得到session登录用户的session信息的id
        $school_id = Yii::$app->session['custominfo']->custom->school_id; //得到session登录用户的session信息的id
        $type_id = HintConst::$ARTICLE_PATH;
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $start_line = $page_size * ($page - 1);
        $query = new Query();
        $p_list = $query->select('articles.*,customs.name_zh as author_name,customs.cat_default_id as author_role_id,c.name_zh as author_role_name')
            ->from('articles')
            ->leftjoin('customs', 'articles.author_id=customs.id')
            ->leftjoin('cat_default as c', 'customs.cat_default_id=c.id')
            ->where(['articles.article_type_id' => $type_id, 'articles.school_id' => $school_id, 'articles.isdelete' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        if ($p_list) {
            $server_host = $_SERVER['HTTP_HOST'];
            foreach ($p_list as $key => $value) {
                $p_list[$key]['thumb'] = $server_host . '/' . $p_list[$key]['thumb'];
                $p_list[$key]['att_list'] = $this->get_att_list($value['id']);
                $p_list[$key]['reply_list'] = (new Articles())->get_reply_list($value['id']);
            }
        }
        //更新园长查看过的文章 及回复  保证园长操作首页的小红点是有效的
        Articles::updateAll(['isview' => HintConst::$YesOrNo_YES], 'school_id = ' . $school_id . ' and article_type_id = ' . HintConst::$ARTICLE_PATH . ' and articles.ispassed = ' . HintConst::$YesOrNo_YES);
        $result = ['errorcod' => 0, 'messasge' => '', 'Content' => $p_list];
        return (json_encode($result));
    }
    //回复指定文章
    public function actionArticleReply()
    {
        return (new ArticleReplies())->Reply();
    }
    //回复指定回复
    public function actionReplyReply()
    {
        return (new ArticleReplies())->Reply();
    }
    //yuanzhang 未通过文章列表
    public function actionUnpassedList()
    {
        $school_id = Yii::$app->session['custominfo']->custom->school_id; //得到session登录用户的session信息的id
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) && is_numeric($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $start_line = $page_size * ($page - 1);
        $query = new \yii\db\Query();
        $article_list = $query->select('articles.*,classes.name as class_name,customs.name_zh as author_name')
            ->from('articles')
            ->leftJoin('classes', 'articles.class_id = classes.id')
            ->leftJoin('customs', 'articles.author_id = customs.id')
            ->where(['articles.school_id' => $school_id, 'articles.article_type_id' => HintConst::$ARTICLE_PATH, 'articles.ispassed' => HintConst::$YesOrNo_NO, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        $result = ['errorcod' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $article_list];
        return (json_encode($result));
    }
    //quanbu获得指定文章的回复列表
    public function actionReplyList()
    {
        return (new ArticleReplies())->ReplyList();
    }
    public function more_reply()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $page_size = Yii::$app->request->get('size') ? Yii::$app->request->get('size') : 10;
        $start_line = $page_size * ($page - 1) + 5;
        $query = new \yii\db\Query();
        $reply_list = $query->select('article_replies.*,customs.name_zh as repliers_name,customs.cat_default_id as repliers_role_id,c.name_zh as reply_name,c.cat_default_id as reply_role_id')
            ->from('article_replies')
            ->leftjoin('customs', 'customs.id = article_replies.repliers_id')
            ->leftjoin('customs as c', 'c.id = article_replies.reply_id')
            ->where(['article_replies.link_id' => $id])
            ->orderby(['article_replies.id' => SORT_ASC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        $result = ['ErrCode' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $reply_list];
        return (json_encode($result));
    }
    //老师和家长获得指定文章的回复列表  已经有上面的方法 所以 这里就不用了
    public function actionReplyList2()
    {
        $id = isset($_REQUEST['article_id']) ? $_REQUEST['article_id'] : 0;
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $page_size = Yii::$app->request->get('size') ? Yii::$app->request->get('size') : 10;
        $start_line = $page_size * ($page - 1);
        if ($id == 0) {
            $result = ['ErrCode' => 1, 'Message' => 'ID不存在', 'Content' => HintConst::$NULLARRAY];
            return (json_encode($result));
        }
        $query = new \yii\db\Query();
        $article_list = $query->select('article_replies.*,customs.name_zh as repliers_name,customs.cat_default_id as repliers_role_id,c.name_zh as reply_name,c.cat_default_id as reply_role_id')
            ->from('article_replies')
            ->leftjoin('customs', 'customs.id = article_replies.repliers_id')
            ->leftjoin('customs as c', 'c.id = article_replies.reply_id')
            ->where(['article_replies.article_id' => $id, 'article_replies.link_id' => 0, 'article_replies.reply_id' => 0])
            ->orderby(['article_replies.id' => SORT_ASC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        if ($article_list) {
            foreach ($article_list as $key => $value) {
                $query = new \yii\db\Query();
                $article_list[$key]['reply_list'] = $query->select('article_replies.*,customs.name_zh as repliers_name,customs.cat_default_id as repliers_role_id,c.name_zh as reply_name,c.cat_default_id as reply_role_id')
                    ->from('article_replies')
                    ->leftjoin('customs', 'customs.id = article_replies.repliers_id')
                    ->leftjoin('customs as c', 'c.id = article_replies.reply_id')
                    ->where(['article_replies.article_id' => $id, 'article_replies.link_id' => $vv['id']])
                    ->orderby(['article_replies.id' => SORT_ASC])
                    ->offset(0)
                    ->limit(5)
                    ->all();
            }
        }
        $result = ['ErrCode' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $article_list];
        return (json_encode($result));
    }
    //得到我发表的文章 有人回复
    public function actionMyReply()
    {
        $custom_id = Yii::$app->session['custominfo']->custom->id;//得到session登录用户的session信息的id
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $page_size = Yii::$app->request->get('size') ? Yii::$app->request->get('size') : 10;
        $start_line = $page_size * ($page - 1);
        $query = new \yii\db\Query();
        $p_list = $query->select('article_replies.id as ar_id,article_replies.contents as reply_content,c.name_zh as reply_name,c.cat_default_id as reply_role_id,article_replies.createtime as reply_time,articles.*,customs.name_zh as author_name,customs.cat_default_id as author_role_id')
            ->from('articles')
            ->leftjoin('article_replies', 'articles.id = article_replies.article_id')
            ->leftjoin('customs', 'customs.id = articles.author_id')
            ->leftjoin('customs as c', 'c.id = article_replies.repliers_id')
            ->where(['articles.author_id' => $custom_id, 'article_replies.isview' => HintConst::$YesOrNo_NO, 'articles.article_type_id' => HintConst::$ARTICLE_PATH, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        //更新阅读状态
        foreach ($p_list as $key => $value) {
            ArticleReplies::updateall(['isview' => HintConst::$YesOrNo_YES], 'id = ' . $value['ar_id']);
        }
        $result = ['errorcod' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $p_list];
        return (json_encode($result));
    }
    //得到用户回复过的文章
    public function actionMyReply2()
    {
        $custom_id = Yii::$app->session['custominfo']->custom->id;//得到session登录用户的session信息的id
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $page_size = Yii::$app->request->get('size') ? Yii::$app->request->get('size') : 10;
        $start_line = $page_size * ($page - 1);
        $query = new \yii\db\Query();
        $p_list = $query->select('article_replies.id as ar_id,articles.*,customs.name_zh as replier_name,c.name_zh as reply_name')
            ->from('article_replies')
            ->leftjoin('customs', 'customs.id = article_replies.repliers_id')
            ->leftjoin('customs as c', 'c.id = article_replies.reply_id')
            ->leftjoin('articles', 'articles.id = article_replies.article_id')
            ->where(['article_replies.repliers_id' => $custom_id, 'articles.article_type_id' => HintConst::$ARTICLE_PATH, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        $result = ['errorcod' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $p_list];
        return (json_encode($result));
    }
    //园长得到文章详情  （去除了评论列表  谁都可以用该方法了）--原来的,不再使用了
    public function actionArticleDetail()
    {
        return (new Articles())->ArticleDetail();
    }
    //文章详情 --新的
    public function actionArtidetail()
    {
        return (new Articles())->Artidetail();
    }
    //学期评价详情 --新的
    public function actionTermdetail()
    {
        return (new Articles())->Artidetail();
    }
    //月评价详情 --新的
    public function actionMondetail()
    {
        return (new Articles())->Artidetail();
    }
    public function actionPraisedetail()
    {
        return (new Articles())->Artidetail();
    }
    public function actionLetterdetail()
    {
        return (new Articles())->Artidetail();
    }
    public function actionHighdetail()
    {
        return (new ArticleAttachment())->HighDetail();
    }

//================================================================================================================================================================
//===========================图片操作==========================================================================================================================
//================================================================================================================================================================
    //复核图片
    public function actionReviewPic()
    {
        return (new ArticleAttachment())->ReviewPic();
    }
    //删除图片
    public function actionDeletePic()
    {
        $id = Yii::$app->request->get('id');
        //拆分id
        $id = explode(',', $id);
        $id = array_filter($id);//过滤为空的值
        $id = array_unique($id);//过滤重复的值
        if (count($id) > 0) {
            foreach ($id as $key => $value) {
                $model = new ArticleAttachment();
                $article_a = $model->findOne($value);
                $article_a->isdelete = HintConst::$YesOrNo_YES;
                $article_a->save();
            }
        } else {
            $result = ['ErrCode' => 1, 'Message' => '没有id参数', 'Content' => ''];
            return (json_encode($result));
        }
        $result = ['ErrCode' => 0, 'Message' => '删除成功', 'Content' => ''];
        return (json_encode($result));
    }
    //yuanzhang 待审核图片列表
    public function actionUnpassedPic()
    {
        $school_id = Yii::$app->session['custominfo']->custom->school_id;//得到session登录用户的session信息的id
        $page = Yii::$app->request->post('page') ? Yii::$app->request->post('page') : 1;
        $page_size = Yii::$app->request->post('size') ? Yii::$app->request->post('size') : 10;
        $start_line = $page_size * ($page - 1);
        $query = new \yii\db\Query();
        $pic_list = $query->select('article_attachment.*,classes.name as class_name,customs.name_zh as author_name,articles.contents as img_desc')
            ->from('article_attachment')
            ->leftJoin('articles', 'articles.id = article_attachment.article_id')
            ->leftJoin('classes', 'classes.id = articles.class_id')
            ->leftJoin('customs', 'customs.id = articles.author_id')
            ->where(['articles.school_id' => $school_id, 'articles.article_type_id' => HintConst::$HIGHLIGHT_PATH_NEW, 'article_attachment.ispassed' => HintConst::$YesOrNo_NO, 'article_attachment.isdelete' => HintConst::$YesOrNo_NO])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        $server_host = $_SERVER['HTTP_HOST'];
        foreach ($pic_list as $key => $value) {
            $pic_list[$key]['url'] = $server_host . '/' . $value['url'];
            $pic_list[$key]['url_thumb'] = $server_host . '/' . $value['url_thumb'];
        }
        $result = ['errorcod' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $pic_list];
        return (json_encode($result));
    }
    //用户的收藏图片列表
    public function actionFavPic()
    {
        $fav = new ArticlesFav();
        $fav->setName('pic');
        $result = $fav->Fav();
        return $result;
    }
    //收藏图片
    public function actionAddFav()
    {
        $fav = new ArticlesFav();
        $fav->setName('pic');
        $result = $fav->addFav();
        return ($result);
    }
//================================================================================================================================================================
//===========================精彩瞬间操作==========================================================================================================================
//================================================================================================================================================================
    //添加瞬间详情  因为瞬间是可以用article create来完成  此处暂时无用
    public function actionAddJingcai()
    {
    }
    //得到瞬间liebiao
    public function actionJingcaiList()
    {
        $user_id = Yii::$app->session['custominfo']->custom->id; //得到session登录用户的session信息的id
        //$user_id = 2;
        $type_id = HintConst::$HIGHLIGHT_PATH_NEW;
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $page_size = Yii::$app->request->get('size') ? Yii::$app->request->get('size') : 10;
        $start_line = $page_size * ($page - 1);
        $query = new \yii\db\Query();
        $p_list = $query->select('articles.*,customs.name_zh as author_name,customs.cat_default_id as author_role_id')
            ->from('articles')
            ->leftjoin('article_send_revieve', 'article_send_revieve.article_id = articles.id')
            ->leftjoin('customs', 'article_send_revieve.sender_id = customs.id')
            ->where(['article_send_revieve.reciever_id' => $user_id, 'articles.article_type_id' => HintConst::$HIGHLIGHT_PATH_NEW, 'articles.isdelete' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        $result = ['errorcod' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $p_list];
        return (json_encode($result));
    }
    //ID得到瞬间详情
    public function actionJingcaiDetail()
    {
        $id = Yii::$app->request->get('article_id') ? Yii::$app->request->get('article_id') : 0;
        if ($id > 0) {
            $query = new \yii\db\Query();
            $model = $query->select('articles.*,customs.name_zh as author_name')
                ->from('articles')
                ->leftjoin('customs', 'customs.id = articles.author_id')
                ->where(['articles.id' => $id])
                ->one();
            $model['att_list'] = array();
            if (count($model) > 0 && is_array($model)) {
                $query = new \yii\db\Query();
                $model['att_list'] = $query->select('article_attachment.*,cat_default.name as cat_default_name')
                    ->from('article_attachment')
                    ->leftjoin('cat_default', 'article_attachment.cat_default_id = cat_default.id')
                    ->where(['article_attachment.article_id' => $model['id']])
                    ->all();
                $query = new \yii\db\Query();
                $model['reply_list'] = $query->select('article_replies.*,customs.name_zh as replier_name,customs.cat_default_id as replier_role_id,c.name_zh as reply_name,c.cat_default_id as reply_role_id')
                    ->from('article_replies')
                    ->leftjoin('customs', 'customs.id = article_replies.repliers_id')
                    ->leftjoin('customs as c', 'c.id = article_replies.reply_id')
                    ->where(['article_replies.article_id' => $model['id']])
                    ->all();
            }
            $result = json_encode(['ErrCode' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $model]);
            return ($result);
        } else {
            $result = json_encode(['ErrCode' => 1, 'Message' => '参数错误', 'Content' => '']);
            return ($result);
        }
    }
    //用户ID 和 日期 获取得到瞬间详情
    public function actionJingcaiDetail2()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Y-m-d');
        if ($id > 0 && $date) {
            $query = new \yii\db\Query();
            $model = $query->select('articles.*,customs.name_zh as author_name')
                ->from('articles')
                ->leftjoin('customs', 'customs.id = articles.author_id')
                ->leftjoin('article_send_revieve', 'article_send_revieve.article_id = articles.id')
                ->where(['articles.date' => $date, 'article_send_revieve.reciever_id' => $id, 'article.cat_type_id' => HintConst::$HIGHLIGHT_PATH_NEW])
                ->all();
            if (count($model) > 0 && is_array($model) && !empty($model)) {
                foreach ($model as $key => $value) {
                    $query = new \yii\db\Query();
                    $model[$key]['att_list'] = $query->select('article_attachment.*,cat_default.name as cat_default_name')
                        ->from('article_attachment')
                        ->leftjoin('cat_default', 'article_attachment.cat_default_id = cat_default.id')
                        ->where(['article_attachment.article_id' => $value['id']])
                        ->all();
                }
            }
            $result = json_encode(['ErrCode' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $model]);
            return ($result);
        } else {
            $result = json_encode(['ErrCode' => 1, 'Message' => '参数错误', 'Content' => '']);
            return ($result);
        }
    }
//================================================================================================================================================================
//===========================评价操作==========================================================================================================================
//================================================================================================================================================================
    //添加ri评价---分成了两个表,不用重写了
    public function actionAddPingjia3()
    {
        $result = ['ErrCode' => 0, 'Message' => '上传成功'];
        $custom_id = isset($_REQUEST['custom_id']) ? $_REQUEST['custom_id'] : 0;
        $class_id = Yii::$app->session['custominfo']->custom->class_id;
        $daily_type_id = isset($_REQUEST['daily_type_id']) ? $_REQUEST['daily_type_id'] : 0;
        $Contents = isset($_REQUEST['content']) ? $_REQUEST['content'] : 0;
        if ($daily_type_id == HintConst::$LABLE_LESSONS_PATH) {
            $lesson_arr = isset($_REQUEST['content']) ? $_REQUEST['content'] : 0;
            if (is_array($lesson_arr) && count($lesson_arr) > 0) {
                $Contents = implode(',', $lesson_arr);
            } else {
                $Contents = 0;
            }
        }
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Y-m-d');
        if (!$Contents) {
            $result = json_encode(['ErrCode' => 1, 'Message' => '没有提交日常内容', 'Content' => '']);
            return ($result);
        }
        if (!$daily_type_id) {
            $result = json_encode(['ErrCode' => 1, 'Message' => 'no daily_type_id', 'Content' => '']);
            return ($result);
        }
        //添加今日评价
        $query = new \yii\db\Query();
        if ($custom_id) {
            $c_daily = new CustomsDaily;
            $c_daily->custom_id = $custom_id;
            $c_daily->daily_contents = $Contents;
            $c_daily->daily_type_id = $daily_type_id;
            $c_daily->date = $date;
            $c_daily->createtime = date('Y-m-d H:i:s');
            //根据日期 和 类型 来查重
            $check_dup = $query->select('id')
                ->from('customs_daily')
                ->where(['date' => $date, 'daily_type_id' => $daily_type_id, 'custom_id' => $custom_id])
                ->one();
            if (isset($check_dup['id']) && $check_dup['id'] > 0) {
                CustomsDaily::updateAll(['daily_contents' => $Contents], 'date="' . $date . '" and daily_type_id = ' . $daily_type_id . ' and custom_id=' . $custom_id);
            } else {
                $c_daily->save();
            }
        } elseif ($class_id) {
            $c_daily = new ClassesDaily;
            $c_daily->class_id = $class_id;
            $c_daily->daily_contents = $Contents;
            $c_daily->daily_type_id = $daily_type_id;
            $c_daily->date = $date;
            $c_daily->createtime = date('Y-m-d H:i:s');
            //查重
            $check_dup = $query->select('id')
                ->from('classes_daily')
                ->where(['date' => $date, 'daily_type_id' => $daily_type_id, 'class_id' => $class_id])
                ->one();
            if (isset($check_dup['id']) && $check_dup['id'] > 0) {
                ClassesDaily::updateAll(['daily_contents' => $Contents], 'date="' . $date . '" and daily_type_id = ' . $daily_type_id . ' and class_id=' . $class_id);
            } else {
                $c_daily->save();
            }
        } else {
            $result = json_encode(['ErrCode' => 1, 'Message' => '缺少班级或学生id', 'Content' => '']);
            return ($result);
        }
        $result = json_encode(['ErrCode' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => '']);
        return ($result);
    }
    //添加月评价--原来
    public function actionAddPingjia()
    {
        $result = ['ErrCode' => 0, 'Message' => '上传成功', 'Content' => ''];
        if ($this->addarticle(HintConst::$YUEPINGJIA_PATH)) {
            return (json_encode($result));
        } else {
            $result = ['ErrCode' => 1, 'Message' => '缺少参数', 'Content' => ''];
            return (json_encode($result));
        }
    }
    //添学期评价--原来
    public function actionAddPingjia2()
    {
        $term = isset($_REQUEST['term']) && $_REQUEST['term'] > 0 ? $_REQUEST['term'] : 0;
        if ($term <= 0) {
            $result = ['ErrCode' => 1, 'Message' => '学期总结term参数不对', 'Content' => ''];
            return (json_encode($result));
        }
        if ($this->addarticle(HintConst::$NIANPINGJIA_PATH, 0, $term)) {
            $result = ['ErrCode' => 0, 'Message' => '发表成功', 'Content' => ''];
            return (json_encode($result));
        } else {
            $result = ['ErrCode' => 1, 'Message' => '缺少参数', 'Content' => ''];
            return (json_encode($result));
        }
    }
    //园长  获得待审核学期评价
    public function actionUnpassedPingjia()
    {
        $school_id = Yii::$app->session['custominfo']->custom->school_id; //得到session登录用户的session信息的id
        $article_type_id = isset($_REQUEST['type']) && is_numeric($_REQUEST['type']) && $_REQUEST['type'] == 1 ? HintConst::$YUEPINGJIA_PATH : HintConst::$NIANPINGJIA_PATH;
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) && is_numeric($_REQUEST['size']) ? $_REQUEST['size'] : 15;
        $start_line = $page_size * ($page - 1);
        $query = new \yii\db\Query();
        $article_list = $query->select('articles.*,classes.name as class_name,customs.name_zh as author_name,customs.cat_default_id as author_role_id,cat_default.name_zh as article_type_name,c.name_zh as stu_name,c.cat_default_id as stu_role_id')
            ->from('articles')
            ->leftJoin('article_send_revieve', 'articles.id = article_send_revieve.article_id')
            ->leftJoin('customs as c', 'c.id = article_send_revieve.reciever_id')
            ->leftJoin('classes', 'articles.class_id = classes.id')
            ->leftJoin('customs', 'articles.author_id = customs.id')
            ->leftJoin('cat_default', 'articles.article_type_id = cat_default.id')
            ->where(['articles.school_id' => $school_id, 'articles.article_type_id' => $article_type_id, 'articles.ispassed' => HintConst::$YesOrNo_NO, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->orderby(['articles.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        if ($article_list == false) {
            $article_list = array();
        }
        $result = ['errorcod' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $article_list];
        return (json_encode($result));
    }
    //得到 精彩瞬间 学期总结 月评价     ----老的成长历程--原来
    public function actionPingjiaList()
    {
        $article = new Articles();
        $result = $article->PingjiaList();
        return ($result);
    }
    //新的成长历程
    public function  actionNewgrow()
    {
        $article = new Articles();
        $result = $article->Newgrow();
        return ($result);
    }
    //根据ID得到评价详情
    public function actionPingjiaDetail()
    {
        $id = Yii::$app->request->get('id') ? Yii::$app->request->get('id') : 0;
        if ($id > 0) {
            $query = new \yii\db\Query();
            $model = $query->select('articles.*,customs.name_zh as author_name')
                ->from('articles')
                ->leftjoin('customs', 'customs.id = articles.author_id')
                ->where(['articles.id' => $id])
                ->one();
            $result = json_encode(['errorcod' => 0, 'Content' => $model]);
            if (!$model) {
                $result = json_encode(['errorcod' => 1, 'Message' => '没有相应的数据']);
            } else {
                $query = new \yii\db\Query();
                $model['reply_list'] = $query->select('article_replies.*,customs.name_zh as replier_name,customs.cat_default_id as replier_role_id,c.name_zh as reply_name,c.cat_default_id as reply_role_id')
                    ->from('article_replies')
                    ->leftjoin('customs', 'customs.id = article_replies.repliers_id')
                    ->leftjoin('customs as c', 'c.id = article_replies.reply_id')
                    ->where(['article_replies.article_id' => $model['id']])
                    ->all();
            }
            $result = json_encode(['ErrCode' => 0, 'Message' => HintConst::$WEB_JYQ, 'Content' => $model]);
            return ($result);
        } else {
            $result = json_encode(['ErrCode' => 7055, 'Message' => '参数错误', 'Content' => '']);
            return ($result);
        }
    }
    //根据用户ID和月份得到 月评价详情 -原来
    public function actionPingjiaDetail2()
    {
        $article = new Articles();
        $result = $article->PingjiaDetail2();
        return ($result);
    }
    //根据用户ID和月份得到 学期总结  -原来
    public function actionPingjiaDetail3()
    {
        $article = new Articles();
        $result = $article->PingjiaDetail3();
        return ($result);
    }
    //新 文章列表 -分页
    public function actionArti()
    {
        $article = new Articles();
        $result = $article->AEList(HintConst::$ARTICLE_PATH);
        return ($result);
    }
    public function actionPraise()
    {
        return  (new Articles())->AEList(CatDef::$mod['praise']);
    }
    public function actionLetter()
    {
        return  (new Articles())->AEList(CatDef::$mod['letter']);
    }
    //新 学期评价列表-分页
    public function actionTermeva()
    {
        $article = new Articles();
        $result = $article->AEList(HintConst::$NIANPINGJIA_PATH);
        return ($result);
    }
    //新 月评价列表-分页
    public function actionMoneva()
    {
        $article = new Articles();
        $result = $article->AEList(HintConst::$YUEPINGJIA_PATH);
        return ($result);
    }
    //家长得到今日动态
    public function actionDaySummary()
    {
        $article = new Articles();
        $result = $article->DaySummary();
        return ($result);
    }
    public function actionNewdaysummary()
    {
        $article = new Articles();
        $result = $article->Newdaysummary();
        return ($result);
    }
    //园长/老师得到今日动态(班级动态)
    public function actionDaySummary2()
    {
        $article = new Articles();
        $result = $article->DaySummary2();
        return ($result);
    }
    //园长修改 今日总结的食谱
    public function actionEditCook()
    {
        //检查是不是园长
        if (Yii::$app->session['custominfo']->custom->cat_default_id <> 207) {
            $result = ['ErrCode' => '1', 'Message' => '不是园长  不能修改食谱', 'Content' => ''];
            return (json_encode($result));
        }
        $user_id = Yii::$app->session['custominfo']->custom->id;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;
        $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : 0;
        $date = date('Y-m-d');
        $type_arr = ['breakfast', 'addone', 'lunch', 'addtwo', 'dinner'];
        if (!in_array($type, $type_arr)) {
            $result = ['ErrCode' => '1', 'Message' => '非法字段', 'Content' => ''];
            return (json_encode($result));
        }
        if ($type && $content) {
            CookbookInfo::updateAll([$type => $content], 'school_id=' . Yii::$app->session['custominfo']->custom->school_id . ' and date ="' . $date . '"');
            $result = ['ErrCode' => '0', 'Message' => '修改成功', 'Content' => ''];
            return (json_encode($result));
        } else {
            $result = ['ErrCode' => '1', 'Message' => '缺少参数', 'Content' => ''];
            return (json_encode($result));
        }
    }

//================================================================================================================================================================
//===========================函数==========================================================================================================================
//================================================================================================================================================================
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    //根据不同type添加文章de 函数
    protected function addarticle($cat_type_id = 0, $sub_type_id = 0, $term = 0)
    {
        $Arti = new Articles();
        $send_to = isset($_REQUEST['send_to']) ? $_REQUEST['send_to'] : 0;
        $Arti->school_id = Yii::$app->session['custominfo']->custom->school_id;
        $Arti->class_id = Yii::$app->session['custominfo']->custom->class_id;
        //如果是园长添加文章  则class_id随被指定人的class_id而定   //待定
        if (!$Arti->class_id || $Arti->class_id == null) {
            $send_arr = explode(',', $send_to);
            if (is_array($send_arr) && count($send_arr) > 0) {
                //去获取用户的班级信息
                foreach ($send_arr as $key => $value) {
                    $query = new \yii\db\Query();
                    $custom = $query->select('class_id')->from('customs')->where(['id' => $value])->one();
                    if (isset($custom['class_id']) && $custom['class_id'] > 0) {
                        $Arti->class_id = $custom['class_id'];
                        break;
                    }
                }
            }
        }
        $Arti->author_id = Yii::$app->session['custominfo']->custom->id;
        //拆分send_to
        $send_arr = explode(',', $send_to);
        $send_arr = array_filter($send_arr);//过滤为空的值
        $send_arr = array_unique($send_arr);//过滤重复的值
        //$Arti->for_someone_id =  implode(',',$send_arr);
        $Arti->contents = isset($_REQUEST['content']) ? trim($_REQUEST['content']) : '';
        $Arti->title = isset($_REQUEST['title']) ? trim($_REQUEST['title']) : substr($Arti->contents, 0, 20);
        $Arti->article_type_id = $cat_type_id;
        $Arti->sub_type_id = $sub_type_id;
        $Arti->date = date('Y-m-d');
        $Arti->createtime = date('Y-m-d H:i:s', time());
        $Arti->month = isset($_REQUEST['month']) && $_REQUEST['month'] > 0 ? $_REQUEST['month'] : date('Ym');
        $Arti->term = isset($term) && $term > 0 ? $term : date('Y');
        $Arti->ispassed = Yii::$app->session['custominfo']->custom->iscansend;
        $Arti->isdelete = HintConst::$YesOrNo_NO;
        $Arti->isview = HintConst::$YesOrNo_NO;
        $Arti->thumb = '';
        if ($send_to && $Arti->title <> '' && $Arti->contents <> '') {
            $file_name = $this->create_img($Arti->school_id, $Arti->class_id, 'images');  //上传图片 并记录文件名
            $Arti->thumb = $file_name <> '' ? $file_name . '.thumb.jpg' : '';
            //插入文章
            $Arti->save(false);
            if ($file_name <> '' && $file_name) {
                //插入图片到attament
                $Artia = new ArticleAttachment();
                $Artia->article_id = $Arti->attributes['id'];
                $Artia->cat_default_id = $Arti->article_type_id;
                $Artia->sub_type_id = $Arti->sub_type_id;
                $Artia->url = $file_name . '.jpg';
                $Artia->url_thumb = $file_name . '.thumb.jpg';
                $Artia->createtime = date('Y-m-d h:i:s');
                $Artia->ispassed = Yii::$app->session['custominfo']->custom->iscansend;
                $Artia->isdelete = HintConst::$YesOrNo_NO;
                $Artia->isview = HintConst::$YesOrNo_NO;
                $Artia->save(false);
            }
            $art_insert_id = $Arti->attributes['id'];
            //分发到每个用户send_reciev表
            foreach ($send_arr as $key => $value) {
                $Arti_sr = new ArticleSendRevieve();
                $Arti_sr->article_id = $art_insert_id;
                $Arti_sr->sender_id = Yii::$app->session['custominfo']->custom->id;//得到session登录用户的session信息的id
                $Arti_sr->reciever_id = $value;
                $Arti_sr->isread = HintConst::$YesOrNo_NO;
                $Arti_sr->createtime = date('Y-m-d h:i:s');
                $Arti_sr->save();
            }
            return $Arti->attributes['id'];
        } else {
            return false;
        }
    }
    //得到单条文章ID的att_list
    protected function get_att_list($article_id)
    {
        $att_list = array();
        if ($article_id > 0) {
            $query = new \yii\db\Query();
            $att_list = $query->select('article_attachment.*,cat_default.name as cat_default_name')
                ->from('article_attachment')
                ->leftjoin('cat_default', 'article_attachment.cat_default_id = cat_default.id')
                ->where(['article_attachment.article_id' => $article_id])
                ->orderby(['article_attachment.id' => SORT_DESC])
                ->all();
            if (is_array($att_list) && count($att_list) > 0) {
                $server_host = $_SERVER['HTTP_HOST'];
                foreach ($att_list as $key => $value) {
                    $att_list[$key]['url'] = $server_host . '/' . $att_list[$key]['url'];
                    $att_list[$key]['url_thumb'] = $server_host . '/' . $att_list[$key]['url_thumb'];
                }
            }
            return $att_list;
        } else {
            return $att_list;
        }
    }
    //检查send_to格式 是否正确
    protected function chekc_send_to($send_to)
    {
        if ($send_to) {
            $send_arr = explode(',', $send_to);
            if (is_array($send_arr) && count($send_arr) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //对上传的图片储存，生成缩略图，打上水印 然后返回文件名(不包括后缀)
    protected function create_img($school_id, $class_id, $images_lable)
    {
        if (!$school_id || !$class_id || !$images_lable) {
            $result = ['ErrCode' => '7477', 'Message' => '缺少参数', 'Content' => []];
            return (json_encode($result));
        }
        $thumb = UploadedFile::getInstanceByName($images_lable);
        if ($thumb) {
            $img_path = 'uploads/' . $school_id . '/' . $class_id . '/' . date('Y-m-d') . '/';
            if (!is_dir($img_path)) {
                if (BaseFileHelper::createDirectory($img_path)) {
                } else {
                    $result = ['ErrCode' => '7474', 'Message' => '权限不足，无法上传图片', 'Content' => []];
                    return (json_encode($result));
                }
            }
            $base_filename = rand(1000, 9999) . time();
            $pic_url = $img_path . $base_filename . '.jpg';
            $thumb->saveAs($pic_url);   //保存图片到指定路径
            //根据图片路径打上水印
            $query = new \yii\db\Query();
            $school = $query->select('name')->from('schools')->where(['id' => Yii::$app->session['custominfo']->custom->school_id])->one();//得到用户的学校名称
            $image_size = getimagesize($pic_url);
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
    }

//================================================================================================================================================================
//===========================家长的分享页面==========================================================================================================================
//================================================================================================================================================================
    public function  actionAddarshare()
    {
        $ar = new Articles();
        $result = $ar->Addarshare();
        return ($result);
    }
    public function  actionAddatshare()
    {
        $at = new ArticleAttachment();
        $result = $at->Addatshare();
        return ($result);
    }
    public function actionUserShare()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        if (!$id) {
            return ('得到参数错误');
        }
        //根据id得到文章里面的school——id  然后学校名称和电话就都有了
        $query = new \yii\db\Query();
        $article = $query->select('article_attachment.*,articles.contents')->from('article_attachment')
            ->leftjoin('articles', 'articles.id = article_attachment.article_id')
            ->where(['article_attachment.id' => $id])->one();
        if (isset($article['article_id']) && $article['article_id'] > 0) {
            $query = new \yii\db\Query();
            $school_info = $query->select('schools.*')
                ->from('schools')
                ->leftjoin('articles', 'articles.school_id = schools.id')
                ->where(['articles.id' => $article['article_id']])
                ->one();
            return $this->render('user_share', [
                'school_info' => $school_info,
                'article' => $article,
            ]);
        } else {
            return ('没有这张图片');
        }
    }


//================================================================================================================================================================
//===========================log文件上传==========================================================================================================================
//================================================================================================================================================================
    public function actionLogUpload()
    {
        $user_id = isset(Yii::$app->session['custominfo']->custom->id) ? Yii::$app->session['custominfo']->custom->school_id : 0;
        $log_file = UploadedFile::getInstanceByName('log');
        if ($log_file) {
            //检查文件大小 后缀
            //print_r($log_file);
            //检查文件后缀 是不是log
            if (strlen($log_file->name) - 4 !== strripos($log_file->name, '.log')) {
                $result = ['ErrCode' => '1', 'Message' => '文件只允许log结尾', 'CContent' => []];
                return (json_encode($result));
            }
            $log_path = 'log_files/' . $user_id . '/';
            if (!is_dir($log_path)) {
                if (BaseFileHelper::createDirectory($log_path)) {
                } else {
                    $result = ['ErrCode' => '7474', 'Message' => '目录权限不足，无法上传', 'Content' => []];
                    return (json_encode($result));
                }
            }
            $log = $log_path . $log_file->name;
            $log_file->saveAs($log);    //保存日志到指定路径
            $result = ['ErrCode' => '0', 'Message' => '上传成功', 'Content' => []];
            return (json_encode($result));
        }
    }

//================================================================================================================================================================
//===========================浏览器查看学生日总结==========================================================================================================================
//================================================================================================================================================================
//1.检查登录
//2.可选择不同日期
//
    public function actionDaily()
    {
        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : 0;
        if (!$user_id) {
            //检查用户  或   显示登录界面
            $user_name = isset($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : 0;
            $password = isset($_REQUEST['password']) ? trim($_REQUEST['password']) : 0;
            if ($user_name && $password) {
                //检查是不是正确
                $user = Customs::find()->asarray()
                    ->where(['phone' => $user_name, 'password' => md5($password)])
                    ->one();
                if ($user) {
                    // echo $user->id;
                    //发送cookies 登录成功
                    setcookie('user_name', $user_name);
                    setcookie('user_id', $user['id']);
                    header("Location:index.php?r=Articles%2Farticles%2Fdaily");
                } else {
                    //显示的路界面
                    return $this->render('user_login', ['wrong_num' => '密码错误']);
                }
            } else {
                //显示的路界面
                return $this->render('user_login');
            }
        }
        //根据id得到用户信息
        $user = Customs::find()->asarray()
            ->where(['id' => $user_id])
            ->one();
        //根据user_id 得到今日日程
        $custom_id = $user_id;
        $start_time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $type_id = HintConst::$HIGHLIGHT_PATH_NEW;
        $date = isset($_REQUEST['date']) && is_numeric($_REQUEST['date']) ? date('Y-m-d', $_REQUEST['date']) : date('Y-m-d');
        $query = new \yii\db\Query();
        $p_list = $query->select('customs_daily.*')
            ->from('customs_daily')
            ->where(['customs_daily.custom_id' => $custom_id, 'customs_daily.date' => $date])
            ->orderby(['customs_daily.daily_type_id' => SORT_ASC])
            ->all();
        $summary = ['eat' => '', 'sleep' => '', 'course' => '', 'outdoor' => '', 'lessons' => '', 'homework' => ''];
        if (count($p_list) > 0) {
            foreach ($p_list as $key => $value) {
                switch ($value['daily_type_id']) {
                    case HintConst::$HIGHLIGHT_EAT_NEW:
                        $summary['eat'] = $value['daily_contents'];
                        break;
                    case HintConst::$HIGHLIGHT_SLEEP_NEW:
                        $summary['sleep'] = $value['daily_contents'];
                        break;
                    case HintConst::$HIGHLIGHT_COURSE_NEW:
                        $summary['course'] = $value['daily_contents'];
                        break;
                    case HintConst::$HIGHLIGHT_OUTDOOR_NEW:
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
        //检查 $summary是否有空的选项 试图到班级daily中寻找
        //通过custom_id得到school_id  继而得到当前日的食谱。
        $class_summary = ['eat' => '', 'sleep' => '', 'course' => '', 'outdoor' => '', 'lessons' => '', 'homework' => ''];
        $query = new \yii\db\Query();
        $school = $query->select('class_id')->from('customs')->where(['id' => $custom_id])->one();
        if (isset($school["class_id"]) && $school["class_id"] > 0) {
            $class_id = isset($school["class_id"]) ? $school["class_id"] : 0;
            $query = new \yii\db\Query();
            $class_daily = $query->select('*')
                ->from('classes_daily')
                ->where(['class_id' => $class_id, 'date' => $date])
                ->all();
            if (count($class_daily) > 0 && is_array($class_daily)) {
                foreach ($class_daily as $key => $value) {
                    switch ($value['daily_type_id']) {
                        case HintConst::$HIGHLIGHT_EAT_NEW:
                            $class_summary['eat'] = $value['daily_contents'];
                            break;
                        case HintConst::$HIGHLIGHT_SLEEP_NEW:
                            $class_summary['sleep'] = $value['daily_contents'];
                            break;
                        case HintConst::$HIGHLIGHT_COURSE_NEW:
                            $class_summary['course'] = $value['daily_contents'];
                            break;
                        case HintConst::$HIGHLIGHT_OUTDOOR_NEW:
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
        //如果得到的用户日常值为空  则用班级日常代替  班级日常也是空  就没哟办法了
        foreach ($summary as $key => $value) {
            if ($value == '') {
                $summary[$key] = $class_summary[$key];
            }
        }
        //通过custom_id得到school_id  继而得到当前日的食谱。
        $query = new \yii\db\Query();
        $school = $query->select('school_id')->from('customs')->where(['id' => $custom_id])->one();
        if (is_array($school) && count($school) > 0) {
            $school_id = isset($school["school_id"]) ? $school["school_id"] : 0;
            if ($school_id > 0) {
                $summary['cook_book'] = array();
                $query = new \yii\db\Query();
                $summary['cook_book'] = $query->select('*')
                    ->from('cookbook_info')
                    ->where(['date' => $date, 'school_id' => $school_id])
                    ->one();
                if ($summary['cook_book'] == false) {
                    $summary['cook_book'] = array();
                }
            } else {
                $summary['cook_book'] = array();
            }
        } else {
            $summary['cook_book'] = array();
        }
        $summary['att_list'] = array();
        $query = new \yii\db\Query();
        $att_list = $query->select('aa.*,articles.contents as img_des,cat_default.name_zh as cat_default_name')
            ->from('article_attachment as aa')
            ->leftjoin('articles', 'articles.id = aa.article_id')
            ->leftjoin('cat_default', 'cat_default.id = aa.sub_type_id')
            ->leftjoin('article_send_revieve as asr', 'asr.article_id = aa.article_id')
            ->where(['articles.isdelete' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'asr.reciever_id' => $custom_id, 'articles.article_type_id' => HintConst::$HIGHLIGHT_PATH_NEW, 'articles.date' => $date])
            ->all();
        if (is_array($att_list)) {
            $server_host = $_SERVER['HTTP_HOST'];
            foreach ($att_list as $key => $value) {
                $summary['att_list'][$key] = $value;
                $summary['att_list'][$key]['article_att_id'] = $att_list[$key]['id'];
                $summary['att_list'][$key]['url'] = $server_host . '/' . $att_list[$key]['url'];
                $summary['att_list'][$key]['url_thumb'] = $server_host . '/' . $att_list[$key]['url_thumb'];
            }
        }
        return $this->render('summary', ['date' => $date, 'summary' => $summary, 'user' => $user]);
    }
    public function actionGetpushlist()//by article_id
    {
        return ((new Articles())->Getpushlist());
    }
    public function actionGetreplybyid()//get reply by reply id(after push reply)
    {
        return ((new Articles())->Getreplybyid());
    }
    public function actionDealsr()
    {
        $role = 9;
        $qu = new Query();
        $re = $qu->select('id,reciever_id')
            ->from('article_send_revieve')
            ->where("role=0 and school_id=0 and class_id=0")
            ->limit(500)
            ->all();
        foreach ($re as $k) {
            $user_id = $k['reciever_id'];
            $ree = $qu->select('id,school_id,class_id')
                ->from('customs')
                ->where("id=$user_id")
                ->one();
            $mo = ArticleSendRevieve::findOne(['id' => $k['id']]);
//            var_dump($k['id']);
//            echo "<br>";
            $mo->role = $role;
            $mo->school_id = $ree['school_id'];
            $mo->class_id = $ree['class_id'];
            $mo->save(false);
        }
        echo "success";;
    }
    public function actionDel()
    {
        return (new Articles())->mydel();
    }
    public function actionDelreply()
    {
        return (new ArticleReplies())->Delreply();
    }
    public function actionDelrr()
    {
        return (new ArticleReplies())->Delrr();
    }
    public function actionDelpic()
    {
        return (new ArticleAttachment())->Delpic();
    }
    public function actionPushauditbyarid()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $school = [];
        $class = [];
        $user = [];
        $ar = new Articles();
        $ar->getSchoolAndClassAndUserForArtiByID($school, $class, $user, $id);
        $custom = new Customs();
        $token = $custom->getToken($school, $class, $user);
        $ar_type = $ar->getTypeAndTitle($id);
        (new MultThread())->push_ar($token, $ar_type['article_type_id'], $id, $title);
    }
    public function actionPushaddahe()
    {
    	(new BaseAnalyze())->writeToAnal('actionPushaddahe()');
        $school = [];
        $class = [];
        $user = [];
        (new Articles())->getSchoolAndClassAndUserForArti($school, $class, $user, $_POST);
        $custom = new Customs();
        $token = $custom->getToken($school, $class, $user, $_POST['role']);
        (new MultThread())->push_ar($token, $_POST['type'], $_POST['id'], $_POST['title']);
    }
    public function actionPushpass()
    {
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $reward = isset($_REQUEST['reward']) ? $_REQUEST['reward'] : 0;
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $user = explode('-', $user_id);
        (new Customs())->increaseF($user[0], 'points', $reward);
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_pass($token, $type, $id, $reward, $title);
    }


    public function actionMoment1(){
        $class_id = isset($_REQUEST['class_id']) && is_numeric($_REQUEST['class_id']) ? $_REQUEST['class_id'] : 0;
        //$date = isset($_REQUEST['date']) && strlen($_REQUEST['date']) > 9 ? $_REQUEST['date'] : date('Y-m-d');
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = isset($_REQUEST['size']) && is_numeric($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $start_line = $page_size * ($page - 1);
        if (!$class_id) {
            $result = ['ErrCode' => '1', 'Message' => '缺少class_id', 'Content' => []];
            return (json_encode($result));
        }
        $summary = array();
        $query = new Query();
        $att_list = $query->select('aa.id,aa.article_id,aa.cat_default_id,aa.sub_type_id,aa.url,aa.url_thumb,aa.createtime,aa.sys_p,aa.cus_p,articles.author_id,articles.contents as img_des,cat_default.name_zh as cat_default_name')
            ->from('article_attachment as aa')
            ->distinct()
            ->leftjoin('articles', 'articles.id = aa.article_id')
            ->leftjoin('article_send_revieve as asr', 'asr.article_id = aa.article_id')
            ->leftjoin('cat_default', 'cat_default.id = aa.sub_type_id')
            ->where(['aa.ispassed' => HintConst::$YesOrNo_YES, 'asr.class_id' => $class_id, 'articles.article_type_id' => HintConst::$HIGHLIGHT_PATH_NEW])
            ->orderby(['aa.id' => SORT_DESC])
            ->offset($start_line)
            ->limit($page_size)
            ->all();
        if (is_array($att_list)) {
            $server_host = $_SERVER['HTTP_HOST'];
            foreach ($att_list as $key => $value) {
                $summary['att_list'][$key] = $value;
                $summary['att_list'][$key]['article_att_id'] = $att_list[$key]['id'];
                $summary['att_list'][$key]['url'] = $server_host . '/' . $att_list[$key]['url'];
                $summary['att_list'][$key]['url_thumb'] = $server_host . '/' . $att_list[$key]['url_thumb'];
            }
        }
        $result = ['ErrCode' => '0', 'Message' => HintConst::$WEB_JYQ, 'Content' => $summary];
        return json_encode($result);
    }

    public function actionMoment2(){
        $article = new Articles();
        $result = $article->Newgrow();
        return ($result);
    }

    public function actionFood(){
        $date = isset($_REQUEST['date']) && strlen($_REQUEST['date']) > 9 ? $_REQUEST['date'] : date('Y-m-d');
        $cook_book = new CookbookInfo();
        $summary = $cook_book->getCookbook($date);
        $result = ['ErrCode' => '0', 'Message' => HintConst::$WEB_JYQ, 'Content' => $summary];
        return json_encode($result);
    }

    /*public function actionDaily(){

    }*/

    public function actionHomework(){
        $class_id = isset($_REQUEST['class_id']) && is_numeric($_REQUEST['class_id']) ? $_REQUEST['class_id'] : 0;
        $date = isset($_REQUEST['date']) && strlen($_REQUEST['date']) > 9 ? $_REQUEST['date'] : date('Y-m-d');
        if (!$class_id) {
            $result = ['ErrCode' => '1', 'Message' => '缺少class_id', 'Content' => []];
            return (json_encode($result));
        }
        $query = new Query();
        $p_list = $query->select('daily_contents as homework')
            ->from('classes_daily')
            ->where(['class_id' => $class_id, 'classes_daily.date' => $date,'daily_type_id'=>HintConst::$DAILY_HOMEWORK_PATH])
            ->orderby(['classes_daily.daily_type_id' => SORT_ASC])
            ->one();
        if($p_list){
            $result = ['ErrCode' => '0', 'Message' => HintConst::$WEB_JYQ, 'Content' => $p_list['homework']];
            return json_encode($result);
        }
        return json_encode(['ErrCode'=>'0','Message'=>'','Content'=>'']);

    }


    public function actionPraisedetailList(){
        $result = (new Articles())->praisedetailList();
        return $result;
    }

}
