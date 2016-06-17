<?php

namespace app\modules\Stats\controllers;

use yii;
use app\modules\AppBase\base\appbase\StatsBC;
use yii\db\Query;

class ZhuanpanActiveController extends  StatsBC{

    /*public $position_rote = [
            ['rote_left'=>10,'rote_right'=>35],
            ['rote_left'=>55,'rote_right'=>80],
            ['rote_left'=>100,'rote_right'=>125],
            ['rote_left'=>145,'rote_right'=>170],
            ['rote_left'=>190,'rote_right'=>215],
            ['rote_left'=>235,'rote_right'=>260],
            ['rote_left'=>280,'rote_right'=>305],
            ['rote_left'=>325,'rote_right'=>350],
        ];*/

        public $position_rote = [
            ['rote_left'=>5,'rote_right'=>25],
            ['rote_left'=>35,'rote_right'=>55],
            ['rote_left'=>65,'rote_right'=>85],
            ['rote_left'=>95,'rote_right'=>115],
            ['rote_left'=>125,'rote_right'=>145],
            ['rote_left'=>155,'rote_right'=>175],
            ['rote_left'=>185,'rote_right'=>205],
            ['rote_left'=>215,'rote_right'=>235],
            ['rote_left'=>245,'rote_right'=>265],
            ['rote_left'=>275,'rote_right'=>295],
            ['rote_left'=>305,'rote_right'=>325],
            ['rote_left'=>335,'rote_right'=>355],
        ];

    public function actionIndex(){
        //$acitve = 3;
        $query = new Query();
        $active_list = $query->select('*')->from('zhuanpan_active')->orderBy('id asc')->all();
        $current_time = time();
        return $this->render('index',['active_list'=>$active_list,'current_time'=>$current_time]);
    }

    public function actionCreate(){
        $request = \Yii::$app->request;
        if(!$request->getIsPost()){
            return $this->render('create',[]);
        }

        $scroll_info = $request->post('scroll_info');
        $description = $request->post('description');
        $role = $request->post('role');
        $act_start_time = $request->post('active_start_time');
        $act_end_time = $request->post('active_end_time');

        if($act_start_time){
            $act_start_time = strtotime($act_start_time);
        }

        if($act_end_time){
            $act_end_time = strtotime($act_end_time);
        }

        if(empty($role) || $role == 0){
            echo '请选择角色';
            exit;
        }

        $connection = \Yii::$app->db;
        $connection->createCommand()->insert('zhuanpan_active',[
            'role'=>$role,
            'active_start_time'=>$act_start_time,
            'active_end_time'=>$act_end_time,
            'description'=>$description,
            'create_time'=>time(),
            'scroll_info'=>$scroll_info
        ])->execute();

        return $this->redirect('index.php?r=Stats/zhuanpan-active/index');
    }


    public function actionEdit(){
        $request = Yii::$app->request;
        if(!$request->getIsPost()){
            $id = $request->get('id',0);
            if(!$id) {
                echo '参数错误';
                exit;
            }

            $query = new Query();
            $active = $query->select('*')->from('zhuanpan_active')->where(['id'=>$id])->one();
            //var_dump($active['scroll_info']);
            //exit;
            return $this->render('edit',['active'=>$active]);
        }

        $id = $request->post('id',0);
        $scroll_info = $request->post('scroll_info');
        $description = $request->post('description');
        $role = $request->post('role');
        $act_start_time = $request->post('active_start_time');
        $act_end_time = $request->post('active_end_time');

        if($act_start_time){
            $act_start_time = strtotime($act_start_time);
        }

        if($act_end_time){
            $act_end_time = strtotime($act_end_time);
        }
        if(!$id){
            echo 'id错误';
            exit;
        }
        if(empty($role) || $role == 0){
            echo '请选择角色';
            exit;
        }

        $connection = \Yii::$app->db;
        $connection->createCommand()->update('zhuanpan_active',[
            'role'=>$role,
            'active_start_time'=>$act_start_time,
            'active_end_time'=>$act_end_time,
            'description'=>$description,
            'create_time'=>time(),
            'scroll_info'=>$scroll_info
        ],['id'=>$id])->execute();

        //$connection->createCommand()->update('zhuanpan_goods',['role'=>$role],['zhuanpan_active_id'=>$id])->execute();
        
        return $this->redirect('index.php?r=Stats/zhuanpan-active/index');
    }

