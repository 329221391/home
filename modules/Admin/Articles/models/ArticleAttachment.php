<?php

namespace app\modules\Admin\Articles\models;
use app\models\HbPush;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Message\models\Messages;
use app\modules\AppBase\base\appbase\Asyn;
use app\modules\AppBase\base\appbase\base\BaseEdit;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\appbase\TransAct;
use app\modules\AppBase\base\BaseConst;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
use yii\db\Query;
use yii\web\UploadedFile;
use app\modules\AppBase\base\appbase\BaseAnalyze;
/**
 * This is the model class for table "article_attachment".
 * @property integer $id
 * @property integer $article_id
 * @property integer $cat_default_id
 * @property integer $sub_type_id
 * @property string $url
 * @property string $url_thumb
 * @property string $createtime
 * @property string $updatetime
 * @property integer $ispassed
 * @property integer $isdelete
 * @property integer $isview
 */
class ArticleAttachment extends BaseAR
{
    private $sel_img = 'at.id,at.url,at.url_thumb,at.createtime,a.title';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_attachment';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'cat_default_id', 'sub_type_id', 'ispassed', 'isdelete', 'isview', 'cus_p', 'sys_p'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['url', 'url_thumb'], 'string', 'max' => 255]
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
            'cat_default_id' => 'Cat Default ID',
            'sub_type_id' => 'Sub Type ID',
            'url' => 'Url',
            'url_thumb' => 'Url Thumb',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'ispassed' => 'Ispassed',
            'isdelete' => 'Isdelete',
            'isview' => 'Isview',
        ];
    }
    public function add_At($d)
    {
        $at = new ArticleAttachment();
        foreach ($d as $k => $v) {
            $at->$k = $v;
        }
        $at->save(false);
        return $at->attributes['id'];
    }
    public function PendingPic()
    {
        $school_id = $school_id = Yii::$app->session['custominfo']->custom->school_id;
        $query = new Query();
        $pending_pic_num = $query->select('count(*) as number')
            ->from(BaseConst::$article_attachment_T . ' as a')
            ->leftjoin(BaseConst::$articles_T . ' as b', 'a.article_id = b.id')
            ->where(['b.school_id' => $school_id, 'b.article_type_id' => HintConst::$HIGHLIGHT_PATH_NEW, 'a.ispassed' => HintConst::$YesOrNo_NO, 'a.isdelete' => HintConst::$YesOrNo_NO])
            ->one();
        return $pending_pic_num['number'];
    }
    public function Addatshare()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $d['id'] = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (empty($d['id']) || !is_numeric($d['id'])) {
            $ErrCode = HintConst::$NoId;
        } else {
            $ar_at_stats = new ArAtStats();
            $ar_at_stats->addStats($d['id'], HintConst::$YesOrNo_YES);
            self::increaseF($d['id'], 'share_times');
            $self = self::findId($d['id']);
            $score = new Score();
            $title = json_decode((new BaseEdit())->getProp('articles', $self->article_id, 'title'));
            $data['contents'] = $title->Content;
            $data['related_id'] = $d['id'];
            $score->ImgShare($data);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    public function ArAt($article_id)
    {
        $mc_name = $this->getMcName() . 'ArAt' . $article_id;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select('id,url,url_thumb,cat_default_id,sub_type_id')
                ->from('article_attachment')
                ->where(['article_id' => $article_id, 'ispassed' => HintConst::$YesOrNo_YES])
                ->orderby(['id' => SORT_DESC])
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function getNum($school_id, $type, $startdate, $enddate)
    {
        $mc_name = $this->getMcName() . 'aratgetNum' . $school_id . $type . $startdate . $enddate;
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $d = new Query();
            $d = $d->from('article_attachment as at')
                ->select('count(at.id) as num')
                ->leftJoin('articles as a', 'a.id=at.article_id')
                ->where("a.article_type_id=$type");
            if ($school_id) {
                $d = $d->andWhere("a.school_id=$school_id");
            }
            $d = $d->andWhere("at.createtime between '$startdate' and '$enddate'")
                ->one();
            $this->mc->add($mc_name, $d);
        }
        return $d;
    }
    public function Delpic()
    {
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        $mod = isset($_REQUEST['mod']) ? trim($_REQUEST['mod']) : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $query = new Query();
            $article_attach = $query->select('article_attachment.id,article_attachment.article_id,articles.article_type_id')
                ->from('article_attachment')
                ->leftJoin('articles','articles.id=article_attachment.article_id')
                ->where(['article_attachment.id'=>$id])->one();
            $ErrCode = 0;
            if($article_attach){
                $article_id = $article_attach['article_id'];

                $query = new Query();
                $article = $query->select('author_id')->from('articles')->where(['id'=>$article_id])->one();
                //先查询该文章下的所有图片数量
                $query = new Query();
                $table_name  = 'custom_score_'.($this->getCustomSchool_id() % 10);
                $attach_count = $query->select('id')->from('article_attachment')->where(['article_id'=>$article_id])->count();

                if($attach_count == 1 && $article_attach['article_type_id'] == CatDef::$mod['pic']){ //删除该文章
                    $_REQUEST['id'] = $article_id;
                    //这里已经发布私信通知了
                    (new Articles())->mydel();
                    $sql2 = "DELETE FROM favorites WHERE pri_type_id=" . CatDef::$mod['pic'] . " AND article_att_id=$id";
                    $sql3 = "delete from $table_name where  pri_type_id=".CatDef::$act['create']." and sub_type_id=".CatDef::$mod['pic']." and related_id = ".$article_id;
                    $sql4 = "delete from $table_name where  pri_type_id=".CatDef::$act['share_img']." and sub_type_id=".CatDef::$mod['pic']." and related_id = ".$article_attach['id'];
                    //(new BaseAnalyze())->writeToAnal($sql4);
                    $ErrCode = (new TransAct())->trans($sql2,$sql3,$sql4);
                }else{
                    $sql = "DELETE FROM article_attachment WHERE id=$id ";
                    $sql2 = "DELETE FROM favorites WHERE pri_type_id=" . CatDef::$mod['pic'] . " AND article_att_id=$id";
                    $sql3 = "delete from $table_name where  pri_type_id=".CatDef::$act['create']." and sub_type_id=".CatDef::$mod['pic']." and related_id = ".$article_id;
                    $sql4 = "delete from $table_name where  pri_type_id=".CatDef::$act['share_img']." and sub_type_id=".CatDef::$mod['pic']." and related_id = ".$article_attach['id'];

                    //(new BaseAnalyze())->writeToAnal($sql4);
                    $ErrCode = (new TransAct())->trans($sql, $sql2,$sql3,$sql4);
                    if($mod == 'audit'){
                        $message = '您发布的图片未通过审核，已被删除';
                        //$host = \Yii::$app->request->getHostInfo();
                        //http_get($host.'/index.php?r=Message/messages/sendmsg&reciever_id='.$article['author_id'].'&contents='.$message);
                        $messages = new Messages();
                        $result = $messages->Sendmsg($message, $article['author_id']);
                        //$this->push1($receiver_id, $message);
                        //$user = explode('-', $article['author_id']);
                        //$custom = new Customs();
                        //$token = $custom->getToken([], [], $user);
                        //(new MultThread())->push_msg($token, $message);
						$content = $result['Content'];
						$hbPush = new HbPush();
						$hbPush->sendMessage($content['id']);
                    }
                }


            }

        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => HintConst::$NULLARRAY];
        return json_encode($result);
    }
    public function MulUpload()
    {
        $Arti_a = new self();
        $Arti_a->article_id = isset($_REQUEST['article_id']) && is_numeric($_REQUEST['article_id']) ? $_REQUEST['article_id'] : 0;
        $thumb = UploadedFile::getInstanceByName('images');
        if ($thumb && $Arti_a->article_id) {
            $Arti_a->cat_default_id = 0;
            $Arti_a->sub_type_id = 0;
            $Arti_a->ispassed = Yii::$app->session['custominfo']->custom->iscansend;
            $Arti_a->isdelete = HintConst::$YesOrNo_NO;
            $Arti_a->isview = HintConst::$YesOrNo_NO;
            //genju article_id dedao wenzhang article_type_id  he  sub_type_id
            $query = new Query();
            $article = $query->select('*')->from('articles')->where(['id' => $Arti_a->article_id])->one();
            if (isset($article['article_type_id']) && isset($article['sub_type_id'])) {
                $Arti_a->cat_default_id = $article['article_type_id'];
                $Arti_a->sub_type_id = $article['sub_type_id'];
                $file_name = $Arti_a->create_img($article['school_id'], $article['class_id'], 'images');  //上传图片 并记录文件名
                if ($file_name) {
                    $Arti_a->url_thumb = $file_name . '.thumb.jpg';
                    $Arti_a->url = $file_name . '.jpg';
                }
            } else {
                $result = ['ErrCode' => '1', 'Message' => '指定文章不存在', 'Content' => ''];
                return (json_encode($result));
            }
            $Arti_a->createtime = date('Y-m-d H:i:s');
        } else {
            $result = ['ErrCode' => '1', 'Message' => '没有文件被上传', 'Content' => ''];
            return (json_encode($result));
        }
        if ($article['article_type_id'] == CatDef::$mod['pic']) {
            $Arti_a->sys_p = Score::getSysP('create', CatDef::$mod['pic']);
        }
        $Arti_a->save(false);
        if ($article['article_type_id'] == CatDef::$mod['pic'] && $this->getCustomRole() == HintConst::$ROLE_TEACHER && $this->getIsCanSend() == HintConst::$YesOrNo_YES) {
            //high model has score
            $score = new Score();
            $data['contents'] = $article['title'];
            $data['related_id'] = $Arti_a->attributes['id'];
            $score->ImgCreate($data);
        }
        $result = ['ErrCode' => '0', 'Message' => '上传成功', 'Content' => $Arti_a->article_id];
        return (json_encode($result));
    }
    public function ReviewPic()
    {
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        //拆分send_to
        $id = explode(',', $id);
        $id = array_filter($id);//过滤为空的值
        $id = array_unique($id);//过滤重复的值
        $ar_id = 0;
        if (count($id) > 0) {
            foreach ($id as $key => $value) {
                $model = new ArticleAttachment();
                $article_a = $model->findOne($value);
                $article_a->ispassed = HintConst::$YesOrNo_YES;
                $reward = $article_a->sys_p;
                $article_a->save(false);
                //同时更新文章 为通过状态
                $ar_id = $article_a->article_id;
                $article = new Articles();
                $article = $article->findOne($ar_id);
                $article->ispassed = HintConst::$YesOrNo_YES;
                $author_id = $article->author_id;
                $type = $article->article_type_id;
                $article->save(false);
                $query = new Query();
                $custom = $query->select('id,name_zh')->from('customs')->where(['id'=>$author_id])->one();
                $score = new Score();
                if (!get_magic_quotes_gpc()) {
                    // 处理字符串，自动添加“\”
                    $data['contents'] = addslashes($article->title);
                }
                else
                {
                    // 不做任何处理
                    $data['contents'] = $article->title;
                }

                $data['related_id'] = $value;
                $data['custom_id'] = $author_id;
                $data['custom_name'] = $custom['name_zh'];
                $score->ImgCreate($data);
                //self::push_pass($author_id, $type, $value, $reward, '审核通过');
                $receiver_id = $author_id;
                $message = '您发布的照片通过审核';
                //$host = \Yii::$app->request->getHostInfo();
                //http_get($host.'/index.php?r=Message/messages/sendmsg&reciever_id='.$receiver_id.'&contents='.$message);
                $messages = new Messages();
                $result = $messages->Sendmsg($message,$receiver_id);
				$content = $result['Content'];
                //$this->push1($receiver_id, $message);
                /*$user = explode('-', $receiver_id);
                $custom = new Customs();
                $token = $custom->getToken([], [], $user);
                (new MultThread())->push_msg($token, $message);*/
                //新的推送
                $hbPush = new HbPush();
				$hbPush->sendMessage($content['id']);
                $hbPush->createPicPush($ar_id);


            }
        } else {
            $result = ['ErrCode' => '1', 'Message' => '缺少参数', 'Content' => ''];
            return (json_encode($result));
        }
        //(new Articles())->pushAuditByArid($ar_id, $data['contents']);
        $result = ['ErrCode' => '0', 'Message' => '审核成功', 'Content' => ''];
        return (json_encode($result));
    }
    public function HighDetail()
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
        if (!is_numeric($id) || $id == 0) {
            $ErrCode = HintConst::$NoId;
        } else {
            $mc_name = $this->getMcName() . 'HighDetail' . $id;
            if ($val = $this->mc->get($mc_name)) {
                $Content = $val;
            } else {
                $query = new Query();
                $Content = $query->select($this->sel_img)
                    ->from(BaseConst::$article_attachment_T . ' as at')
                    ->leftJoin(BaseConst::$articles_T . ' as a', 'a.id=at.article_id')
                    ->where('at.id=' . $id)
                    ->one();
                $this->mc->add($mc_name, $Content);
            }
        }
        return json_encode(['ErrCode' => $ErrCode, 'Message' => HintConst::$WEB_JYQ, 'Content' => $Content]);
    }
    public function push_pass($user_id, $type, $id, $reward, $title)
    {
        $asyn = new Asyn();
        $asyn->arat_push_pass(['user_id' => $user_id, 'type' => $type, 'id' => $id, 'reward' => $reward, 'title' => $title]);
    }
}
