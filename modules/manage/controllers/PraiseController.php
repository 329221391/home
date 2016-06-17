<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Articles\models\ArticleAttachment;
use app\modules\Admin\Articles\models\Articles;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * ArticleController implements the CRUD actions for Articles model.
 */
class PraiseController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }
    /**
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $is_passed = Yii::$app->request->get('ispassed');
        $keyword = Yii::$app->request->get('keyword');
        $shenhe = '审核(全部)';
        $query = new \yii\db\Query();
        $article_list = $query->select('articles.*,customs.name_zh as author_name,classes.name as class_name')
            ->from('articles')
            ->leftjoin('classes', 'classes.id = articles.class_id')
            ->leftjoin('customs', 'customs.id = articles.author_id')
            ->where(['articles.school_id' => Yii::$app->session['manage_user']['school_id'], 'articles.article_type_id' => CatDef::$mod['praise']]);
        if ($is_passed) {
            $article_list = $query->andwhere(['articles.ispassed' => $is_passed]);
            $shenhe = $is_passed == 211 ? '审核(是)' : '审核(否)';
        }
        if ($keyword) {
            $article_list = $query->andwhere(['like', 'articles.title', $keyword]);
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);
        $article_list = $query->offset($pages->offset)
            ->orderby(['id' => SORT_DESC])
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'article_list' => $article_list,
            'pages' => $pages,
            'shenhe' => $shenhe,
            'keyword' => $keyword,
        ]);
    }
    /**
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = Yii::$app->request->get('id');
        //得到相应的图片列表
        $pic_list = ArticleAttachment::find()->where(['article_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'pic_list' => $pic_list,
        ]);
    }
    public function actionCreate()
    {
        $type_id = HintConst::$ARTICLE_PATH;
        $result = ['error' => 0, 'message' => '操作成功', 'content' => ''];
        //获取传来的参数
        $title = Yii::$app->request->post('title');
        $content = Yii::$app->request->post('content');
        $send_to = Yii::$app->request->post('send_to');
        $school_id = Yii::$app->session['manage_user']['school_id'];
        if ($title && $content && $send_to) {
            //最重要的  解析send_to
            $send_arr = explode(',', $send_to); //拆分成数组
            $send_array = [];
            foreach ($send_arr as $kk => $vv) {
                $query = new Query();
                switch ($vv) {
                    case 'ALL': //如果是全部成员  就得到全部成员
                        $list = $query->select('id')->from('customs')->where(['school_id' => $school_id, 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO, 'isout' => HintConst::$YesOrNo_NO])->column();
                        $send_array = array_merge($send_array, $list);
                        break;
                    case 'ALL_TEACHER': //如果是全部老师  就得到全部老师
                        $list = $query->select('id')->from('customs')->where(['school_id' => $school_id, 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO, 'isout' => HintConst::$YesOrNo_NO, 'cat_default_id' => HintConst::$ROLE_TEACHER])->column();
                        $send_array = array_merge($send_array, $list);
                        break;
                    case 'ALL_STUDENT': //如果是全部学生  就得到全部学生
                        $list = $query->select('id')->from('customs')->where(['school_id' => $school_id, 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO, 'isout' => HintConst::$YesOrNo_NO, 'cat_default_id' => HintConst::$ROLE_PARENT])->column();
                        $send_array = array_merge($send_array, $list);
                        break;
                    default:
                        //检查是班级 还是学生id
                        if (strpos($vv, 'CLASS') <> false) {
                            //拆分得到班级id
                            $class_model_arr = explode('CLASS', $vv);
                            if (isset($class_model_arr[1]) && is_numeric($class_model_arr[1])) {
                                $list = $query->select('id')->from('customs')->where(['school_id' => $school_id, 'class_id' => $class_model_arr[1], 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO, 'isout' => HintConst::$YesOrNo_NO])->column();
                                $send_array = array_merge($send_array, $list);
                            }
                        } else {
                            array_push($send_array, $vv);
                        }
                        break;
                }
                //如果是ALL  则跳出foreach
                if ($vv == 'ALL') {
                    break;
                }
            }
            $send_array = array_filter($send_array);
            $send_array = array_unique($send_array);
            $query = new \yii\db\Query;
            $class = $query->select('class_id')->from('customs')->where(['id' => $send_array[0]])->one();
            //print_r($send_array);
            //先添加文章
            $Arti = new Articles;
            $Arti->school_id = Yii::$app->session['manage_user']['school_id'];
            $Arti->class_id = $class['class_id'];
            $Arti->author_id = Yii::$app->session['manage_user']['id'];
            $Arti->contents = isset($_REQUEST['content']) ? trim($_REQUEST['content']) : '';
            $Arti->title = $title;
            $Arti->article_type_id = HintConst::$ARTICLE_PATH;
            $Arti->sub_type_id = 0;
            $Arti->date = date('Y-m-d');
            $Arti->createtime = date('Y-m-d H:i:s', time());
            $Arti->month = date('Ym');
            $Arti->term = date('Y');
            $Arti->ispassed = Yii::$app->session['manage_user']['iscansend'];
            $Arti->isdelete = HintConst::$YesOrNo_NO;
            $Arti->isview = HintConst::$YesOrNo_YES;
            $Arti->thumb = '';
            $Arti->save();
            //然后分别指定用户
            //生成sql语句
            //$insert_sql = 'insert into article_send_revieve (article_id,sender_id,reciever_id,isread,createtime) values ';
            $ima_time = date('Y-m-d H:i:s');
            $date_arr = [];
            $user_id = Yii::$app->session['manage_user']['id'];
            foreach ($send_array as $kk => $vv) {
                //$insert_sql .= '('.$Arti->id.','.Yii::$app->session['manage_user']['id'].','.$vv.','.HintConst::$YesOrNo_NO.',"'.$ima_time.'"),';
                $date_arr[] = ['article_id' => $Arti->id, 'sender_id' => $user_id, 'reciever_id' => $vv, 'isread' => HintConst::$YesOrNo_NO, 'createtime' => $ima_time];
            }
            //$insert_sql = substr($insert_sql,0,strlen($insert_sql)-1);
            Yii::$app->db->createCommand()->batchInsert('article_send_revieve', ['article_id', 'sender_id', 'reciever_id', 'isread', 'createtime'], $date_arr)->execute();
            //Yii::$app->db->createCommand($insert_sql,[])->execute();
            return (json_encode($result));
        } else {
            $result = ['error' => 1, 'message' => '请填写完整信息', 'content' => $title . $content . $send_to];
            return (json_encode($result));
        }
    }
    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionEditArticle()
    {
        $field = Yii::$app->request->get('field');
        $val = Yii::$app->request->get('val');
        $id = Yii::$app->request->get('id');
        if ($field && $val && $id) {
            //验证id 是不是属于该管理员下的
            $article = Articles::findOne($id);
            if ($article) {
                if ($article->school_id <> Yii::$app->session['manage_user']['school_id']) {
                    $result = ['error' => 1, 'message' => '没有权限修改其他学校班级的信息', 'content' => ''];
                    return (json_encode($result));
                }
            } else {
                $result = ['error' => 1, 'message' => '没有该学校的信息', 'content' => ''];
                return (json_encode($result));
            }
            switch ($field) {
                case 'name':
                    $article->name = $val;
                    $article->save();
                    break;
                case 'ispassed':
                    $article->ispassed = $val;
                    $article->save();
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => $val];
                    return (json_encode($result));
                    break;
                default:
                    break;
            }
            $result = ['error' => 0, 'message' => '更新成功', 'content' => $val . ' <span class="glyphicon glyphicon-pencil"></span></span>'];
            return (json_encode($result));
        } else {
            $result = ['error' => 1, 'message' => '失败', 'content' => ''];
            return (json_encode($result));
        }
    }
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $article = $this->findModel($id);
        if ($article && $article->school_id == Yii::$app->session['manage_user']['school_id']) {
            $article->delete();
        }
        return $this->redirect(['index']);
    }
    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::find()->where(['school_id' => Yii::$app->session['manage_user']['school_id'], 'id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