    public function actionDelete(){
        $request = Yii::$app->request;
        $connection = Yii::$app->db;

        $id = $request->get('id',0);
            if(!$id) {
                echo '参数错误';
                exit;
            }

        $model = $connection->createCommand('DELETE FROM zhuanpan_active WHERE id = :id');
        $model->bindParam(':id', $id);
        $model->execute();
        return $this->redirect('index.php?r=Stats/zhuanpan-active');
    }

    public function actionDeleteGoods(){
        $request = Yii::$app->request;
        $connection = Yii::$app->db;
        $goods_active_id = $request->get('goods_active_id');
        $active_id = $request->get('goods_active_id');

            if(!$goods_active_id) {
                echo '参数错误';
                exit;
            }

        $model = $connection->createCommand('DELETE FROM zhuanpan_goods_active WHERE id = :id');
        $model->bindParam(':id', $goods_active_id);
        $model->execute();
        //return $this->redirect(['index.php?r=Stats/zhuanpan-active/goods_list']);
        return $this->redirect(['zhuanpan-active/goods-list','id'=>$active_id]);
    }




    /***********tang**********/

    public function actionGoodsList(){

        $request = \Yii::$app->request;
        $id = $request->get('id',0);

        if(!$id){
            echo 'id错误';
            exit;
        }

        $query = new Query();

        $zhuanpan_goods = $query->select('zg.*,zga.id as goods_active_id,zga.v,zga.position')->from('zhuanpan_goods_active as zga')
        ->leftJoin('zhuanpan_goods as zg','zg.id = zga.goods_id')
        ->where([
            'zga.active_id'=>$id
        ])->all();

        $base_num = 100000;
        return $this->render('goods-list',['zhuanpan_goods'=>$zhuanpan_goods,'base_num'=>$base_num,'zhuanpan_active_id'=>$id]);
    }



    public function actionAddGoods(){
        $request = \Yii::$app->request;
        if(!$request->getIsPost()){
            $zhuanpan_active_id = $request->get('zhuanpan_active_id',0);

            $query = new Query();
            $zhuanpan_goods_list = $query->select('*')->from('zhuanpan_goods')->all();
            $sum_query = new Query();
            $sum_v = $sum_query->from('zhuanpan_goods_active')->where(['active_id'=>$zhuanpan_active_id])->sum('v');


            $left_v = 100000 - $sum_v;

            $query = new Query();
            $pos_list =$query->select('position')->from('zhuanpan_goods_active')->where([
                'active_id'=>$zhuanpan_active_id
            ])->all();

            $position_temp = [1,2,3,4,5,6,7,8,9,10,11,12];
            $position_temp1 = [];
            foreach ($pos_list as $key => $value) {
                $position_temp1[] = $value['position'];
            }
            
            $position_arr = array_diff($position_temp, $position_temp1);
            unset($position_temp);
            return $this->render('add-goods',['zhuanpan_goods_list'=>$zhuanpan_goods_list,'left_v'=>$left_v,'zhuanpan_active_id'=>$zhuanpan_active_id,'position_arr'=>$position_arr]);
        }


        //post
        $count = $request->post('count',0);
        $zhuanpan_active_id = $request->post('zhuanpan_active_id',0);
        $goods_id =  $request->post('goods_id',0);
        $v = $request->post('v',0);
        $position = $request->post('position',0);


       /* if(empty($goods_id) || empty($v) || empty($position)){
            echo 'params error';
            exit;
        }*/


        $ret = $this->save_zhuanpan_goods_active($zhuanpan_active_id,$goods_id,$v,$position,$count);

        if(!$ret){
            echo 'insert error';
            exit;
        }
        return $this->redirect(['zhuanpan-active/goods-list','id'=>$zhuanpan_active_id]);
    }


