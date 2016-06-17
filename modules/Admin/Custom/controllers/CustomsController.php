<?php

namespace app\modules\Admin\Custom\controllers;
use app\modules\Admin\Custom\models\CusFocus;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Custom\models\CustomsSearch;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\otheraccess\OtherAccess;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * CustomsController implements the CRUD actions for Customs model.
 */
class CustomsController extends BaseController
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
     * Lists all Customs models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->checkAdminSession()) {
            $searchModel = new CustomsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionAndroidlogin()
    {
        $class_code = $_REQUEST['class_code'];
        $name_zh = $_REQUEST['name_zh'];
        $password = $_REQUEST['password'];
        $phone = $_REQUEST['phone'];
//      echo $_SESSION['customInfo']->getCustom()->name_zh;
        exit;
    }
    /**
     * Displays a single Customs model.
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
     * Creates a new Customs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->checkAdminSession()) {
            $model = new Customs();
            $model->cat_default_id = HintConst::$ROLE_PARENT;
            if (isset($_POST['Customs'])) {
                if ($model->checkPhone($_POST['Customs']['phone'])) {
                    $hint = "phone has existed!";
//                //todo 想弹窗,但实现不了.
//                echo "<script language='javascript'>alert(" + $hint + ")</script>";
                    echo $hint;
                } else {
                    foreach ($_POST['Customs'] as $key => $value) {
                        $model->$key = $value;
                    }
                    if ($model->cat_default_id == HintConst::$ROLE_HEADMASTER) {
                        $model->ispassed = HintConst::$YesOrNo_YES;
                        $model->iscansend = HintConst::$YesOrNo_YES;
                    } else {
                        $model->ispassed = HintConst::$YesOrNo_NO;
                        $model->iscansend = HintConst::$YesOrNo_NO;
                    }
                    $model->isdeleted = HintConst::$YesOrNo_NO;
                    $model->isout = HintConst::$YesOrNo_NO;
                    $model->isstar = HintConst::$YesOrNo_NO;
                    $model->password = CommonFun::encrypt($model->password);
                    $model->createtime = CommonFun::getCurrentDateTime();
                    $model->starttime = CommonFun::getCurrentDateTime();
                    $model->endtime = CommonFun::getCurrentDateTime();
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model, 'flag' => HintConst::$CREAT,
                ]);
            }
        }
    }
    /**
     * Updates an existing Customs model.
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
     * Deletes an existing Customs model.
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
     * Finds the Customs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
    * 手机端园长和教师和家长登录
    */
    public function actionLoginAH()
    {
        $ErrCode = HintConst::$Zero;
        $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
        $phone = trim($phone);
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
        $role = isset($_REQUEST['cat_default_id']) ? $_REQUEST['cat_default_id'] : '';
        if ($phone == '' || !is_numeric($phone)) {
            $ErrCode = HintConst::$NoPhone;
            $Message = "没有phone参数";
        } elseif ($role == '' || !is_numeric($role)) {
            $ErrCode = HintConst::$NoRole;
            $Message = "没有cat_default_id参数";
        } elseif ($password == '') {
            $ErrCode = HintConst::$NoPassword;
            $Message = "没有password参数";
        } else {
            $custom = new Customs();
            $result = $custom->LoginA($phone, $password, $role);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    /*
     * 获得登录者的相关信息
     */
    public function actionGetcustominfoA()
    {
        parent::myjsonencode((new Customs())->GetcustominfoAH());
    }
    /*
     * 园长的信息是我们添加的
    * 登录后添加老师的相关信息
    */
    public function actionAddteacherAH()
    {
        $ErrCode = HintConst::$Zero;
        $logo = !empty($_REQUEST['logo']) ? $_REQUEST['logo'] : '';
        $name_zh = !empty($_REQUEST['name_zh']) ? $_REQUEST['name_zh'] : '';
        $phone = !empty($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
        $description = !empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
        $iscansend = !empty($_REQUEST['iscansend']) ? $_REQUEST['iscansend'] : '';
        $isstar = !empty($_REQUEST['isstar']) ? $_REQUEST['isstar'] : '';
        if ($phone == '' || !is_numeric($phone)) {
            $ErrCode = HintConst::$NoPhone;
        } elseif ($iscansend == '' || !is_numeric($iscansend)) {
            $ErrCode = HintConst::$NoIsCanSend;
        } elseif ($isstar == '' || !is_numeric($isstar)) {
            $ErrCode = HintConst::$NoIsStar;
        } elseif ($name_zh == '') {
            $ErrCode = HintConst::$NoPassword;
        } else {
            $custom = new Customs();
            $result = $custom->addCustom($logo, $name_zh, $phone, $description, $iscansend, $isstar, HintConst::$ROLE_TEACHER);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    /*
     * 园长的信息是我们添加的
    * 添加家长的相关信息
    */
    public function actionAddparent()
    {
        $ErrCode = HintConst::$Zero;
        $data[HintConst::$Field_school_id] = !empty($_REQUEST[HintConst::$Field_school_id]) ? $_REQUEST[HintConst::$Field_school_id] : '';
        $data[HintConst::$Field_class_id] = !empty($_REQUEST[HintConst::$Field_class_id]) ? $_REQUEST[HintConst::$Field_class_id] : '';
        $data[HintConst::$Field_password] = !empty($_REQUEST[HintConst::$Field_password]) ? $_REQUEST[HintConst::$Field_password] : '';
        $data[HintConst::$Field_name_zh] = !empty($_REQUEST[HintConst::$Field_name_zh]) ? $_REQUEST[HintConst::$Field_name_zh] : '';
        $data[HintConst::$Field_phone] = !empty($_REQUEST[HintConst::$Field_phone]) ? $_REQUEST[HintConst::$Field_phone] : '';
        if ($data['school_id'] == '' || !is_numeric($data['school_id'])) {
            $ErrCode = HintConst::$NoSchoolId;
        } elseif ($data['class_id'] == '' || !is_numeric($data['class_id'])) {
            $ErrCode = HintConst::$NoClassesId;
        } elseif ($data['phone'] == '' || !is_numeric($data['phone'])) {
            $ErrCode = HintConst::$NoPhone;
        } elseif ($data['name_zh'] == '') {
            $ErrCode = HintConst::$NoNamezh;
        } elseif ($data['password'] == '') {
            $ErrCode = HintConst::$NoPassword;
        } else {
            $data[HintConst::$Field_cat_default_id] = HintConst::$ROLE_PARENT;
            $custom = new Customs();
            $result = $custom->addCustomParent($data);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    /*
      * 检查password
      */
    public function  actionCheckandsetpdA()
    {
        $ErrCode = HintConst::$Zero;
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $former_pd = !empty($_REQUEST['former_pd']) ? $_REQUEST['former_pd'] : '';
        $new_pd = !empty($_REQUEST['new_pd']) ? $_REQUEST['new_pd'] : '';
        if ($id == '' || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } elseif ($former_pd == '') {
            $ErrCode = HintConst::$NoFormerPd;
        } elseif ($new_pd == '') {
            $ErrCode = HintConst::$NoNewPd;
        } else {
            $custom = new Customs();
            $result = $custom->CheckAndSetPd($id, $former_pd, $new_pd);
            parent::myjsonencode($result);
        }
        if ($ErrCode != HintConst::$Zero) {
            $Message = HintConst::$NULL;
            $Content = HintConst::$NULLARRAY;
            echo(CommonFun::json($ErrCode, $Message, $Content));
        }
    }
    //手机端重置custom密码,园长和老师都可以重置,给定custom_id就可以了
    public function  actionResetpdA()
    {
        $oa = new OtherAccess();
        $re = $oa->ResetpdA();
        $info = json_decode($re);
        if ($info->ErrCode == HintConst::$Zero) {
            $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
            $v = HintConst::$DefPD;
            $this->CheckUpdateParamaA($id, HintConst::$Field_password, CommonFun::encrypt($v));
        } else {
            return $re;
        }
    }
    /*
    * 修改password
    */
    public function  actionUpdatepasswordA()
    {
        return (new Customs())->UpdatepasswordA();
    }
    /*
    * 修改name
    */
    public function  actionUpdatenameA()
    {
        $oa = new OtherAccess();
        $re = $oa->UpdatenameA();
        $info = json_decode($re);
        if ($info->ErrCode == HintConst::$Zero) {
            $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
            $v = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
            $this->CheckUpdateParamaA($id, HintConst::$Field_name, $v);
        } else {
            return $re;
        }
    }
    /*
    * 修改name_zh
    */
    public function  actionUpdatenamezhA()
    {
        return (new Customs())->UpdatenamezhA();
    }
    /*
     * 修改描述
     */
    public function  actionUpdatedescriptionA()
    {
        $oa = new OtherAccess();
        $re = $oa->UpdatedescriptionA();
        $info = json_decode($re);
        if ($info->ErrCode == HintConst::$Zero) {
            $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
            $v = !empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
            $this->CheckUpdateParamaA($id, HintConst::$Field_description, $v);
        } else {
            return $re;
        }
    }
    /*
    * 修改手机信息
    */
    public function  actionUpdatephoneA()
    {
        return (new Customs())->UpdatephoneA();
    }
    /*
    * 修改token
     * toketype分为android:0;ios:1
    */
    /*
* 修改token
*/
    public function  actionUpdatetokenA()
    {
        return (new Customs())->UpdatetokenA();
    }
    /*
    * 修改rftoken
    */
    public function  actionUpdaterftokenA()
    {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $v = !empty($_REQUEST['rftoken']) ? $_REQUEST['rftoken'] : '';
        $this->CheckUpdateParamaA($id, HintConst::$F_rftoken, trim($v));
    }
    /*
    * 修改logo
    */
    public function  actionUpdatelogoA()
    {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $v = !empty($_REQUEST['logo']) ? $_REQUEST['logo'] : '';
        $this->CheckUpdateParamaA($id, HintConst::$Field_logo, trim($v));
    }
    public function actionAddfocus()
    {
        $cus_focus = new CusFocus();
        $result = $cus_focus->Addfocus();
        return ($result);
    }
    public function actionCustinfo()
    {
        return (new Customs())->Custinfo();
    }
    public function actionEdit()
    {
        return (new Customs())->Edit();
    }
    public function actionGetprop()
    {
        return (new Customs())->Getprop();
    }
    public function actionGetcusbyf()
    {
        return (new Customs())->Getcusbyf();
    }
    public function actionGetisde()
    {
        return (new Customs())->Getisde();
    }
    public function actionGetlifelable()
    {
        return (new Customs())->Getlifelable();
    }
    public function  actionDeleteA()
    {
        return (new Customs())->mydel();
    }
}
