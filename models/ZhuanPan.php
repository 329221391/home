<?php


namespace app\models;

use yii\db\Query;

class ZhuanPan {

    private $cat_default_id;

    public function __construct($cat_default_id){
        $this->cat_default_id = $cat_default_id;
    }

    /*public function run(){

        $query = new Query();
        $prize_arr = $query->select('*')->from('zhuanpan_goods')->where([
            'role'=>$this->cat_default_id,
            'used'=>0
        ])->all();
		if(empty($prize_arr)){
			return false;
		}
        //打乱$prize_arr
        shuffle($prize_arr);

        //重新排列数组的索引，商品id作为索引
        $goods_list = [];
        foreach ($prize_arr as $item) {
            $goods_list[$item['id']] = $item;
        }
        unset($prize_arr);

        $arr = [];
        foreach ($goods_list as $key => $val) {
            $arr[$val['id']] = $val['v'];
        }
        $goods_id = $this->get_rand($arr);

        $goods = $goods_list[$goods_id];

        //查询库存
        $count = $goods['count'];
        if($count > 0){
            //减少库存
            $connection = \Yii::$app->db;
            $sql = 'update zhuanpan_goods set `count` = `count`-1 where id=:id';
            $connection->createCommand($sql,[':id'=>$goods_id])->execute();
            $count = $count - 1;
            return ['id'=>$goods['id'],'prize'=>$goods['goods_name'],'count'=>$count,'type'=>$goods['type'],'left'=>$goods['rote_left'],'right'=>$goods['rote_right'],'value'=>$goods['value'],'zhuanpan_active_id'=>$goods['zhuanpan_active_id'],'image'=>$goods['image']];
        }else{
            //指定一个安慰奖
            
            return ['id'=>$goods['id'],'prize'=>$goods['goods_name'],'count'=>$count,'type'=>$goods['type'],'left'=>$goods['rote_left'],'right'=>$goods['rote_right'],'value'=>$goods['value'],'zhuanpan_active_id'=>$goods['zhuanpan_active_id'],'image'=>$goods['image']];
        }
        //return ['id'=>$goods['id'],'prize'=>$goods['goods_name'],'count'=>$count];
    }*/
    private function get_rand($proArr){
        $result = '';

        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }

    public function run($active_id){
        $query = new Query();
        $prize_arr = $query->select('*')->from('zhuanpan_goods_active')->where(['active_id'=>$active_id])->all();
        if(empty($prize_arr)){
            return false;
        }
        
        //打乱$prize_arr
        shuffle($prize_arr);
        //重新排列数组的索引，商品id作为索引
        $goods_list = [];
        foreach ($prize_arr as $item) {
            $goods_list[$item['goods_id']] = $item;
        }
        unset($prize_arr);

        $arr = [];
        foreach ($goods_list as $key => $val) {
            $arr[$val['goods_id']] = $val['v'];
        }

        $goods_id = $this->get_rand($arr);
        $query = new Query();
        $goods = $query->select('*')->from('zhuanpan_goods')->where(['id'=>$goods_id])->one();
        
        $goods_active = $goods_list[$goods_id];
        //查询库存
        $count = $goods_active['count'];
        if($count > 0){
            //减少库存
            $connection = \Yii::$app->db;
            $sql = 'update zhuanpan_goods_active set `count` = `count`-1 where id=:id';
            $connection->createCommand($sql,[':id'=>$goods_active['id']])->execute();
            $count = $count - 1;
            return ['id'=>$goods['id'],'prize'=>$goods['goods_name'],'count'=>$count,'type'=>$goods['type'],'left'=>$goods_active['rote_left'],'right'=>$goods_active['rote_right'],'value'=>$goods['value'],'zhuanpan_active_id'=>$goods_active['active_id'],'image'=>$goods['image']];
        }else{
            //TODO 指定一个安慰奖
            $query = new Query();
            $empty_goods_id = $query->select('id')->from('zhuanpan_goods')->where(['type'=>2])->all();
            $goods_id=[];
            foreach ($empty_goods_id as $value) {
                $goods_id[]=$value['id'];
            }
            //打乱一下空奖列表;
            $prize_arr = $query->select('*')->from('zhuanpan_goods_active')->where(['id'=>$active_id])->where(['goods_id'=>$goods_id])->one();
            $goods_id = $prize_arr['goods_id'];
            $goods = $query->select('*')->from('zhuanpan_goods')->where(['id'=>$goods_id])->one();
            $goods_active = $prize_arr;
            $count = $goods_active['count'];
            return ['id'=>$goods['id'],'prize'=>$goods['goods_name'],'count'=>$count,'type'=>$goods['type'],'left'=>$goods_active['rote_left'],'right'=>$goods_active['rote_right'],'value'=>$goods['value'],'zhuanpan_active_id'=>$goods_active['active_id'],'image'=>$goods['image']];
        }
    }
}