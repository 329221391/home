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

class ShippingController extends Controller
{

    public $enableCsrfValidation = false;
    public function actionIndex(){
        $request =  Yii::$app->request;
        $name_zh = $request->get('name_zh');
        $mobile_phone = $request->get('mobile_phone','');
        $shipping_person_name = $request->get('shipping_person_name','');
        $shipping_mobile = $request->get('shipping_mobile','');
        $goods_name = $request->get('goods_name','');
        //获得转盘奖品列表
        $query = new Query();
        $goods_list = $query->select('goods_name')->from('zhuanpan_goods')->where(['in', 'type', [0]])->all();

        $query = new Query();
        $list = $query->select('t1.*,t2.name_zh,t2.phone,t3.shipping_address,t3.person_name,t3.mobile,t3.zipcode,t3.post_type,t3.status,t3.shipping_start_time,shipping_end_time,t5.active_id,t4.brand,t4.purpose')
                      ->from('prize_order_goods as t1')
                      ->innerJoin('customs as t2', 't1.custom_id = t2.id')
                      ->innerJoin('prize_order as t3', 't1.order_id = t3.id')
                      ->innerJoin('zhuanpan_goods as t4','t1.goods_id = t4.id')
                      ->innerJoin('zhuanpan_goods_active as t5','t1.goods_id = t5.goods_id');
                      

        $query->andWhere('t2.phone like \'%'.$mobile_phone.'%\'');
        $query->andWhere('t2.name_zh like \'%'.$name_zh.'%\'');
        $query->andWhere('t3.person_name like \'%'.$shipping_person_name.'%\'');
        $query->andWhere('t3.mobile like \'%'.$shipping_mobile.'%\'');
        $query->andWhere('t1.goods_name like \'%'.$goods_name.'%\'');
        
        $query->groupBy(['t1.order_id','t1.goods_id'])
              ->orderBy('t1.create_time desc');
    
        $list=$query->all(); 
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count()]); 
        //var_dump($list); exit;
       
        $pages->defaultPageSize = 10;
        

        $list = $query->offset($pages->offset)->limit($pages->limit)->all();


        return $this->render('index',['list'=>$list,'pages'=>$pages,'goods_list'=>$goods_list,'params'=>['mobile_phone'=>$mobile_phone,'name_zh'=>$name_zh,'shipping_person_name'=>$shipping_person_name,'shipping_mobile'=>$shipping_mobile],'goods_name'=>$goods_name]);
    }

/*    public function actionChangeState(){
        $ids = Yii::$app->request->post('ids',[]);
        $conn = Yii::$app->db;
        $ret = $conn->createCommand()->update('prize_order',['status'=>1],['in','id',$ids])->execute();
        if($ret > 0 ){
            $startTime = time();
            $conn->createCommand()->update('prize_order',['shipping_start_time'=>$startTime],['in','id',$ids])->execute();
            return json_encode(['ErrCode'=>0]);
        }
        else{
            var_dump($ret); exit;
            return json_encode(['ErrCode'=>1,'Message'=>'所选奖品已经发货了哟~']);
        }
    }*/


    public function actionChangeState(){
        $ids = Yii::$app->request->post('ids',[]);
        $conn = Yii::$app->db;
        $ret = $conn->createCommand()->update('prize_order',['status'=>1],['in','id',$ids])->execute();
        if($ret > 0 ){
            $startTime = time();
            $conn->createCommand()->update('prize_order',['shipping_start_time'=>$startTime],['in','id',$ids])->execute();
            return json_encode(['ErrCode'=>0]);
        }
        else{
            return json_encode(['ErrCode'=>1,'Message'=>'所选奖品已经发货了哟~']);
        }
    }



    public function actionDetail(){
        $id = Yii::$app->request->get('id',0);
        $conn = Yii::$app->db;
        $query = new Query();
        if($id == 0){
            return '';
        } else{

            $list = $query->select('t1.*,t2.name_zh,t2.phone,t3.*,t5.active_id,t4.brand,t4.purpose')
                  ->from('prize_order_goods as t1')
                  ->leftJoin('customs as t2', 't1.custom_id = t2.id')
                  ->rightJoin('prize_order as t3', 't1.order_id = t3.id')
                  ->leftJoin('zhuanpan_goods as t4','t1.goods_id = t4.id')
                  ->leftJoin('zhuanpan_goods_active as t5','t1.goods_id = t5.goods_id')
                  ->where(['t3.id'=>$id])
                  ->one();
                  
                //获得几期抽奖活动
                $query = new Query();
                $active_name = $query->select('description')->from('zhuanpan_active')->where(['id'=>$list['active_id']])->one();
                //var_dump($list); exit;
                return $this->render('detail',['list'=>$list,'active_name'=>$active_name]);
            } 
    }

    public function actionClose(){
        $id = Yii::$app->request->get('id',0);
        $conn = Yii::$app->db;
        $endTime = time();
        $conn->createCommand()->update('prize_order',['shipping_end_time'=>$endTime],['in','id',$id])->execute();
        $command = $conn->createCommand("SELECT * FROM prize_order WHERE id=$id");
        $list = $command->queryOne();
        //var_dump($list); exit;
        return $this->render('close',['list'=>$list]);
    }

/*public function actionPrizeList(){       
        $id = Yii::$app->request->get('id',0);
        $conn = Yii::$app->db;
        $query = new Query();
        if($id == 0){
            return '';
        } else{
            $list = $query->select('*')->from('custom_prize_log as t1')->leftJoin('zhuanpan_goods as t2','t2.id = t1.goods_id')->leftJoin('customs as t3','t3.id = t1.custom_id')->where(['t1.id'=>$id])->all();
                return $this->render('prize-list',['list'=>$list]);
        } 
    }*/
}
