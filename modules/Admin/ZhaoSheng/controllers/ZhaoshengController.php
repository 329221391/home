<?php


namespace app\modules\Admin\ZhaoSheng\controllers;
use app\modules\AppBase\base\appbase\BaseController;

use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\Url;
use Yii;

class ZhaoshengController extends BaseController{


    /**
     * 获取园所招生信息接口
     * @return string
     */
    public function actionIndex(){
        $page = Yii::$app->request->get('page','');
        $school_id = $this->getCustomSchool_id();
        $query = new Query();
        $query->select('id,title,img_url,create_time')
            ->from('zhaosheng')
            ->where(['school_id'=>$school_id]);
        //$countQuery = clone $query;
        $page_size = 20;
        $offset = $page_size * ($page-1);
        //$pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);



        $zhaopin_list = $query->orderBy(['id'=>SORT_DESC])->offset($offset)->limit($page_size)->all();
        foreach ($zhaopin_list as &$item) {
            $item['url'] = Url::to('index.php?r=zhaosheng/view&id='.$item['id'],true);
            $item['create_time'] = date('Y-m-d H:i',$item['create_time']);
            if(empty($item['img_url'])){
                $item['img_url'] = Url::to('/images/default_zhaosheng.png',true);
            }
        }
        $result = ['ErrCode' => 0, 'Message' => '', 'Content' => $zhaopin_list];
        return json_encode($result);
    }


}