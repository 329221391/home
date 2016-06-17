<?php

namespace app\modules\manage\controllers;
use app\modules\Admin\Catalogue\models\Catalogue;
use app\modules\Admin\CatDefalut\models\CatDefalut;
use app\modules\AppBase\base\appbase\BaseController;
use Yii;
/**
 * SchoolsController implements the CRUD actions for Schools model.
 */
class CookBookController extends BaseController
{
    public function actionIndex()
    {
        $school_id = Yii::$app->session['manage_user']['school_id'];
        //获取今天的食谱数据
        $weekday = date('w', time() - 16 * 60 * 60);
        $query_indition = array();
        $query_indition = [96, 97, 98, 99, 100, 116, 117, 118, 119, 120, 126, 127, 128, 129, 130, 136, 137, 138, 139, 140, 147, 148, 149, 150, 160, 166, 167, 168, 169, 170, 176, 177, 178, 179, 180];
        $cook_info = [];
        foreach ($query_indition as $k => $v) {
            $cook_info[$v] = '待设置';
        }
        $query = new \yii\db\Query();
        $cook_list = $query->select('cat_default_id,name_zh')->from('catalogue')->where(['in', 'cat_default_id', $query_indition])->andwhere(['school_id' => $school_id])->orderby(['cat_default_id' => SORT_ASC])->all();
        if (is_array($cook_list) && count($cook_list) > 0) {
            //处理食谱数组
            foreach ($cook_list as $kk => $vv) {
                $cook_info[$vv['cat_default_id']] = $vv['name_zh'];
            }
        }
        return $this->render('index', [
            'cook_info' => $cook_info,
        ]);
    }
    public function actionEditCook()
    {
        $val = Yii::$app->request->get('val');
        $id = Yii::$app->request->get('id');
        $query_indition = [96, 97, 98, 99, 100, 116, 117, 118, 119, 120, 126, 127, 128, 129, 130, 136, 137, 138, 139, 140, 147, 148, 149, 150, 160, 166, 167, 168, 169, 170, 176, 177, 178, 179, 180];
        if (in_array($id, $query_indition) && $val && $id) {
            $catalogue = Catalogue::find()->where(['school_id' => Yii::$app->session['manage_user']['school_id'], 'cat_default_id' => $id])->one();
            //如果存在  就更新
            if (isset($catalogue->id) && $catalogue->id > 0) {
                $catalogue->name_zh = $val;
                $catalogue->updatetime = date('Y-m-d H:i:s');
                $catalogue->save();
            } else {
                //获取系统默认字段的值
                $cat_default = CatDefalut::findone($id);
                $catalogue = new Catalogue();
                $catalogue->school_id = Yii::$app->session['manage_user']['school_id'];
                $catalogue->cat_default_id = $id;
                $catalogue->name_zh = $val;
                $catalogue->name = $cat_default->name;
                $catalogue->parent_id = $cat_default->parent_id;
                $catalogue->path = $cat_default->path;
                $catalogue->createtime = date('Y-m-d H:i:s');
                $catalogue->updatetime = date('Y-m-d H:i:s');
                $catalogue->save();
                
            }
            $result = ['error' => 0, 'message' => '更新成功', 'content' => $val . ' </span>'];
            return(json_encode($result));
        } else {
            $result = ['error' => 0, 'message' => '更新成功', 'content' => $val . ' </span>'];
            return(json_encode($result));
        }
    }
}
