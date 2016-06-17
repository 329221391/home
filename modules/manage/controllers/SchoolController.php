<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\BaseController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
/**
 * SchoolsController implements the CRUD actions for Schools model.
 */
class SchoolController extends BaseController
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
        $id = Yii::$app->session['manage_user']['school_id'];
        $user_id = Yii::$app->session['manage_user']['id'];
        //得到当前用户的学校信息
        return $this->render('view', [
            'school' => $this->findModel($id),
            'master' => Customs::myfindid($user_id),
        ]);
    }
    public function actionUpdate()
    {
        $id = Yii::$app->session['manage_user']['school_id'];
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionEditSchool()
    {
        $field = !empty($_REQUEST['field']) ? $_REQUEST['field'] : 0;
        $val = !empty($_REQUEST['val']) ? $_REQUEST['val'] : 0;
        $id = Yii::$app->session['manage_user']['school_id'];
        if ($field && $val && $id) {
            switch ($field) {
                case 'phone':
                    //检查手机号 是不是合规格  然后更新
                    $school = Schools::findOne($id);
                    $school->phone = $val;
                    $school->save();
                    break;
                case 'name':
                    //检查手机号 是不是合规格  然后更新
                    $school = Schools::findOne($id);
                    $school->name = $val;
                    $school->save();
                    break;
                case 'tel':
                    //检查手机号 是不是合规格  然后更新
                    $school = Schools::findOne($id);
                    $school->tel = $val;
                    $school->save();
                    break;
                case 'qq':
                    //检查手机号 是不是合规格  然后更新
                    $school = Schools::findOne($id);
                    $school->qq = $val;
                    $school->save();
                    break;
                case 'email':
                    //检查手机号 是不是合规格  然后更新
                    $school = Schools::findOne($id);
                    $school->email = $val;
                    $school->save();
                    break;
                case 'address':
                    //检查手机号 是不是合规格  然后更新
                    $school = Schools::findOne($id);
                    $school->address = $val;
                    $school->save();
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
    public function actionEditCustom()
    {
        $custom = new Customs();
        $field = !empty($_REQUEST['field']) ? $_REQUEST['field'] : 0;
        $val = !empty($_REQUEST['val']) ? $_REQUEST['val'] : 0;
        $id = Yii::$app->session['manage_user']['id'];
        if ($field && $val && $id) {
            switch ($field) {
                case 'phone':
                    //检查手机号 是不是合规格  然后更新,不用检测了,有人还想使用qq号码呢!什么需求,
                    $_REQUEST['id'] = $id;
                    $_REQUEST['phone'] = $val;
                    $re = json_decode($custom->UpdatephoneA());
                    if ($re->ErrCode != 0) {
                        $result = ['error' => 1, 'message' => '号码已经存在', 'content' => ''];
                        return (json_encode($result));
                    }
                case 'name_zh':
                    $_REQUEST['id'] = $id;
                    $_REQUEST['name_zh'] = $val;
                    json_decode($custom->UpdatenamezhA());
                    break;
                case 'password':
                    //
                    $_REQUEST['id'] = $id;
                    $_REQUEST['password'] = md5($val);
                    json_decode($custom->UpdatepasswordA());
                    $result = ['error' => 0, 'message' => '更新成功', 'content' => '点击修改密码 </span>'];
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
    protected function findModel($id)
    {
        if (($model = Schools::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The cccccccccccc page does not exist.');
        }
    }
}
