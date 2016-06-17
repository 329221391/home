<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Articles\models\ArticleAttachment;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\NotFoundHttpException;
/**
 * SchoolsController implements the CRUD actions for Schools model.
 */
class PicController extends BaseController
{
    public function actionIndex()
    {
        $is_passed = Yii::$app->request->get('ispassed') == 211 || Yii::$app->request->get('ispassed') == 212 ? Yii::$app->request->get('ispassed') : 0;
        $shenhe = '审核(全部)';
        $query = new Query();
        $pic_list = $query->select('article_attachment.*,c.name_zh as author_name,classes.name as class_name,cat_default.name_zh as type_name')
            ->from('article_attachment')
            ->leftjoin('articles', 'article_attachment.article_id = articles.id')
            ->leftjoin('classes', 'articles.class_id = classes.id')
            ->leftjoin('customs as c', 'c.id = articles.author_id')
            ->leftjoin('cat_default', 'cat_default.id = articles.sub_type_id')
            ->where(['articles.school_id' => Yii::$app->session['manage_user']['school_id'], 'articles.article_type_id' => HintConst::$HIGHLIGHT_PATH_NEW, 'articles.isdelete' => HintConst::$YesOrNo_NO]);
        if ($is_passed) {
            $pic_list = $query->andwhere(['article_attachment.ispassed' => $is_passed]);
            $shenhe = $is_passed == 211 ? '审核(是)' : '审核(否)';
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);
        $pic_list = $query->offset($pages->offset)
            ->orderby(['id' => SORT_DESC])
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'pic_list' => $pic_list,
            'pages' => $pages,
            'shenhe' => $shenhe
        ]);
    }
    public function actionEditPic()
    {
        $field = Yii::$app->request->get('field');
        $val = Yii::$app->request->get('val');
        $id = Yii::$app->request->get('id');
        if ($field && $val && $id) {
            //验证id 是不是属于该管理员下的
            $query = new \yii\db\Query();
            $pict = $query->select('aa.*')
                ->from('article_attachment as aa')
                ->leftjoin('articles', 'articles.id = aa.article_id')
                ->where(['aa.id' => $id])
                ->one();
            if (!is_array($pict) || count($pict) <= 0) {
                $result = ['error' => 1, 'message' => '没有该图片的信息', 'content' => ''];
                return (json_encode($result));
            }
            $pic = ArticleAttachment::findone($id);
            switch ($field) {
                case 'ispassed':
                    $pic->ispassed = $val;
                    $pic->save();
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
        $article = $this->findComModel($id);
        if ($article && $article['school_id'] == Yii::$app->session['manage_user']['school_id']) {
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }
    protected function findComModel($id)
    {
        //todo:need to add combin query
        $query = new Query();
        $model = $query
            ->select('a.school_id,c.isdelete as isdeleted')
            ->from('article_attachment as c')
            ->leftjoin('articles as a', 'c.article_id = a.id')
            ->where(['c.id' => $id])
            ->limit(1)->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModel($id)
    {
        if (($model = ArticleAttachment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
