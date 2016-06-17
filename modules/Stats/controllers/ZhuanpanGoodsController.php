<?php

namespace app\modules\Stats\controllers;


use app\modules\AppBase\base\appbase\StatsBC;
use yii\db\Query;
use yii;

class ZhuanpanGoodsController extends  StatsBC{

    public function actionIndex(){

        $request = \Yii::$app->request;

        $query = new Query();
        $zhuanpan_goods = $query->select('*')->from('zhuanpan_goods')
            ->orderBy('id desc')->all();
  
        if(empty($zhuanpan_goods)) {
            return $this->redirect('index.php?r=Stats/zhuanpan-goods/create');
        }

        //$query = new Query();
        //$base_num = 100000;
        return $this->render('index',['zhuanpan_goods'=>$zhuanpan_goods]);
    }

    public function actionCreate(){
        $request = Yii::$app->request;

        if(!$request->getIsPost()){
          return $this->render('create');
        }

        $goods_name = $request->post('goods_name');
        $value = $request->post('value');
        $used = $request->post('used');
        $type = $request->post('type');
        $count = $request->post('count');
        $brand = $request->post('brand');
        $purpose = $request->post('purpose');
        //$file = $_FILES["file"];
        //$file = $request->post('file');
        
        $imageName = $request->post('file');
        //获得图片路径
        $image = "/images/zhuanpan/goods/".$imageName;
        //插入数据
        $connection = Yii::$app->db;
        $connection->createCommand()->insert('zhuanpan_goods',[
            'goods_name'=>$goods_name,
            'value'=>$value,
            'used'=>$used,
            'type'=>$type,
            'count'=>$count,
            'brand'=>$brand,
            'purpose'=>$purpose,
            'image'=>$image
        ])->execute();
        return $this->redirect('index.php?r=Stats/zhuanpan-goods/index');
    }

    public function actionEdit(){
        $request = \Yii::$app->request;
        if(!$request->getIsPost()){
            $id = $request->get('id',0);
            if(!$id) {
                echo '参数错误';
                exit;
            }
            //var_dump($id);exit;
            $query = new Query();
            $good = $query->select('*')->from('zhuanpan_goods')->where(['id'=>$id])->one();
            //var_dump($good); exit;
            return $this->render('edit',['good'=>$good]);
        }

        $goods_name = $request->post('goods_name');
        $role = $request->post('role');
        $value = $request->post('value');
        $used = $request->post('used');
        $type = $request->post('type');
        $count = $request->post('count');
        $brand = $request->post('brand');
        $purpose = $request->post('purpose');
        $base_num = $request->post('base_num');
        $id = $request->post('id',0);
        //var_dump($id); exit;
        $imageName = $request->post('image');
        //获得图片路径
        $image = "/images/zhuanpan/goods/".$imageName;
        
        //更新表数据
        $connection = \Yii::$app->db;
        $connection->createCommand()->update('zhuanpan_goods',[
            'goods_name'=>$goods_name,
            'value'=>$value,
            'used'=>$used,
            'type'=>$type,
            'count'=>$count,
            'brand'=>$brand,
            'purpose'=>$purpose,
            'image'=>$image
        ],['id'=>$id])->execute();

        return $this->redirect('index.php?r=Stats/zhuanpan-goods/index');
    }

    public function actionDelete(){
      
      $request = Yii::$app->request;
      $id = $request->get('id',0);
      $connection = Yii::$app->db;
      $sql = "delete from zhuanpan_goods where id = ".$id;
      $ret = $connection->createCommand($sql)->execute();
      return $this->redirect('index.php?r=Stats/zhuanpan-goods/index');
    }
}