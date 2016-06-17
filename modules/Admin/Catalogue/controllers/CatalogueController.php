<?php

namespace app\modules\Admin\Catalogue\controllers;
use app\modules\Admin\Catalogue\models\Catalogue;
use app\modules\Admin\Catalogue\models\CatalogueSearch;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * CatalogueController implements the CRUD actions for Catalogue model.
 */
class CatalogueController extends BaseController
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
     * Lists all Catalogue models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new CatalogueSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    /**
     * Displays a single Catalogue model.
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
     * Creates a new Catalogue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Catalogue();
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
     * Updates an existing Catalogue model.
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
     * Deletes an existing Catalogue model.
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
     * Finds the Catalogue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Catalogue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catalogue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionAddcatalogueAH()
    {
        $ErrCode = HintConst::$Zero;
        $path = !empty($_REQUEST['path']) ? $_REQUEST['path'] : '';
        $name_zh = !empty($_REQUEST['name_zh']) ? $_REQUEST['name_zh'] : '';
        if ($name_zh == '') {
            $ErrCode = HintConst::$NoNamezh;
        } elseif ($path == '' || !is_numeric($path)) {
            $ErrCode = HintConst::$NoPath;
        } else {
            $catalogue = new Catalogue();
            $result = $catalogue->AddcatalogueAH($path, $name_zh);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    public function  actionDeleteA()
    {
        $ErrCode = HintConst::$Zero;
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id) || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            (new Catalogue())->del($id);
        }
        die(json_encode(array("ErrCode" => $ErrCode, "Message" => HintConst::$NULL, "Content" => HintConst::$NULLARRAY)));
    }
    public function  actionInitschoolmanual()//
    {//init school by manual
        echo "starting ...";
        try {
            for ($i = 1031; $i <= 1052; $i++) {
                echo $i;
                echo "<br>";
                (new Catalogue())->initCatlogue($i);
            }
            die("ok");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function  actionInitschool()
    {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        try {
            if (is_numeric($id) && $id != 0) {
                (new BaseAnalyze())->writeToAnal("school_id :" . $id);
                (new Catalogue())->initCatlogue($id);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
