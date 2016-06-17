<?php

namespace app\modules\Stats\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\db\Query;
use yii\data\Pagination;

class PrizeGoodsController extends Controller
{

    public $enableCsrfValidation = false;
    public function actionIndex(){
        $request =  Yii::$app->request;
        $name_zh = $request->post('name_zh','');
        $phone = $request->post('phone','');
        $goods_name = $request->post('goods_name','');
        
        //获得转盘奖品列表
        $query = new Query();
        $goods_list = $query->select('goods_name')->from('zhuanpan_goods')->where(['not in', 'type', [2]])->all();
        //获得中奖奖品
        $query = new Query();
        $query->select('t1.image,t1.create_time,t2.name_zh,t2.phone,t3.goods_name,t3.brand,t3.purpose, t4.description')
                      ->from('custom_prize_log as t1')
                      ->leftJoin('customs as t2', 't1.custom_id = t2.id')
                      ->leftJoin('zhuanpan_goods as t3','t1.goods_id = t3.id')
                      ->leftJoin('zhuanpan_active as t4','t1.zhuanpan_active_id = t4.id')
                      ->where(['not in','goods_type', [2]])
                      //->andWhere('t1.status = 0')
                      //->groupBy('t1.goods_id')

                      ->orderBy('t1.create_time desc');
        

        if (!$request->getIsPost()) {
            //$list = $query->all();
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $pages->defaultPageSize = 10;
            $list = $query->offset($pages->offset)->limit($pages->limit)->all();
            return $this->render('index',['list'=>$list,'pages'=>$pages,'params'=>['goods_list'=>$goods_list, 'name_zh'=>$name_zh, 'phone'=>$phone,'goods_name'=>$goods_name]]);
        }
        
        $query->andWhere('t2.phone like \'%'.$phone.'%\'');
        $query->andWhere('t2.name_zh like \'%'.$name_zh.'%\'');
        $query->andWhere('t1.goods_name like \'%'.$goods_name.'%\'');

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 10;
        $list = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('index',['list'=>$list,'pages'=>$pages,'params'=>['goods_list'=>$goods_list, 'name_zh'=>$name_zh, 'phone'=>$phone,'goods_name'=>$goods_name]]);
    }
}