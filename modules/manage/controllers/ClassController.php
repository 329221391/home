<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Classes\models\Classes;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\base\BaseDb1;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * ClassController implements the CRUD actions for Classes model.
 */
class ClassController extends BaseController
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
     * Lists all Classes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $class_name = Yii::$app->request->post('class_name');
        $teacher_id = Yii::$app->request->post('teacher_id');
        $message = '';
        //检查教师是不是属于该学校
        if ($teacher_id && is_numeric($teacher_id)) {
            $teacher = Customs::findone($teacher_id);
            if ($teacher->school_id <> Yii::$app->session['manage_user']['school_id']) {
                $message = '教师不属于该学校';
            } else {
            }
        }
        if ($class_name || $teacher_id) {
            $message = '请填写完整信息';
        }
        //如果存在class_name 就添加班级
        if ($class_name && $teacher_id) {
            $class = new Classes;
            $class->name = $class_name;
            $class->code = $this->create_code();
            $class->school_id = Yii::$app->session['manage_user']['school_id'];
            $class->teacher_id = $teacher_id;
            $class->ispassed = HintConst::$YesOrNo_YES;
            $class->isgraduated = HintConst::$YesOrNo_NO;
            $class->isdeleted = HintConst::$YesOrNo_NO;
            $class->createtime = date('Y-m-d H:i:s', time());
            $class->save();
            $custom = Customs::findone($teacher_id);
            $custom->class_id = $class->id;
            $custom->save();
            $message = '添加成功';
            $this->batDelMC();
        }
        $query = new \yii\db\Query();
        $class_list = $query->select('classes.*,customs.name_zh as teacher_name')
            ->from('classes')
            ->leftjoin('customs', 'customs.id = classes.teacher_id')
            ->where(['classes.school_id' => Yii::$app->session['manage_user']['school_id']]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);
        $class_list = $query->offset($pages->offset)
            ->orderby(['id' => SORT_DESC])
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'models' => $class_list,
            'pages' => $pages,
            'message' => $message,
        ]);
    }
    public function actionCreate()
    {
        $model = new Classes();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionDelete()
    {
        //检查id是不是学校内的
        $id = Yii::$app->request->post('id');
        $class = Classes::find()->where(['id' => $id, 'school_id' => Yii::$app->session['manage_user']['school_id']])->one();
        if (isset($class->id) && $class->id > 0) {
            //搜索custom  where class_id=$id;
            $sql = "select id from customs WHERE class_id='" . $id."'";
            $db = new BaseDb1();
            $result =$db->selcetOne($sql);
            if(empty($result)){
            $this->findModel($id)->delete();
                return "成功删除";
            }else{
                return "班级成员不为空，不能删除该班级！";
            }

        } else {
            return $this->redirect(['index']);
        }
    }
    protected function findModel($id)
    {
        if (($model = Classes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionEditClass($id)
    {
        $field = Yii::$app->request->get('field');
        $val = Yii::$app->request->get('val');
        $id = Yii::$app->request->get('id');
        if ($field && $val && $id) {
            //验证id 是不是属于该管理员下的
            $class = Classes::findOne($id);
            if ($class) {
                if ($class->school_id <> Yii::$app->session['manage_user']['school_id']) {
                    $result = ['error' => 1, 'message' => '没有权限修改其他学校班级的信息', 'content' => ''];
                    return (json_encode($result));
                }
            } else {
                $result = ['error' => 1, 'message' => '没有该学校的信息', 'content' => ''];
                return (json_encode($result));
            }
            switch ($field) {
                case 'name':
                    $class->name = $val;
                    $class->save();
                    break;
                case 'ispassed':
                    $class->ispassed = $val;
                    $class->save();
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => $val];
                    return (json_encode($result));
                    break;
                case 'isgraduated':
                    $class->isgraduated = $val;
                    $class->save();
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => $val];
                    return (json_encode($result));
                    break;
                default:
                    break;
            }
            $result = ['error' => 0, 'message' => '更新成功', 'content' => $val . ' </span>'];
            return (json_encode($result));
        } else {
            $result = ['error' => 1, 'message' => '失败', 'content' => ''];
            return (json_encode($result));
        }
    }
    //得到该学校下的全部老师  为下拉选择菜单使用
    public function actionAllTeacher()
    {
        $query = new \yii\db\Query();
        $t_list = $query->select('id,name_zh as text')
            ->from('customs')
            ->where(['school_id' => Yii::$app->session['manage_user']['school_id'], 'isdeleted' => HintConst::$YesOrNo_NO, 'cat_default_id' => HintConst::$ROLE_TEACHER, 'class_id' => ''])
            ->all();
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        return $t_list;
    }
    //搜索老师
    public function actionSearchTeacher()
    {
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : 0;
        $query = new \yii\db\Query();
        $t_list = $query->select('id,name_zh as name')
            ->from('customs')
            ->where(['school_id' => Yii::$app->session['manage_user']['school_id'], 'isdeleted' => HintConst::$YesOrNo_NO, 'cat_default_id' => HintConst::$ROLE_TEACHER, 'class_id' => ''])
            ->andwhere(['like', 'name_zh', $q])
            ->all();
        return (json_encode($t_list));
    }
    //生成不重复班级码
    protected function create_code()
    {
        do {
            $code = rand(10000000, 99999999);
            $class = Classes::find()->where(['code' => $code])->one();
        } while (isset($class->id));
        return (string)$code;
    }
}
