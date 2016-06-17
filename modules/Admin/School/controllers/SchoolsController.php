<?php

namespace app\modules\Admin\School\controllers;
use app\modules\Admin\Catalogue\models\Catalogue;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Location\models\Cities;
use app\modules\Admin\Location\models\Districts;
use app\modules\Admin\Location\models\Provinces;
use app\modules\Admin\School\models\Schools;
use app\modules\Admin\School\models\SchoolsSearch;
use app\modules\AppBase\base\appbase\Asyn;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\otheraccess\OtherAccess;
use app\modules\AppBase\base\xgpush\XgEvent;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * SchoolsController implements the CRUD actions for Schools model.
 */
class SchoolsController extends BaseController
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
     * Lists all Schools models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            if (isset(Yii::$app->session['admin_user'])) {
                $searchModel = new SchoolsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            } else {
                $url = Yii::$app->urlManager->createUrl(['Admin/admins/login']);
                return Yii::$app->getResponse()->redirect($url);
            }
        }
    }
    /**
     * Displays a single Schools model.
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
     * Creates a new Schools model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Schools();
            $model->ispassed = HintConst::$YesOrNo_NO;
            $model->isdeleted = HintConst::$YesOrNo_NO;
            $model->isout = HintConst::$YesOrNo_NO;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model, 'flag' => HintConst::$CREAT,
                ]);
            }
        }
    }
    /**
     * Updates an existing Schools model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ($this->checkAdminSession()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->ispassed == HintConst::$YesOrNo_YES) {
                    (new Customs())->UpdateF($model->headmaster_id, HintConst::$Field_ispassed, HintConst::$YesOrNo_YES);
                    (new Asyn())->InitSchool($id);
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model, 'flag' => HintConst::$UPDATE,
                ]);
            }
        }
    }
    /**
     * Deletes an existing Schools model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->checkAdminSession()) {
//        $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
    }
    /**
     * Finds the Schools model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schools the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Schools::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
    * 登录后园长获取学校班级老师家长信息
    */
    public function actionGetschoolgroupinfoAH()
    {
        $school = new Schools();
        $result = $school->GetschoolgroupinfoAH();
        parent::myjsonencode($result);
    }
    /*
   * 登录后老师获取学校班级老师家长信息
   */
    public function actionGetteachergroupinfoA()
    {
        $school = new Schools();
        $result = $school->getTeacherGroupInfoA();
        parent::myjsonencode($result);
    }
    /*
    * 登录后家长获取学校班级老师家长信息
    */
    public function actionGetparentgroupinfoA()
    {
        $school = new Schools();
        $result = $school->getParentGroupInfoA();
        parent::myjsonencode($result);
    }
    public function actionAudit()
    {
    }
    public function actionProvinceslist()
    {
        if ($val = $this->mc->get($this->mc_name_common)) {
            echo json_encode($val);
        } else {
            $provinces = new Provinces();
            $list = $provinces->getProvinceList();
            echo json_encode($list);
            $this->mc->addPer($this->mc_name_common, $list);
        }
    }
    public function actionCitieslist($zh_provines_id)
    {
        if ($val = $this->mc->get($this->mc_name_common)) {
            echo json_encode($val);
        } else {
            $cities = new Cities();
            $list = $cities->getCityList($zh_provines_id);
            echo json_encode($list);
            $this->mc->addPer($this->mc_name_common, $list);
        }
    }
    public function actionDistrictslist($zh_city_id)
    {
        if ($val = $this->mc->get($this->mc_name_common)) {
            echo json_encode($val);
        } else {
            $districts = new Districts();
            $list = $districts->getDistrictList($zh_city_id);
            echo json_encode($list);
            $this->mc->addPer($this->mc_name_common, $list);
        }
    }
    //web端园长注册
    public function actionApply($name, $qq, $zh_province_id, $zh_citie_id, $zh_district_id, $email, $tel, $name_zh, $phone, $address)
    {
        $oa = new OtherAccess();
        $info = json_decode($oa->getNewUser(), true);
        if ($info['ErrCode'] != HintConst::$Zero) {
            echo "对不起,您已经注册过了";
        } else {
            if (count((new Customs())->getRecordOne(HintConst::$Field_id . "=" . $info['Content']['id'])["Content"]) != 0) {
                echo "对不起,您已经注册过了";
            } else {
                $custom = new Customs();
                $custom->id = $info['Content']['id'];
                $custom->cat_default_id = HintConst::$ROLE_HEADMASTER;
                $custom->name_zh = $name_zh;
                $custom->phone = $phone;
                $custom->password = CommonFun::encrypt(HintConst::$DefPD);
                $custom->createtime = CommonFun::getCurrentDateTime();
                $custom->ispassed = HintConst::$YesOrNo_YES;
                $custom->isdeleted = HintConst::$YesOrNo_NO;
                $custom->isout = HintConst::$YesOrNo_NO;
                $custom->isstar = HintConst::$YesOrNo_NO;
                $custom->iscansend = HintConst::$YesOrNo_YES;
                $custom->save(false);
                $custom_id = $custom->attributes['id'];
                $school = new Schools();
                $school->name = $name;
                $school->qq = $qq;
                $school->zh_province_id = $zh_province_id;
                $school->zh_citie_id = $zh_citie_id;
                $school->zh_district_id = $zh_district_id;
                $school->email = $email;
                $school->tel = $tel;
                $school->address = $address;
                $school->headmaster_id = $custom_id;
                $school->ispassed = HintConst::$YesOrNo_YES;
                $school->isdeleted = HintConst::$YesOrNo_NO;
                $school->isout = HintConst::$YesOrNo_NO;
                $school->createtime = CommonFun::getCurrentDateTime();
                $school->save(false);
                $school_id = $school->attributes['id'];
                $custom_mo = $custom->findId($school->headmaster_id);
                $custom_mo->school_id = $school_id;
                $custom_mo->ispassed = HintConst::$YesOrNo_YES;
                $custom_mo->save(false);
                echo "1";
                $this->initSchoolLabe($school_id);
            }
        }
    }
    //院长手机端院长注册
    public function actionApplyA($name, $qq, $zh_province_id, $zh_citie_id, $zh_district_id, $email, $tel, $name_zh, $phone, $address)
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $oa = new OtherAccess();
        $info = json_decode($oa->getNewUser(), true);
        if ($info['ErrCode'] != HintConst::$Zero) {
            $ErrCode = HintConst::$AlreadExist;
            $Message = '对不起,您已经注册过了';
        } else {
            if (count((new Customs())->getRecordOne(HintConst::$Field_id . "=" . $info['Content']['id'])["Content"]) != 0) {
                $ErrCode = HintConst::$AlreadExist;
                $Message = '对不起,您已经注册过了';
            } else {
                $custom = new Customs();
                $custom->id = $info['Content']['id'];
                $custom->cat_default_id = HintConst::$ROLE_HEADMASTER;
                $custom->name_zh = $name_zh;
                $custom->phone = trim($phone);
                $custom->password = CommonFun::encrypt(HintConst::$DefPD);
                $custom->createtime = CommonFun::getCurrentDateTime();
                $custom->ispassed = HintConst::$YesOrNo_YES;
                $custom->isdeleted = HintConst::$YesOrNo_NO;
                $custom->isout = HintConst::$YesOrNo_NO;
                $custom->isstar = HintConst::$YesOrNo_NO;
                $custom->iscansend = HintConst::$YesOrNo_YES;
                $custom->save(false);
                $custom_id = $custom->attributes['id'];
                $school = new Schools();
                $school->name = $name;
                $school->qq = $qq;
                $school->zh_province_id = $zh_province_id;
                $school->zh_citie_id = $zh_citie_id;
                $school->zh_district_id = $zh_district_id;
                $school->email = $email;
                $school->tel = $tel;
                $school->address = $address;
                $school->headmaster_id = $custom_id;
                $school->ispassed = HintConst::$YesOrNo_YES;
                $school->isdeleted = HintConst::$YesOrNo_NO;
                $school->isout = HintConst::$YesOrNo_NO;
                $school->createtime = CommonFun::getCurrentDateTime();
                $school->save(false);
                $school_id = $school->attributes['id'];
                $custom_mo = $custom->findId($school->headmaster_id);
                $custom_mo->school_id = $school_id;
                $custom_mo->ispassed = HintConst::$YesOrNo_YES;
                $custom_mo->save(false);
                $this->initSchoolLabe($school_id);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
    private function initSchoolLabe($school_id)
    {
        $catlogue = new Catalogue();
        $CatalogueList = $catlogue->getCatalogueListAll(83, $school_id);
        if (count($CatalogueList) == 0) {
            (new Asyn())->InitSchool($school_id);
        }
    }

//    public function actionPush()
//    {
//        $Message = HintConst::$Success;
//        $Content = HintConst::$NULLARRAY;
//        $token = trim(Yii::$app->session['custominfo']->custom->token);
//        if (empty($token)) {
//            $ErrCode = HintConst::$No_token;
//        } else {
//            $re = XgPush::myPushAllAndroidForMsg('wo......', $token, 3);
//            $ErrCode = $re['ret_code'];
//        }
//        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
//        return json_encode($result);
//    }
    public function actionQuerytoken()
    {
        $ErrCode = HintConst::$Zero;
        $Message = HintConst::$Success;
        $Content = HintConst::$NULLARRAY;
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
        if (empty($token)) {
            $ErrCode = HintConst::$No_token;
        } else {
            $Content = XgEvent::myQueryInfoOfToken($token, 0);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
        return json_encode($result);
    }
}
