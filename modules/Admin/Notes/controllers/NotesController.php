<?php

namespace app\modules\Admin\Notes\controllers;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Notes\models\Notes;
use app\modules\Admin\Notes\models\NotesReplies;
use app\modules\Admin\Notes\models\NotesSearch;
use app\modules\admin\Notes\models\NotesView;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * NotesController implements the CRUD actions for Notes model.
 */
class NotesController extends BaseController
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
     * Lists all Notes models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new NotesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Notes model.
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
     * Creates a new Notes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Notes();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Updates an existing Notes model.
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
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Deletes an existing Notes model.
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
     * Finds the Notes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function  actionAddnote()
    {
        $ErrCode = HintConst::$Zero;
        $d['note_type_id'] = !empty($_REQUEST['note_type_id']) ? $_REQUEST['note_type_id'] : '0';
        $d['a_p_id'] = !empty($_REQUEST['a_p_id']) ? $_REQUEST['a_p_id'] : '0';
        $d['obj_id'] = !empty($_REQUEST['obj_id']) ? $_REQUEST['obj_id'] : '0';
        $d['for_someone_type'] = !empty($_REQUEST['for_someone_type']) ? $_REQUEST['for_someone_type'] : '0';
        $d['for_someone_id'] = !empty($_REQUEST['for_someone_id']) ? $_REQUEST['for_someone_id'] : '0';
        $d['title'] = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $d['contents'] = !empty($_REQUEST['contents']) ? $_REQUEST['contents'] : '';
        $d['starttime'] = !empty($_REQUEST['starttime']) ? $_REQUEST['starttime'] : '';
        $d['endtime'] = !empty($_REQUEST['endtime']) ? $_REQUEST['endtime'] : '';
        if ($d['obj_id'] == '' || !is_numeric($d['obj_id'])) {
            $ErrCode = HintConst::$No_obj_id;
        } elseif ($d['for_someone_type'] == '' || !is_numeric($d['for_someone_type'])) {
            $ErrCode = HintConst::$No_note_type_type;
        } elseif ($d['note_type_id'] == '' || !is_numeric($d['note_type_id'])) {
            $ErrCode = HintConst::$No_note_type_id;
        } elseif ($d['a_p_id'] == '' || !is_numeric($d['a_p_id'])) {
            $ErrCode = HintConst::$No_a_p_id;
        } else {
            if ($d['for_someone_id'] == HintConst::$Zero && $d['a_p_id'] != 0) {
                $ErrCode = HintConst::$No_for_someone_id;
            } elseif ($d['contents'] == '') {
                $ErrCode = HintConst::$NoContents;
            } elseif ($d['starttime'] == '' || !CommonFun::IsDate($d['starttime'])) {
                $ErrCode = HintConst::$No_starttime;
            } elseif ($d['endtime'] == '' || !CommonFun::IsDate($d['endtime'])) {
                $ErrCode = HintConst::$No_endtime;
            } else {
                $notes = new Notes();
                $result = $notes->AddNote($d);
                parent::myjsonencode($result);
            }
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    public function  actionGetnote()
    {
        parent::myjsonencode((new Notes())->Getnote());
    }
    public function  actionReply()
    {
        parent::myjsonencode((new NotesReplies())->Reply());
    }
    public function  actionGetreply()
    {
        return (new NotesReplies())->Getreply();
    }
    public function actionDel()
    {
        return (new Notes())->mydel();
    }
    public function actionNotedetail()
    {
        return json_encode((new Notes())->NoteDetail());
    }
    public function actionDelreply()
    {
        return (new NotesReplies())->Delreply();
    }
    public function actionDelrr()
    {
        return (new NotesReplies())->Delrr();
    }
    public function actionPass()
    {
        return (new Notes())->Pass();
    }
    public function actionGetnopass()
    {
        return json_encode((new Notes())->Getnopass());
    }
    public function actionGetuserforview()
    {
        return (new NotesView())->Getuserforview();
    }
    public function actionPushaddnote()
    {
        $school = [];
        $class = [];
        (new Notes())->getSchoolAndClassForNote($school, $class, $_POST);
        $custom = new Customs();
        $token = $custom->getToken($school, $class, [], $_POST['obj_id']);
        (new MultThread())->push_note($token, $_POST['id'], $_POST['title']);
    }
    public function  actionPushpass()
    {
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $reward = isset($_REQUEST['reward']) ? $_REQUEST['reward'] : 0;
        $con = isset($_REQUEST['con']) ? $_REQUEST['con'] : '';
        $user = explode('-', $user_id);
        (new Customs())->increaseF($user[0], 'points', $reward);
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_pass($token, $type, $id, $reward, $con);
    }
    public function  actionPushauditbyid()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $school = [];
        $class = [];
        $user = [];
        $d = [];
        $note = new Notes();
        $note->getSR($d, $id);
        $note->getSchoolAndClassForNote($school, $class, $d);
        $custom = new Customs();
        $token = $custom->getToken($school, $class, $user);
        (new MultThread())->push_note($token, $id, $title);
    }
}
