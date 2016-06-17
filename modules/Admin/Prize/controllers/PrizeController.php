<?php


namespace app\modules\Admin\Prize\controllers;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;

class PrizeController extends BaseController{

    public $needs = 20;

    public function actionList(){
        $connection = Yii::$app->db;
        //得到用户要兑换邮费的积分数
        $exPostage = Yii::$app->request->post('exPostage','');
        $custom_id = Yii::$app->session['custominfo']->custom->id;
        $page = Yii::$app->request->get('page',1);
        $size = Yii::$app->request->get('size',10);
        $offset = ($page-1) * $size;
        //获得邮费总和
            //得到奖品邮费券
        //$prizePostage = $query->select('*')->from('custom_prize_log')->where(['custom_id' => $custom_id])->andWhere(['goods_type' => 3])->count();
        //得到用积分已兑换的邮费
        //$exchangePostage = $query->select('postage')->from('customs')->where(['id' => $custom_id])->one();
        
        //查询已中奖列表
        $query = new Query();
        $ready_shipping = $query->select('cpl.*,count(cpl.goods_id) as count,zg.brand,zg.purpose,zg.image')
            ->from('custom_prize_log as cpl')
            ->innerJoin('zhuanpan_goods as zg','cpl.goods_id = zg.id')
            ->where(['custom_id'=>$custom_id,'goods_type'=>0,'status'=>0])
            ->groupBy('cpl.goods_id')
            ->offset($offset)
            ->limit($size)
            ->orderBy('id desc')
            ->all();

            /*if (empty($ready_shipping)) {
                return $this->render('list_empty');
            }*/
            $query=new Query();
            $delivered_list = $query->select('cpl.*,count(cpl.goods_id) as count,zg.brand,zg.purpose,zg.image')
            ->from('custom_prize_log as cpl')
            ->innerJoin('zhuanpan_goods as zg','cpl.goods_id = zg.id')
            ->where(['custom_id'=>$custom_id,'goods_type'=>0,'status'=>1])
            ->groupBy('goods_id')
            ->offset($offset)
            ->limit($size)
            ->orderBy('id desc')
            ->all();
            
//var_dump($delivered_list); exit;


            //得到奖品邮费券
            $query = new Query();
            $prizePostage = $query->select('sum(value) as postage')->from('custom_prize_log')->where(['custom_id' => $custom_id])->andWhere(['goods_type' => 3])->andWhere(['status' => 0])->one();
            //得到积分兑换的邮费
            $exchangePostage = $query->select('postage')->from('customs')->where(['id' => $custom_id])->one();
            //求邮费和
            $sumPostage = (int)$prizePostage['postage'] +  $exchangePostage['postage'];
            //假设20元邮费才能包邮
            $owePostage = $this->needs - $sumPostage;
        return $this->render('list',['ready_shipping'=>$ready_shipping,'delivered_list'=>$delivered_list, 'sumPostage'=>$sumPostage,'owePostage'=>$owePostage]);
    }

