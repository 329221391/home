<?php

namespace app\modules\Admin\Vote\controllers;
use app\modules\Admin\Vote\models\Vote;
use app\modules\Admin\Vote\models\VoteOpt;
use app\modules\Admin\Vote\models\VoteOptStatus;
use app\modules\Admin\Vote\models\VoteSerach;
use app\modules\Admin\Vote\models\VoteSR;
use app\modules\Admin\Vote\models\VoteStatus;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * VoteController implements the CRUD actions for Vote model.
 */
class VoteController extends BaseController
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
     * Lists all Vote models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new VoteSerach();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Vote model.
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
     * Creates a new Vote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Vote();
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
     * Updates an existing Vote model.
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
     * Deletes an existing Vote model.
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
     * Finds the Vote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    //添加vote
    public function actionAddvote()
    {
        $vote = new Vote();
        $result = $vote->Addvote(CatDef::$mod['vote']);
        return ($result);
    }
    //添加vote选项
    public function actionAddvoteopt()
    {
        $voteopt = new VoteOpt();
        $result = $voteopt->Addvoteopt();
        return ($result);
    }
    //查询调查list by page
    public function actionGetvotelist()
    {
        $vote = new Vote();
        $result = $vote->Getvotelist();
        return ($result);
    }
    //添加用户投票
    public function actionAdduservote()
    {
        $voteuser = new VoteStatus();
        $result = $voteuser->Adduservote();
        return ($result);
    }
    //添加用户投票
    public function actionAdduservoteopt()
    {
        $voteoptuser = new VoteOptStatus();
        $result = $voteoptuser->Adduservoteopt();
        return ($result);
    }
//查询用户调查list by page
    public function actionGetuservoteyes()
    {
        $voteuser = new VoteStatus();
        $result = $voteuser->Getuservotelist(HintConst::$YesOrNo_YES);
        return ($result);
    }
    public function actionGetuservoteno()
    {
        $voteuser = new VoteStatus();
        $result = $voteuser->Getuservotelist(HintConst::$YesOrNo_NO);
        return ($result);
    }
    public function actionGetuservoteoptyes()
    {
        $voteoptuser = new VoteOptStatus();
        $result = $voteoptuser->Getuservotelist(HintConst::$YesOrNo_YES);
        return ($result);
    }
    public function actionGetuservoteoptno()
    {
        $voteoptuser = new VoteOptStatus();
        $result = $voteoptuser->Getuservotelist(HintConst::$YesOrNo_NO);
        return ($result);
    }

    public function actionGetsum()
    {
        $votesr = new VoteSR();
        $result = $votesr->getSum();
        return ($result);
    }
    public function actionGetdetail()
    {
        $vote = new Vote();
        $vote->setName('vote');
        $result = $vote->Getdetail();
        return ($result);
    }
    //查看用户是否已经投过票
    public function actionCheckuservote()
    {
        $votestatus = new VoteStatus();
        $result = $votestatus->Checkuservote();
        return ($result);
    }
    public function actionDel(){
        return (new Vote())->votedel();
    }
    public function actionDelopt(){
        return (new VoteOpt())->Delopt();
    }
    public function actionDeloo(){
        return (new VoteOpt())->Deloo();
    }

}
