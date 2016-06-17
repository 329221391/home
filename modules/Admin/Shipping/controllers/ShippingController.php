<?php


namespace app\modules\Admin\Shipping\controllers;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;

class ShippingController extends BaseController{

    private function initShipping($custom_id){
        $connection = Yii::$app->db;
        //init custom shipping
        $connection->createCommand()->insert('custom_shipping',[
            'custom_id'=>$custom_id,
            'shipping_address'=>'',
            'username'=>'',
            'zipcode'=>'',
            'mobile'=>''
        ])->execute();

    }

    public function actionGet(){
        $custom_id = $this->getCustomId();

        $query = new Query();
        $shipping = $query->select('*')->from('custom_shipping')->where(['custom_id'=>$custom_id])->one();
        if(!$shipping){
            $this->initShipping($custom_id);
            $query = new Query();
            $shipping = $query->select('*')->from('custom_shipping')->where(['custom_id'=>$custom_id])->one();
            return json_encode(['ErrCode'=>0,'Content'=>$shipping]);
        }

        return json_encode(['ErrCode'=>0,'Content'=>$shipping]);
    }

    public function actionEdit(){
        $custom_id = $this->getCustomId();
        $valid = ['shipping_address','mobile','username','zipcode'];
        $field = Yii::$app->request->post('field','');
        $value = Yii::$app->request->post('value','');

        if(!in_array($field,$valid)){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'param wrong']);
        }

        $query = new Query();
        $shipping = $query->select('*')->from('custom_shipping')->where(['custom_id'=>$custom_id])->one();
        if(!$shipping){
            $this->initShipping($custom_id);
        }

        $connection = Yii::$app->db;
        $connection->createCommand()->update('custom_shipping',[''.$field=>$value],['custom_id'=>$custom_id])->execute();
        return json_encode(['ErrCode'=>0]);
    }

    public function actionSave(){
        $custom_id = $this->getCustomId();
        $shipping_address = Yii::$app->request->post('shipping_address','');
        $username = Yii::$app->request->post('username','');
        $mobile = Yii::$app->request->post('mobile','');
        $zipcode = Yii::$app->request->post('zipcode','');

        if($shipping_address == '' || $username == '' || $mobile == ''){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'param invalid']);
        }

        $query = new Query();
        $shipping = $query->select('*')->from('custom_shipping')->where(['custom_id'=>$custom_id])->one();
        if(!$shipping){
            $this->initShipping($custom_id);
        }

        $data['shipping_address'] = $shipping_address;
        $data['username'] = $username;
        $data['mobile'] = $mobile;
        $data['zipcode'] = $zipcode;

        $connection = Yii::$app->db;
        $connection->createCommand()->update('custom_shipping',$data,['custom_id'=>$custom_id])->execute();
        return json_encode(['ErrCode'=>0]);
    }

}