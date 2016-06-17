<?php

namespace app\modules\manage\controllers;

use Yii;
use app\modules\manage\model\School;
use app\modules\manage\model\Customs;
use app\modules\manage\model\SchoolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SchoolsController implements the CRUD actions for Schools model.
 */
class TestController extends Controller
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

 
    public function actionIndex()
    {	
 		$this->module->set_layout('main2');
		 return $this->render('index');
    }

 
   
	
}
