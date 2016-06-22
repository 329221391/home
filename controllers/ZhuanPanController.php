<?php

namespace app\controllers;

use app\models\ZhuanPan;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use app\modules\AppBase\base\HintConst;
use yii\db\Query;
use yii\web\Controller;
use Yii;
class ZhuanPanController extends Controller{

    public function actionEnter(){
        $connection = Yii::$app->db;
        if(Yii::$app->session['custominfo'] == null){
            return json_encode(['ErrCode'=>HintConst::$LoginPlease,'Message'=>'no login']);
        }

        //读出当前用户名和ID
        $custom_name = Yii::$app->session['custominfo']->custom->name_zh;
        $cid = Yii::$app->session['custominfo']->custom->id;
        $cat_default_id = Yii::$app->session['custominfo']->custom->cat_default_id;
        $current_time1 = time();
        //获得用户积分
        $query = new Query();
        $game_points = $query->select('game_points')->from('customs')->where(['id' => $cid])->one();
        $game_points = $game_points['game_points'];
        $scroll_info = $query->select('scroll_info')->from('zhuanpan_active')->where(['role'=>$cat_default_id])->one();

        //var_dump($game_points); exit;
        /*$score = 0;
        $query = new Query();
        $custom_score = $query->select('cat_default_id,points,coins')->from('customs')->where(['id'=>$cid])->one();
        if($cat_default_id != HintConst::$ROLE_HEADMASTER){
            $score = $custom_score['points'];
        }else{
            $score = $custom_score['coins'];
        }*/

        //获得最近一期的活动

        //查询当前活动的SQL语句

        $current_active = 'select * from zhuanpan_active where active_start_time < '.$current_time1.' && '.$current_time1.' < active_end_time and role = '.$cat_default_id;
        $ret = $connection->createCommand($current_active)->queryAll();
        //var_dump($ret); exit;
        //解析出开奖时间
         if ($ret) {
            $date_parse = date_parse(date('Y-m-d H:i',$ret[0]['active_start_time']));
            $end_time = date('Y-m-d H:i',$ret[0]['active_end_time']);
            $active = 1;
            //var_dump($ret); exit;
            return $this->render('enter',['ret'=>$ret,
                                          'custom_id'=>$cid,
                                          'custom_name'=>$custom_name,
                                          'game_points'=>$game_points,
                                          'cat_default_id'=>$cat_default_id,
                                          'date_parse'=>$date_parse,
                                          'end_time'=>$end_time,
                                          'active'=>$active,
                                          'scroll_info'=>$scroll_info]);

        } else {
            $recent_active = 'select * from zhuanpan_active where active_start_time >'.$current_time1." and role = ".$cat_default_id;
            $ret = $connection->createCommand($recent_active)->queryAll();

            if($ret){
                $date_parse = date_parse(date('Y-m-d H:i',$ret[0]['active_start_time']));
                $end_time = date('Y-m-d H:i',$ret[0]['active_end_time']);
                $active = 0;
               return $this->render('desire',['date_parse'=>$date_parse,
                                    'end_time'=>$end_time,
                                    'active'=>$active,
                                    'cat_default_id'=>$cat_default_id,
                                    'score'=>$game_points,
                                    'custom_name'=>$custom_name,
                                    'custom_id'=>$cid,
                                    'scroll_info'=>$scroll_info]);
            }
            
        }
    }                       