    public function actionDeliver(){
        $custom_id = Yii::$app->session['custominfo']->custom->id;
        //$needs = 20;
        $request = Yii::$app->request;
        //接收邮费付款方式
        if (!Yii::$app->request->getIsPost()) {
            $post_type = $request->get('post_type');
        } else {
            $post_type = $request->post('post_type');
        }
        
        //var_dump($post_type); exit;
        //查询邮费
        //邮费券
        $query = new Query();
        $postage1 = $query->select('sum(value) as postage')
            ->from('custom_prize_log')
            ->where(['custom_id'=>$custom_id,'goods_type'=>3,'status'=>0])
            ->groupBy('custom_id')
            ->one();
        $postage1 = $postage1['postage'];
        //兑换的邮费
        $query = new Query();
        $user = $query->select('postage')->from('customs')->where(['id'=>$custom_id])->one();
        $postage2 = $user['postage'];
        $postage = $postage1 + $postage2;
        //var_dump($post_type); exit;
        //发货类型选择为包邮，并且邮费不够时转提醒页面
        if($postage < $this->needs && $post_type == 0){
            return json_encode(['ErrCode'=>HintConst::$POSTAGE_NOT_ENUGH,'Message'=>'postage is not enugh']);
        }

        $save_shipping_flag=0;
        if(!Yii::$app->request->getIsPost()){
            //读取收货地址
            $query = new Query();
            $shipping = $query->select('*')
                ->from('custom_shipping')
                ->where(['custom_id'=>$custom_id])
                ->one();
                 
            if (empty($shipping)) {
                $save_shipping_flag=1;
                $shipping['shipping_address']='';
                $shipping['username']='';
                $shipping['mobile']='';
                $shipping['zipcode']='';
            }
            //var_dump($post_type); exit;
            return $this->render('deliver',['postage'=>$postage,'shipping'=>$shipping,'save_shipping_flag'=>$save_shipping_flag,'post_type'=>$post_type]);
        }

        $shipping_address = Yii::$app->request->post('shipping_address','');
        $person_name = Yii::$app->request->post('person_name','');
        $mobile = Yii::$app->request->post('mobile','');
        $zipcode = Yii::$app->request->post('zipcode','');

        if(empty($shipping_address)){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'shipping_address can not be null']);
        }

        if(empty($person_name)){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'person_name can not be null']);
        }

        if(empty($mobile)){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'mobile can not be null']);
        }

        if(empty($zipcode)){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'zipcode can not be null']);
        }

        //查询要发货的商品列表，
        $query = new Query();
        $goods_list = $query->select('goods_id,goods_name,count(goods_id) as count')->from('custom_prize_log')->where([
            'custom_id'=>$custom_id,
            'goods_type'=>0,
            'status'=>0,
        ])->groupBy('goods_id')->all();
        if(empty($goods_list)){
            //返回到中奖列表页面
            return json_encode(['ErrCode'=>HintConst::$PRIZE_GOODS_LSIT_EMPTY,'Message'=>'goods list is empty']);
        }

        $connection = Yii::$app->db;
        $tx = $connection->beginTransaction();
        try{
            //包邮
            if ($post_type == 0) {
                //减去相应的邮费
                //先减去邮费券的邮费
                $query = new Query();
                $youfeiquan = $query->select('id,value')
                    ->from('custom_prize_log')
                    ->where(['custom_id'=>$custom_id,'goods_type'=>3,'status'=>0])
                    ->all();
                $temp = 0;
                $ids = [];

                for($i =0;$i<count($youfeiquan);$i++){
                    $item = $youfeiquan[$i];
                    $temp += $item['value'];
                    $ids[] = $item['id'];

                    if($temp >= $this->needs){
                        break;
                    }
                }
                //更新custom_prize_log中的邮费券状态为使用
                $connection->createCommand()->update('custom_prize_log',['status'=>1],['in','id',$ids])->execute();

                //如果邮费券不够，用customs表的postage顶
                $left = $temp - $this->needs;
                if($left < 0){
                    $left = abs($left);
                    $left = $user['postage'] - $left;
                    $connection->createCommand()->update('customs',['postage'=>$left],['id'=>$custom_id])->execute();
                }
            }

            //到这里邮费就扣除完毕了，处理待发货的商品为发货状态,并创建发货单
            $connection->createCommand()->insert('prize_order',[
                'shipping_address'=>$shipping_address,
                'person_name'=>$person_name,
                'mobile'=>$mobile,
                'post_type'=>$post_type,
                'zipcode'=>$zipcode,
                'custom_id'=>$custom_id,
                'create_time'=>time(),
                'status'=>0,
            ])->execute();

            $order_id = $connection->getLastInsertID();

            //创建订单详情
            $insert_rows = [];
            $now = time();
            foreach ($goods_list as $goods) {
                $insert_rows[] = [
                    'custom_id'=>$custom_id,
                    'order_id'=>$order_id,
                    'goods_id'=>$goods['goods_id'],
                    'goods_name'=>$goods['goods_name'],
                    'count'=>$goods['count'],
                    'create_time'=>$now
                ];
            }
            unset($goods_list);
            $connection->createCommand()->batchInsert(
                'prize_order_goods',
                ['custom_id','order_id','goods_id','goods_name','count','create_time'],
                $insert_rows
            )->execute();
            //更新中奖商品的状态
            $connection->createCommand()->update('custom_prize_log',['status'=>1],['status'=>0,'custom_id'=>$custom_id,'goods_type'=>0])->execute();
            $tx->commit();
            return $this->render('success');
        }catch(\Exception $e){
            $tx->rollBack();
        }
    }
    
    public function actionSave(){
        $custom_id = Yii::$app->session['custominfo']->custom->id;
        $shipping_address = Yii::$app->request->post('shipping_address','');
        $username = Yii::$app->request->post('username','');
        $mobile = Yii::$app->request->post('mobile','');
        $zipcode = Yii::$app->request->post('zipcode','');
        $connection = Yii::$app->db;
        $tx=$connection->beginTransaction();
        try {
            $connection->createCommand()->insert('custom_shipping',[
                'custom_id'=>$custom_id,
                'shipping_address'=>$shipping_address,
                'username'=>$username,
                'mobile'=>$mobile,
                'zipcode'=>$zipcode
            ])->execute();
            $tx->commit();
            return json_encode(['ErrCode'=>0,'Message'=>'保存成功！']);
        } catch (\Exception $e) {
            $tx->rollBack();
            //$eeror=$e->getMessage();
            return json_encode(['ErrCode'=>500,'Message'=>$e->getMessage()]);
        }

    }

    public function actionExchangePostage(){

        $request = Yii::$app->request;
        $connection = Yii::$app->db;
        //得到用户要兑换邮费的邮费数
        
        
        $exPostage = Yii::$app->request->post('exPostage','');
        //$exPostage1 = Yii::$app->request->post('exPostage1','');
        $custom_id = Yii::$app->session['custominfo']->custom->id;
        $custom_name = Yii::$app->session['custominfo']->custom->name_zh;
        $cat_default_id = Yii::$app->session['custominfo']->custom->cat_default_id;
        //得到不同用户的积分总数
        $query = new Query();
        $game_points = $query->select('game_points')->from('customs')->where(['id'=>$custom_id])->one();
        /*$query = new Query();
        $custom_score = $query->select('cat_default_id,points,coins')->from('customs')->where(['id'=>$custom_id])->one();
        if($cat_default_id != HintConst::$ROLE_HEADMASTER){
            $score = $custom_score['points'];
        }else{
            $score = $custom_score['coins'];
        }*/
        //得到奖品邮费券
        $prizePostage = $query->select('sum(value) as postage')->from('custom_prize_log')->where(['custom_id' => $custom_id])->andWhere(['goods_type' => 3])->andWhere(['status' => 0])->one();
        //得到用积分已兑换的邮费
        $exchangePostage = $query->select('postage')->from('customs')->where(['id' => $custom_id])->one();
        //求邮费和
        $sumPostage = (int)$prizePostage['postage'] +  (int)$exchangePostage['postage'];
        //假设20元邮费才能包邮
        
        $owePostage = $this->needs - $sumPostage;
        
        //开始计算积分兑换，规则：10积分兑换1元邮费，未开Transaction.
        $subCoins = (int)$exPostage*10;

        //要增加的邮费
        $addEXPostage1 = $exPostage + $exchangePostage['postage'];
        //要扣除的积分数
        $subCoins1 = (int)$game_points['game_points']-$subCoins;
        if ($subCoins1 < 0) {
               echo "积分不足！请重新输入"; die();
           }

        $game_points = $subCoins1;
        $sumPostage = $addEXPostage1 + $prizePostage['postage'];
        $owePostage = $this->needs - $sumPostage;
        //更新数据库
        $connection->createCommand()->update('customs',['postage'=>$addEXPostage1],['in','id',$custom_id])->execute();
        $connection->createCommand()->update('customs',['game_points'=>$game_points],['in','id',$custom_id])->execute();
        /*if ($cat_default_id == 207) {
            $connection->createCommand()->update('customs',['coins'=>$subCoins1],['in','id',$custom_id])->execute();
        } else {
            $connection->createCommand()->update('customs',['points'=>$subCoins1],['in','id',$custom_id])->execute();
        }*/
        return $this->render('exchange-postage',['custom_name'=>$custom_name,
                'score'=>$game_points,
                'cat_default_id'=>$cat_default_id,
                'sumPostage'=>$sumPostage,
                'owePostage'=>$owePostage,
                'exPostage'=>$exPostage]);
    }
}