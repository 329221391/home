<?php

namespace app\modules\manage\controllers;
use app\models\EmojiCheck;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\web\Controller;
class DefaultController extends Controller
{


    public function beforeAction($action)
    {

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
        return true;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    //得到首页的提示
    public function actionGetPrama()
    {
        $user_id = Yii::$app->session['manage_user']['id'];
        $school_id = Yii::$app->session['manage_user']['school_id'];
        $result = ['dswz' => 0, 'dstp' => 0, 'dspj' => 0, 'ywxg' => 0]; //待审文章  待审图片  待审评价
        //检查自己发表的文章是不是有新回复
        $query = new \yii\db\Query();
        $check_wz_reply = $query->select('count(*) as number')
            ->from('article_replies')
            ->leftjoin('articles', 'article_replies.article_id = articles.id')
            ->where(['articles.author_id' => $user_id, 'articles.article_type_id' => HintConst::$ARTICLE_PATH, 'article_replies.isview' => HintConst::$YesOrNo_NO, 'articles.ispassed' => HintConst::$YesOrNo_YES, 'articles.isdelete' => HintConst::$YesOrNo_NO])
            ->one();
        if ($check_wz_reply['number'] > 0) {
            $result['ywxg'] = $check_wz_reply['number'];
        }
        //检查 是不是有新的待审核文章
        $query = new \yii\db\Query();
        $check_dsh = $query->select('count(*) as number')
            ->from('articles')
            ->where(['articles.school_id' => $school_id, 'ispassed' => HintConst::$YesOrNo_NO, 'article_type_id' => HintConst::$ARTICLE_PATH, 'isdelete' => HintConst::$YesOrNo_NO])
            ->one();
        if ($check_dsh['number'] > 0) {
            $result['dswz'] = $check_dsh['number'];
        }
        //检查 是不是有新的待审图片
        $query = new \yii\db\Query();
        $check_dsh = $query->select('count(*) as number')
            ->from('article_attachment as aa')
            ->leftjoin('articles', 'articles.id = aa.article_id')
            ->where(['articles.school_id' => $school_id, 'articles.article_type_id' => HintConst::$HIGHLIGHT_PATH_NEW, 'aa.ispassed' => HintConst::$YesOrNo_NO])
            ->one();
        if ($check_dsh['number'] > 0) {
            $result['dstp'] = $check_dsh['number'];
        }
        //检查 是不是有新的待审核评价
        $query = new \yii\db\Query();
        $check_dsh = $query->select('count(*) as number')
            ->from('articles')
            ->where(['articles.school_id' => $school_id, 'ispassed' => HintConst::$YesOrNo_NO, 'article_type_id' => HintConst::$YUEPINGJIA_PATH])
            ->orwhere(['articles.school_id' => $school_id, 'ispassed' => HintConst::$YesOrNo_NO, 'article_type_id' => HintConst::$NIANPINGJIA_PATH])
            ->one();
        if ($check_dsh['number'] > 0) {
            $result['dspj'] = $check_dsh['number'];
        }
        return (json_encode($result));
    }
    //分类树返回顶级数组
    public function actionGetTree()
    {
        $school_id = Yii::$app->session['manage_user']['school_id'];
        $result[] = ['id' => 'ALL', 'text' => '全部成员'];
        $result[] = ['id' => 'ALL_TEACHER', 'text' => '全部老师', 'children' => false];
        $result[] = ['id' => 'ALL_STUDENT', 'text' => '全部学生', 'children' => false];
        $query = new \yii\db\Query;
        $stu_list = $query->select('id,name as text')->from('classes')->where(['school_id' => $school_id, 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO])->all();
        if (is_array($stu_list) && count($stu_list) > 0) {
            foreach ($stu_list as $key => $value) {
                $stu_list[$key]['id'] = 'CLASS' . $value['id'];
                $query = new \yii\db\Query;
                $list = $query->select('id,name_zh as text')->from('customs')->where(['class_id' => $value['id'], 'ispassed' => HintConst::$YesOrNo_YES, 'isdeleted' => HintConst::$YesOrNo_NO, 'cat_default_id' => HintConst::$ROLE_PARENT])->all();
                $stu_list[$key]['children'] = $list;
            }
        }
        $result = array_merge($result, $stu_list);
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }
    //用于检索用户
    public function actionSearchName()
    {
        //$id = isset($_REQUEST['id'])&& is_numeric($_REQUEST['id'])?$_REQUEST['id']:0;
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : 0;
        $school_id = Yii::$app->session['manage_user']['school_id'];
        if ($q) {
            // 得到学生的列表
            $query = new \yii\db\Query;
            $stu_list = $query->select('id,name_zh as name')->from('customs')->where(['like', 'name_zh', $q])->andwhere(['school_id' => $school_id])->andwhere(['>', 'school_id', 0])->all();
            return (json_encode($stu_list));
        } else {
            return (json_encode([]));
        }
    }
    // 登录
    public function actionLogin()
    {
        //更改显示的基本模板
        $this->module->set_layout('main2');
        if (isset(Yii::$app->session['manage_user'])) {
            $url = Yii::$app->urlManager->createUrl(['manage/default/index']);
            return Yii::$app->getResponse()->redirect($url);
        } else {
            $user_name = isset($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : 0;
            $password = isset($_REQUEST['password']) ? trim($_REQUEST['password']) : 0;
            if ($user_name && $password) {
                //检查是不是正确
                $user = Customs::find()->asarray()
                    ->where(['phone' => $user_name, 'password' => md5($password), 'cat_default_id' => HintConst::$ROLE_HEADMASTER])
                    ->one();
                //检查不通过 就返回密码不对的用户提示
                if ($user && is_array($user) && $user['id'] > 0) {
                    //检查是不是通过审核  可以使用
                    if ($user['ispassed'] == HintConst::$YesOrNo_NO) {
                        return $this->render('login', ['message' => '账号未通过审核，耐心等待管理员审核']);
                    }
                    //建立session  要跟其他地方的不同
                    Yii::$app->session['manage_user'] = $user;
                    $url = Yii::$app->urlManager->createUrl(['manage/article']);
                    return Yii::$app->getResponse()->redirect($url);
                } else {
                    return $this->render('login', ['message' => '账号不正确，请查证后再登录']);
                }
            } else {
                return $this->render('login');
            }
        }
    }
    //退出登录
    public function actionLoginOut()
    {
        Yii::$app->session->destroy();
        $url = Yii::$app->urlManager->createUrl(['manage/']);
        return Yii::$app->getResponse()->redirect($url);
    }
}
