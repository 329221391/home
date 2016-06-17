<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Classes\models\Classes;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\appbase\BaseExcel;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\otheraccess\OtherAccess;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
/**
 * CustomsController implements the CRUD actions for Customs model.
 */
class CustomsController extends BaseController
{
	public $enableCsrfValidation = false;
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
     * Lists all Customs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $name_zh = Yii::$app->request->post('name_zh');
        $phone = Yii::$app->request->post('phone');
        $password = Yii::$app->request->post('password');
        $class_id = Yii::$app->request->get('class_id');
        $field_type = Yii::$app->request->post('field_type') ? Yii::$app->request->post('field_type') : 1;
        $field = Yii::$app->request->post('field') ? Yii::$app->request->post('field') : "";
        (new BaseAnalyze())->writeToAnal($field_type . $field);
        $type = Yii::$app->request->get('type') ? Yii::$app->request->get('type') : 1;
        if ($type == 1) {
            $tem_name = 'index';
            $type_id = HintConst::$ROLE_TEACHER;
        } else {
            $tem_name = 'stu_index';
            $type_id = HintConst::$ROLE_PARENT;
        }
        $message = '';
/*        if ($name_zh || $phone || $password) {
            $message = '请填写完整信息';
        }*/
        //如果存在class_name 就添加班级
        if ($name_zh && $phone && $password) {
            //chachong
            $oa = new OtherAccess();
            $info = json_decode($oa->getNewUser(2), true);
            if ($info['ErrCode'] != HintConst::$Zero) {
                $message = $info['ErrCode'];
            } else {
                if (count((new Customs())->getRecordOne(HintConst::$Field_id . "=" . $info['Content']['id'])["Content"]) != 0) {
                    $message = '已经存在';
                } else {
                    $custom = new Customs;
                    $custom->id = $info['Content']['id'];
                    $custom->name_zh = $name_zh;
                    $custom->cat_default_id = HintConst::$ROLE_TEACHER;
                    $custom->school_id = Yii::$app->session['manage_user']['school_id'];
                    $custom->phone = $phone;
                    $custom->password = md5($password);
                    $custom->ispassed = HintConst::$YesOrNo_YES;
                    $custom->isdeleted = HintConst::$YesOrNo_NO;
                    $custom->iscansend = HintConst::$YesOrNo_NO;
                    $custom->isout = HintConst::$YesOrNo_NO;
                    $custom->createtime = date('Y-m-d H:i:s', time());
                    $custom->save(false);
                    $message = '添加成功';
                    $this->batDelMC();
                }
            }
        }
        $query = new Query();
        if ($type == 1) {
            $classes=new Classes();
            $class_list = $classes->getClassList(Yii::$app->session['manage_user']['school_id']);
            $role = HintConst::$ROLE_TEACHER;
            $user_list = $query->select('customs.*,classes.name as class_name')
                ->from('customs')
                ->leftjoin('classes', 'classes.teacher_id = customs.id')
                ->where(['customs.school_id' => Yii::$app->session['manage_user']['school_id'], 'customs.cat_default_id' => $type_id]);
            if ($field_type == 1) {
                $user_list = $query->andwhere(['like', 'name_zh', $field]);
            } elseif ($field_type == 2) {
                $user_list = $query->andwhere(['like', 'phone', $field]);
            }
        } else {

            $classes=new Classes();
            $class_list = $classes->getClassList(Yii::$app->session['manage_user']['school_id']);
            $role = HintConst::$ROLE_PARENT;
            $user_list = $query->select('customs.*,classes.name as class_name,classes.id as class_id')
                ->from('customs')
                ->leftjoin('classes', 'classes.id = customs.class_id')
                ->where(['customs.school_id' => Yii::$app->session['manage_user']['school_id'], 'customs.cat_default_id' => $type_id]);
            if ($field_type == 1) {
                $user_list = $query->andwhere(['like', 'name_zh', $field]);
            } elseif ($field_type == 2) {
                $user_list = $query->andwhere(['like', 'phone', $field]);
            }
        }
        if ($class_id) {
            $user_list = $query->andwhere(['customs.class_id' => $class_id]);
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);
        //全班学生人数 $total
        $total=$countQuery->count();
        //绑定红花总数 $rftoken_count
        $alluser = $query->all();
        $rftoken_count=0;
        foreach($alluser as $user){
            if($user['rftoken']!=''){
                $rftoken_count=$rftoken_count+1;
            }
        }
        $user_list = $query->offset($pages->offset)
            ->orderby(['id' => SORT_DESC])
            ->limit($pages->limit)
            ->all();
        //得到全班的统计数字
        $total=$countQuery->count();
        return $this->render($tem_name, [
            'models' => $user_list,
            'class_list'=>$class_list,
            'pages' => $pages,
            'message' => $message,
            'params' => ['field_type' => $field_type,
                'field' => $field,
                'role' => $role,
                'class_id' => $class_id,
                'isadmin' => isset(Yii::$app->session['admin_user']),
                'total'=>$total,
                'rftoken'=>$rftoken_count
            ]
        ]);
    }
    public function  actionUploadexcel()
    {
        $filename = UploadedFile::getInstanceByName('myname');
        $role = Yii::$app->request->post('role');
        $class_id = Yii::$app->request->post('class_id');
        if ($filename) {
            $xls = new BaseExcel();
            $result = $xls->import($filename, $role, $class_id);
        }
        return $this->render('uploadexcel', ['result' => $result]);
    }
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $custom = Customs::find()->where(['id' => $id, 'school_id' => Yii::$app->session['manage_user']['school_id']])->one();
        if (isset($custom->id) && $custom->id > 0) {
            if ($custom->cat_default_id == HintConst::$ROLE_PARENT) {
                $this->findModel($id)->delete();
                return $this->redirect(['index', 'type' => 2]);
            } else {
                $this->findModel($id)->delete();
                return $this->redirect(['index', 'type' => 1]);
            }
        } else {
            return $this->redirect(['index']);
        }
    }
    public function actionEditCustom($id)
    {
        $field = !empty($_REQUEST['field']) ? $_REQUEST['field'] : 0;
        $val = !empty($_REQUEST['val']) ? $_REQUEST['val'] : 0;
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        if ($field && $val && $id) {
            //验证id 是不是属于该管理员下的
            $mycustom = new Customs();
            $custom = Customs::findOne($id);
            if ($custom->school_id <= 0) {
                $result = ['error' => 1, 'message' => '没有该学校的信息', 'content' => ''];
                return (json_encode($result));
            }
            if ($custom->school_id <> Yii::$app->session['manage_user']['school_id']) {
                $result = ['error' => 1, 'message' => '没有权限修改其他学校班级的信息', 'content' => ''];
                return (json_encode($result));
            }
            switch ($field) {
                case 'name':
                    $_REQUEST['id'] = $id;
                    $_REQUEST['name_zh'] = $val;
                    json_decode($mycustom->UpdatenamezhA());
                    break;
                case 'phone':
                    $_REQUEST['id'] = $id;
                    $_REQUEST['phone'] = $val;
                    $re = json_decode($mycustom->UpdatephoneA());
                    if ($re->ErrCode != 0) {
                        $result = ['error' => 1, 'message' => '号码已经存在', 'content' => ''];
                        return (json_encode($result));
                    }
                    break;
                case 'ispassed':
                    $custom->ispassed = $val;
                    if($custom->ispassed == HintConst::$YesOrNo_YES){
                        $custom->isout = HintConst::$YesOrNo_NO;
                    }else{
                        $custom->isout = HintConst::$YesOrNo_YES;
                    }
                    $custom->save();
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => $val];
                    return (json_encode($result));
                    break;
                case 'iscansend':
                    $custom->iscansend = $val;
                    $custom->save();
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => $val];
                    return (json_encode($result));
                    break;
                case 'isdeleted':
                    $custom->delete();
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => $val];
                    return (json_encode($result));
                    break;
                case 'password':
                    $_REQUEST['id'] = $id;
                    $_REQUEST['password'] = md5($val);
                    json_decode($mycustom->UpdatepasswordA());
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => '点击修改密码'];
                    return (json_encode($result));
                    break;
                default:
                    break;
            }
            $result = ['error' => 0, 'message' => '更新成功', 'content' => $val . ''];
            return (json_encode($result));
        } else {
            $result = ['error' => 1, 'message' => '失败', 'content' => ''];
            return (json_encode($result));
        }
    }

    public function actionChangeclass(){
        $ErrCode = HintConst::$Zero;
        $Message = "Fail";
        $Content='';
        if(Yii::$app->request->isPost){
            $st_id = Yii::$app->request->post("st_id");
            $st_name = Yii::$app->request->post("st_name");
            $class_id = Yii::$app->request->post("class_id");
            $class_name = Yii::$app->request->post("class_name");
            $custom = new Customs();
            $custom->changeclass($class_id,$st_id);
                $Content = $class_name;
                $Message = "成功换班";
                $ErrCode = 1;
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => $Message, 'Content' => $Content];
            return json_encode($result);
    }
    protected function findModel($id)
    {
        if (($model = Customs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