    private function div_user_score($custom_id){
        $query = new Query();
        $game_points=$query->select('game_points')->from('customs')->where(['id'=>$custom_id])->one();

 
        if($game_points['game_points'] < HintConst::$GAME_SUB_GAMEPOINTS) {
           return false;
        } elseif ($game_points['game_points'] >= HintConst::$GAME_SUB_GAMEPOINTS) {
            $connection = Yii::$app->db;
            $sql = 'update customs set game_points=game_points - '.HintConst::$GAME_SUB_GAMEPOINTS.' where id = '.$custom_id;
            $connection->createCommand($sql)->execute();
            return true;
        }
        
        /*$custom_score = $query->select('cat_default_id,points,coins')->from('customs')->where(['id'=>$custom_id])->one();
        if($custom_score['points'] < HintConst::$GAME_SUB_GAMEPOINTS && $custom_score['coins'] < HintConst::$GAME_SUB_GAMEPOINTS){
            return false;
        }else if($custom_score['cat_default_id'] == HintConst::$ROLE_HEADMASTER && $custom_score['coins'] >= HintConst::$GAME_SUB_GAMEPOINTS){
            $sql = 'update customs set coins=coins-'.HintConst::$GAME_SUB_GAMEPOINTS.' where id = '.$custom_id;
            $connection = Yii::$app->db;
            $connection->createCommand($sql)->execute();
            return true;
        }else if($custom_score['points'] >= HintConst::$GAME_SUB_GAMEPOINTS){
            $sql = 'update customs set points=points-'.HintConst::$GAME_SUB_GAMEPOINTS.' where id = '.$custom_id;
            $connection = Yii::$app->db;
            $connection->createCommand($sql)->execute();
            return true;
        } else {
            return false;
        }*/
    }
    public function actionLottery(){
        $request = Yii::$app->request;
        $active_id = $request->post('active_id',0);
        if(!$active_id){
            echo json_encode(['ErrCode'=>1,'Message'=>'active_id is error']);
            exit;
        }
        
        $connection = Yii::$app->db;
        $tx = $connection->beginTransaction();
        $goods = [];
		
        try{
            $cat_default_id = Yii::$app->session['custominfo']->custom->cat_default_id;

            $custom_id = Yii::$app->session['custominfo']->custom->id;

            $ret = $this->div_user_score($custom_id);
            //return json_encode(['ErrCode'=>1, 'Message'=>$ret]);
            if(!$ret){
                return json_encode(['ErrCode'=>HintConst::$SCORE_TOO_LOW,'Message'=>'score too low']);
            }

            $zhuanpan = new ZhuanPan($cat_default_id);
            $goods = $zhuanpan->run($active_id);

			if(!$goods){
				return json_encode(['ErrCode'=>1,'Message'=>'goods not found']);
			}
            if($goods['type'] == 1){
                //直接虚拟的值充值给用户
                $field = 'game_points';
                $sql = 'update customs set game_points = game_points + :value where id = :id';
                $connection->createCommand($sql,[
                    ':value'=>$goods['value'],
                    ':id'=>Yii::$app->session['custominfo']->custom->id
                    ])->execute();
                /*$field = 'points';
                if(Yii::$app->session['custominfo']->custom->cat_default_id == HintConst::$ROLE_HEADMASTER){
                    $field = 'coins';
                }
                $sql = "update customs set $field=$field + :value where id=:id";
                $connection->createCommand($sql,[
                    ':value'=>$goods['value'],
                    ':id'=>Yii::$app->session['custominfo']->custom->id
                ])->execute();*/
            }
            
            //插入中奖记录
            $connection->createCommand()->insert('custom_prize_log',[
                'zhuanpan_active_id'=>$goods['zhuanpan_active_id'],
                'custom_id'=>$custom_id,
                'order_id'=>date('YmdHis').mt_rand(100,999),
                'goods_id'=>$goods['id'],
                'goods_type'=>$goods['type'],
                'value'=>$goods['value'],
                'goods_name'=>$goods['prize'],
                'status'=>0,
                'create_time'=>time(),
                'image'=>$goods['image']
            ])->execute();
            $prize_log_id = $connection->getLastInsertID();
            $tx->commit();
        }catch(\Exception $e){
            $tx->rollBack();
            $ba = new BaseAnalyze();
            $ba->writeToAnal($e->getMessage().' file: '.$e->getFile().' at line:'.$e->getLine());
            return json_encode(['ErrCode'=>1,'Message'=>$e->getMessage().' file: '.$e->getFile().' at line:'.$e->getLine()]);
        }
        $query = new Query();
        $game_points = $query->select('game_points')->from('customs')->where(['id'=>$custom_id])->one();
        $game_points = $game_points['game_points'];
        /*$score = 0;
        if($cat_default_id == HintConst::$ROLE_HEADMASTER){
            $score = $custom['coins'];
        }else{
            $score = $custom['points'];
        }*/
        $goods['angle'] = mt_rand($goods['left'],$goods['right']);
        return json_encode(['ErrCode'=>0,'Content'=>$goods,'prize_log_id'=>$prize_log_id,'game_points'=>$game_points]);
    }

    public function actionShipping(){
        $custom_id = Yii::$app->session['custominfo']->custom->id;
        $prize_log_id = Yii::$app->request->get('prize_log_id',0);
        if($prize_log_id == 0) {
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'invalid prize_log_id']);
        }
        //查询收货地址
        $query = new Query();
        $shipping = $query->select('*')->from('custom_shipping')->where(['custom_id'=>$custom_id])->one();
        if(!$shipping){
            $shipping['shipping_address'] = '';
            $shipping['username'] = '';
            $shipping['mobile'] = '';
            $shipping['zipcode'] = '';
        }

        return $this->render('shipping',['shipping'=>$shipping,'prize_log_id'=>$prize_log_id]);
    }

    public function actionSave(){
        $shipping_address = Yii::$app->request->post('shipping_address','');
        $person_name = Yii::$app->request->post('person_name','');
        $mobile = Yii::$app->request->post('mobile','');
        $zipcode = Yii::$app->request->post('zipcode','');
        $prize_log_id = Yii::$app->request->post('prize_log_id',0);

        $query = new Query();
        $prize_log = $query->select('*')->from('custom_prize_log')->where(['id'=>$prize_log_id])->one();


        if(!$prize_log){
            return json_encode(['ErrCode'=>HintConst::$DATA_NOT_FOUND,'invalid prize_log_id']);
        }
        if($prize_log['status'] == 1){
            return json_encode(['ErrCode'=>HintConst::$NO_PERMISION,'Message'=>'status error,no permission']);
        }
        if($prize_log['custom_id'] != Yii::$app->session['custominfo']->custom->id){
            return json_encode(['ErrCode'=>HintConst::$NO_PERMISION,'Message'=>'no permission']);
        }
        if($prize_log['status'] == 1){
            return json_encode(['ErrCode'=>HintConst::$NO_PERMISION,'Message'=>'status is 1']);
        }
        $connection = Yii::$app->db;
        $connection->createCommand()->update('custom_prize_log',[
            'shipping_address'=>$shipping_address,
            'person_name'=>$person_name,
            'mobile'=>$mobile,
            'zipcode'=>$zipcode
        ],['id'=>$prize_log_id])->execute();

        return $this->render('success');
    }


    public function actionDetails(){
        $cid = Yii::$app->session['custominfo']->custom->id;
        $cat_default_id = Yii::$app->session['custominfo']->custom->cat_default_id;

        $query = new Query();
        $list = $query->select('t2.* ,t1.count')->from('zhuanpan_goods_active as t1')
            ->leftJoin('zhuanpan_goods as t2','t1.goods_id = t2.id')
            ->leftJoin('zhuanpan_active as t3','t3.id = t1.active_id')
            ->where([
            't3.role'=>$cat_default_id,
            't2.type'=>0
        ])->all();
        //var_dump($list); exit;
        return $this->render('detail',['goods_list'=>$list]);
    }    
}