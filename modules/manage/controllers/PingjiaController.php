<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Articles\models\Articles;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
/**
 * SchoolsController implements the CRUD actions for Schools model.
 */
class PingjiaController extends BaseController
{
    public function actionIndex()
    {
        $is_passed = Yii::$app->request->get('ispassed');
        $type = Yii::$app->request->get('type') == HintConst::$NIANPINGJIA_PATH || Yii::$app->request->get('type') == HintConst::$YUEPINGJIA_PATH ? Yii::$app->request->get('type') : HintConst::$YUEPINGJIA_PATH;
        $type_value = $type == HintConst::$NIANPINGJIA_PATH ? '类型(年评价)' : '类型(月评价)';
        $keyword = Yii::$app->request->get('keyword');
        $shenhe = '审核(全部)';
        $query = new \yii\db\Query();
        $article_list = $query->select('articles.*,customs.name_zh as author_name,classes.name as class_name,z.name_zh as type_name')
            ->from('articles')
            ->leftjoin('classes', 'classes.id = articles.class_id')
            ->leftjoin('customs', 'customs.id = articles.author_id')
            ->leftjoin('cat_default as z', 'z.id = articles.article_type_id')
            ->where(['articles.school_id' => Yii::$app->session['manage_user']['school_id'], 'articles.article_type_id' => $type, 'articles.isdelete' => HintConst::$YesOrNo_NO]);
        if ($is_passed) {
            $article_list = $query->andwhere(['articles.ispassed' => $is_passed]);
            $shenhe = $is_passed == 211 ? '审核(是)' : '审核(否)';
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
            'type' => $type,
            'type_value' => $type_value,
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
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
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
    protected function findModel($id)
    {
        if (($model = Articles::find()->where(['school_id' => Yii::$app->session['manage_user']['school_id'], 'id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