    public function actionEditGoods(){

        $request = \Yii::$app->request;
        if(!$request->getIsPost()){
            
            $goods_active_id = $request->get('goods_active_id',0);
            if(!$goods_active_id){
                echo 'goods_active_id is error';
                exit;
            }


            $query = new Query();
            $zhuanpan_goods_list = $query->select('*')->from('zhuanpan_goods')->all();

            $query = new Query();
            $zhuanpan_goods_active = $query->select('zg.*,zga.id as goods_active_id,zga.v,zga.active_id,zga.goods_id,zga.position,zga.rote_left,zga.rote_right')->from('zhuanpan_goods_active as zga')
                ->leftJoin('zhuanpan_goods as zg','zga.goods_id = zg.id')
                ->where(['zga.id'=>$goods_active_id])
                ->one();

            $query = new Query();
            $sum_v = $query->from('zhuanpan_goods_active')->where(['active_id'=>$zhuanpan_goods_active['active_id']])->sum('v');
            $base_num = 100000;
            $left_v = $base_num - $sum_v + $zhuanpan_goods_active['v'];

            //position_arr
            $query = new Query();
            $pos_list =$query->select('position')->from('zhuanpan_goods_active')->where([
                'active_id'=>$zhuanpan_goods_active['active_id']
            ])->all();

            $position_temp = [1,2,3,4,5,6,7,8,9,10,11,12];
            $position_temp1 = [];
            foreach ($pos_list as $key => $value) {
                $position_temp1[] = $value['position'];
            }
            $position_arr_temp = array_diff($position_temp, $position_temp1);
            
            $position_arr = [];
            $find = false;
            foreach ($position_arr_temp as $key => $value) {
                if ($value > $zhuanpan_goods_active['position'] && !$find) {
                    $position_arr[] = $zhuanpan_goods_active['position'];
                    $position_arr[] = $value;
                    $find = true;
                }else{
                    $position_arr[] = $value;
                }
            }
            unset($position_arr_temp);
            unset($position_temp);

            return $this->render('goods-edit',['zhuanpan_goods_active'=>$zhuanpan_goods_active,'zhuanpan_goods_list'=>$zhuanpan_goods_list,'left_v'=>$left_v,'position_arr'=>$position_arr]);
        }

        //post
        $goods_active_id = $request->post('goods_active_id',0);
        $goods_id = $request->post('goods_id',0);
        $v = $request->post('v',0);
        $position = $request->post('position',0);

        /*if(empty($goods_id) || empty($v) || empty($position)){
            echo 'params error';
            exit;
        }*/

        if(!$goods_active_id){
            echo 'goods_active_id is error';
            exit;
        }
        $query = new Query();
        $zhuanpan_goods_active = $query->select('*')->from('zhuanpan_goods_active as zga')
            ->leftJoin('zhuanpan_goods as zg','zga.goods_id = zg.id')
            ->where(['zga.id'=>$goods_active_id])
            ->one();

        $query = new Query();
        $sum_v = $query->from('zhuanpan_goods_active')->where(['active_id'=>$zhuanpan_goods_active['active_id']])->sum('v');
        $base_num = 100000;
        $left_v = $base_num - $sum_v + $zhuanpan_goods_active['v'];

        if($v > $left_v){
            echo 'v is too large';
            exit;
        }
        //$position = $position -1;
        
        $p = $this->position_rote[$position-1];

        //insert to database
        $conn = \Yii::$app->db;
        $conn->createCommand()->update('zhuanpan_goods_active',[
            'v'=>$v,
            'goods_id'=>$goods_id,
            'position'=>$position,
            'rote_left'=>$p['rote_left'],
            'rote_right'=>$p['rote_right']
        ],['id'=>$goods_active_id])->execute();


        return $this->redirect(['zhuanpan-active/goods-list','id'=>$zhuanpan_goods_active['active_id']]);
    }


    protected function save_zhuanpan_goods_active($zhuanpan_active_id,$goods_id,$v,$position,$count){

        

        //valid goods count in zhuanpan_goods_active
        $query = new Query();
        $goods_count = $query->from('zhuanpan_goods_active')->where(['active_id'=>$zhuanpan_active_id])->count('*');
        if($goods_count >= 12){
            echo 'goods count is too big';
            exit;
        }


        $zhuanpan_active = $query->select('*')->from('zhuanpan_active')->where(['id'=>$zhuanpan_active_id])->one();

        //valid v in zhuanpan_goods_active
        $query = new Query();
        $sum_v = $query->from('zhuanpan_goods_active')->where(['active_id'=>$zhuanpan_active_id])->sum('v');
        $base_num = 100000;
        $left_v = $base_num - $sum_v;
        if($v > $left_v){
            echo 'v is too large';
            exit;
        } 
        //$position = $position -1;
        //insert to database
        $conn = \Yii::$app->db;
        $p = $this->position_rote[$position-1];
        $ret = $conn->createCommand()->insert('zhuanpan_goods_active',[
            'goods_id'=>$goods_id,
            'active_id'=>$zhuanpan_active_id,
            'v'=>$v,
            'rote_left'=>$p['rote_left'],
            'rote_right'=>$p['rote_right'],
            'count'=>$count,
            'position'=>$position
        ])->execute();
        return $ret;
    }


}