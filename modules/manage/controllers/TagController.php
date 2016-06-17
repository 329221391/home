<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Catalogue\models\Catalogue;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;
/**
 * SchoolsController implements the CRUD actions for Schools model.
 */
class TagController extends BaseController
{
    public function actionIndex()
    {
        $need_arr = [181, 185, 198, 202, 227];
        $path_arr = ['181-', '185-', '198-', '202-', '227-'];
        $tag_value = Yii::$app->request->post('tag_value');
        $parent_id = Yii::$app->request->post('parent_id');
        $message = '';
        if ($tag_value && $parent_id) { //如果同时存在value 和id就添加标签
            //检查是不是目标id
            if (in_array($parent_id, $need_arr)) {
                $catalogue = new Catalogue();
                //$catalogue->cat_default_id = $parent_id;new add :no cat_defult_id
                $catalogue->school_id = Yii::$app->session['manage_user']['school_id'];
                $catalogue->parent_id = $parent_id;
                $catalogue->path = $parent_id . '-';
//			  $catalogue->name = $cat_default->name;//new add record:need to assign
                $catalogue->name_zh = $tag_value;
                $catalogue->createtime = date('Y-m-d H:i:s');
                $catalogue->updatetime = date('Y-m-d H:i:s');
                $catalogue->ispassed = HintConst::$YesOrNo_YES;
                $catalogue->isdeleted = HintConst::$YesOrNo_NO;
                $catalogue->save();
                $message = '添加成功';
                $this->batDelMC();
            }
        }
        $school_id = Yii::$app->session['manage_user']['school_id'];
        $tag_arr = [];
        $tag_arr['181']['tag_name'] = '饮食';
        $tag_arr['181']['arr'] = [];
        $tag_arr['185']['tag_name'] = '睡觉';
        $tag_arr['185']['arr'] = [];
        $tag_arr['198']['tag_name'] = '学习';
        $tag_arr['198']['arr'] = [];
        $tag_arr['202']['tag_name'] = '活动';
        $tag_arr['202']['arr'] = [];
        $tag_arr['227']['tag_name'] = '课程';
        $tag_arr['227']['arr'] = [];
        $query = new Query();
        $date_arr = $query->select('*')->from('catalogue')->where(['school_id' => $school_id, 'parent_id' => $need_arr,'isdeleted'=>HintConst::$YesOrNo_NO])->all();
        if (count($date_arr) > 0) {
            foreach ($date_arr as $kk => $vv) {
                $tag_arr[$vv['parent_id']]['arr'][] = $vv;
            }
        }
        return $this->render('index', ['tag_arr' => $tag_arr, 'message' => $message]);
    }
    public function actionDeleteTag()
    {
        $id = Yii::$app->request->get('id');
        //检查id是不是属于该学校下
        $tag = Catalogue::findone($id);
        if (isset($tag->school_id) && $tag->school_id == Yii::$app->session['manage_user']['school_id']) {
            $tag->delete();
        }
        $url = Yii::$app->urlManager->createUrl(['manage/tag']);
        return Yii::$app->getResponse()->redirect($url);
    }
}
