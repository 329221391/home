<?php

namespace app\modules\Stats\controllers;


use app\modules\AppBase\base\appbase\StatsBC;
use app\models\ZhuanpanGoods;
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
        /*$file_name=$zhuanpan_goods[0]["image"];
        print_r($file_name);exit;
        $str = explode(".",$file_name);
        echo("asdfasdf".$str[1]);
        exit;*/
        return $this->render('index',['zhuanpan_goods'=>$zhuanpan_goods]);
    }

    public function actionCreate(){
        $request = Yii::$app->request;

        if(!$request->getIsPost()){
          return $this->render('create');
        }
        //根据上传的图片文件生成缩略图并保存
        $image = $request->post('image');
        $zhuanpan_goods = new ZhuanpanGoods();
        $file = $_FILES['file'];
        $image = $zhuanpan_goods->uploadImage($file,$image);
        //通过Post方式接收页面传来的奖品数据
        $goods_name = $request->post('goods_name');
        $value = $request->post('value');
        $used = $request->post('used');
        $type = $request->post('type');
        $count = $request->post('count');
        $brand = $request->post('brand');
        $purpose = $request->post('purpose');
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
            $goods = $query->select('*')->from('zhuanpan_goods')->where(['id'=>$id])->one();
            //var_dump($good); exit;
            return $this->render('edit',['good'=>$goods]);
        }
        //根据上传的图片文件生成缩略图并保存
        $zhuanpan_goods = new ZhuanpanGoods();
        $file = $_FILES['file'];
        //得到原始图片
        $image = $request->post('image');
        $image = $zhuanpan_goods->uploadImage($file,$image);
        //通过Post方式接收页面传来的奖品数据
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
      $query = new Query();
      $image = $query->select('image')->from('zhuanpan_goods')->where(['id'=>$id])->one();
      //删除原图和缩略图
      $thumb = explode('.',$image['image']);
      $thumb = $thumb[0]."_thumb.".$thumb[1];
      unlink($image['image']);
      unlink($thumb);
      //更新数据库
      $sql = "delete from zhuanpan_goods where id = ".$id;
      $ret = $connection->createCommand($sql)->execute();
      return $this->redirect('index.php?r=Stats/zhuanpan-goods/index');
    }
}