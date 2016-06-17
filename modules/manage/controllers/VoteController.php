<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Notes\models\Notes;
use app\modules\Admin\Vote\models\Vote;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
/**
 * SchoolsController implements the CRUD actions for Schools model.
 */
class VoteController extends BaseController
{
    public function actionIndex()
    {
        $keyword = Yii::$app->request->get('keyword');
        $query = new \yii\db\Query();
        $note_list = $query->select('vote.*,customs.name_zh as author_name')
            ->from('vote')
            ->leftjoin('customs', 'customs.id = vote.author_id')
            ->where(['vote.school_id' => Yii::$app->session['manage_user']['school_id'], 'vote.isdeleted' => HintConst::$YesOrNo_NO]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);
        $note_list = $query->offset($pages->offset)
            ->orderby(['id' => SORT_DESC])
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'note_list' => $note_list,
            'pages' => $pages,
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
        $vote = new Vote();
        $vote->setName('vote');
        return $this->render('view', [
            'model' => $vote->Get_detail($id)
        ]);
    }
    public function actionEditNote()
    {
        $field = Yii::$app->request->get('field');
        $val = Yii::$app->request->get('val');
        $id = Yii::$app->request->get('id');
        if ($field && $val && $id) {
            //验证id 是不是属于该管理员下的
            $note = Notes::findOne($id);
            if ($note) {
                if ($note->school_id <> Yii::$app->session['manage_user']['school_id']) {
                    $result = ['error' => 1, 'message' => '没有权限修改其他学校班级的信息', 'content' => ''];
                    return (json_encode($result));
                }
            } else {
                $result = ['error' => 1, 'message' => '没有该学校的信息', 'content' => ''];
                return (json_encode($result));
            }
            switch ($field) {
                case 'name':
                    $note->name = $val;
                    $note->save();
                    break;
                case 'ispassed':
                    $note->ispassed = $val;
                    $note->save();
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
        $vote = $this->findModel($id);
        if ($vote && $vote->school_id == Yii::$app->session['manage_user']['school_id']) {
            $vote->delete();
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Vote::find()->where(['school_id' => Yii::$app->session['manage_user']['school_id'], 'id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
