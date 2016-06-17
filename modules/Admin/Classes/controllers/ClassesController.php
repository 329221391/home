<?php

namespace app\modules\Admin\Classes\controllers;
use app\modules\Admin\Classes\models\Classes;
use app\modules\Admin\Classes\models\ClassesSearch;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * ClassesController implements the CRUD actions for Classes model.
 */
class ClassesController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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
        if ($this->checkAdminSession()) {
            $searchModel = new ClassesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Classes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ($this->checkAdminSession()) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    /**
     * Creates a new Classes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Classes();
            if ($model->load(Yii::$app->request->post())) {
                $school_code = $model->school_id;
                $school = new Schools();
                $model->school_id = $school->getSchoolId($school_code);
                if ($model->school_id == 0) {
                    echo HintConst::$NoSchoolId;
                } else {
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                exit;
            } else {
                return $this->render('create', [
                    'model' => $model, 'flag' => HintConst::$CREAT,
                ]);
            }
        }
    }
    /**
     * Updates an existing Classes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ($this->checkAdminSession()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model, 'flag' => HintConst::$UPDATE,
                ]);
            }
        }
    }
    /**
     * Deletes an existing Classes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->checkAdminSession()) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
    }
    /**
     * Finds the Classes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Classes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Classes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
     * 园长手机端创建班级
     */
    public function actionAddclassesAH()
    {
        $ErrCode = HintConst::$Zero;
        $class_name = !empty($_REQUEST['class_name']) ? $_REQUEST['class_name'] : '';
        $teacher_id = !empty($_REQUEST['teacher_id']) ? $_REQUEST['teacher_id'] : '';
        if ($class_name == '') {
            $ErrCode = HintConst::$NoClassName;
        } elseif ($teacher_id == '' || !is_numeric($teacher_id)) {
            $ErrCode = HintConst::$NoTeacherId;
        } else {
            $classes = new Classes();
            $result = $classes->AddclassesAH($class_name, $teacher_id);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    /*
    * 园长手机端获得班级列表
    */
    public function actionGetclasseslistA()
    {
        $classes = new Classes();
        $result = $classes->GetclasseslistA();
        parent::myjsonencode($result);
    }
    /*
     * 检测是否具有classcode
     */
    public function actionCheckcodeA()
    {
        $ErrCode = HintConst::$Zero;
        $code = !empty($_REQUEST[HintConst::$Field_code]) ? $_REQUEST[HintConst::$Field_code] : '';
        if ($code == '' || !is_numeric($code)) {
            $ErrCode = HintConst::$NoCode;
        } else {
            $classes = new Classes();
            $result = $classes->checkClassCode($code);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    /*
    * 修改teacher_id
    */
    public function  actionUpdateteacheridA()
    {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '0';
        $v = !empty($_REQUEST['teacher_id']) ? $_REQUEST['teacher_id'] : '0';
        $custom = new Customs();
        if (!is_null($id) && is_numeric($id) && !is_null($v) && is_numeric($v)) {
            $classes = Classes::findOne($id);
            $teacher_id = $classes->teacher_id;
            $custom->updateClassId($teacher_id, 0);
        }
        $this->CheckUpdateParamaA($id, HintConst::$Field_teacher_id, $v);
        $custom->updateClassId($v, $id);
    }
}
