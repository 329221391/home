<?php

namespace app\modules\Admin\CatalogueDes\controllers;
use app\models\EmojiCheck;
use app\modules\Admin\CatalogueDes\models\CatalogueDes;
use app\modules\Admin\CatalogueDes\models\CatalogueDesSearch;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
/**
 * CatalogueDesController implements the CRUD actions for CatalogueDes model.
 */
class CatalogueDesController extends Controller
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


    public function beforeAction($action){
        $request = \Yii::$app->getRequest();
        $content = '';
        if (!$request->getIsPost()) {
            $content = $request->getQueryString();
        } else {
            $content = $request->getBodyParams();
            if (empty($content)) {
                $content = $request->rawBody;
            }
        }

        if (is_array($content)) {
            foreach ($content as $item) {
                if (EmojiCheck::check($item)) {
                    echo json_encode(['ErrCode' => HintConst::$EMOJI_ERROR, 'Message' => 'Not Support Emoji']);
                    return false;
                }
            }
        } else {
            if (EmojiCheck::check($content)) {
                echo json_encode(['ErrCode' => HintConst::$EMOJI_ERROR, 'Message' => 'Not Support Emoji']);
                return false;
            }
        }
    }

    /**
     * Lists all CatalogueDes models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new CatalogueDesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single CatalogueDes model.
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
     * Creates a new CatalogueDes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new CatalogueDes();
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
     * Updates an existing CatalogueDes model.
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
     * Deletes an existing CatalogueDes model.
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
     * Finds the CatalogueDes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatalogueDes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogueDes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
