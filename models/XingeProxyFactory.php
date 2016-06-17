<?php

namespace app\models;


class XingeProxyFactory {

    public static $instance_cache = [];

    /**
     * 信鸽IOS证书类型：产品证书
     * @var int
     */
    public static $IOSENV_PROD = 1;



    /**
     * 信鸽IOS证书类型：开发证书
     * @var int
     */
    public static $IOSENV_DEV = 2;


    /**
     * 信鸽接口服务AccessID，含ios平台和android平台，三个端app,园长端，家长端，教师端
     * @var array
     */
    protected static $access_Id = [
        'android_master'=>'2100117542', 'android_teacher'=>'2100117546', 'android_parent'=>'2100117547',
        'ios_master'=>'2200152115', 'ios_teacher'=>'2200152119', 'ios_parent'=>'2200152118',
        'android_test'=>'2100199188'
    ];


    /**
     * 信鸽接口服务SecretKey，含ios平台和android平台，三个端app,园长端，家长端，教师端
     * @var array
     */
    protected static $secret_Key = [
        'android_master'=>'ee1bca8656a012ce45b5c49faa61f446',
        'android_teacher'=>'4ce33d4ee1c5f8c1c10a1c01c91ba055',
        'android_parent'=>'db6a245f5568d29a0951b9be53e6f245',
        'ios_master'=>'cc05ccd358f342151f4680ad1b4de428',
        'ios_teacher'=>'76df933b062d1cfadaea510ec3207930',
        'ios_parent'=>'b4b04b825a7be2ec806094bc613742bf',
        'android_test'=>'a3c2ecd069e52af126a6c98ccc04443d'
    ];

    /**
     * 创建信鸽服务代理的工厂方法
     * @param string $platform
     * @param string $app
     * @return XingeAndroid
     */
    public static function getXingeProxy($platform = 'android',$app = 'master')
    {
        $pos = $platform.'_'.$app;

        //load from cache
        if(array_key_exists($pos,self::$instance_cache)){
            return self::$instance_cache[$pos];
        }


        if($platform == 'android'){
            $instance = self::createXingeProxyAndroid(self::$access_Id[$pos],self::$secret_Key[$pos]);
            self::$instance_cache[$pos] = $instance;
            return $instance;
        }
        $instance = self::createXingeProxyIosDev(self::$access_Id[$pos],self::$secret_Key[$pos]);
        self::$instance_cache[$pos] = $instance;
        return $instance;
    }


    /**
     * 创建android平台信鸽服务代理
     * @param $access_id
     * @param $secret
     * @return XingeAndroid
     */
    private static function createXingeProxyAndroid($access_id,$secret)
    {
        $proxy = new XingeAndroid($access_id,$secret);
        return $proxy;
    }

    /**
     * 创建ios平台信鸽服务代理（产品证书版本）
     * @param $access_id
     * @param $secret
     * @return XingeAndroid
     */
    private static function createXingeProxyIosProd($access_id,$secret)
    {
        $proxy = new XingeIos($access_id,$secret,self::$IOSENV_PROD);
        return $proxy;
    }


    /**
     * 创建ios平台信鸽服务代理（开发证书版本）
     * @param $access_id
     * @param $secret
     * @return XingeAndroid
     */
    private static function createXingeProxyIosDev($access_id,$secret)
    {
        $proxy = new XingeIos($access_id,$secret,self::$IOSENV_DEV);
        return $proxy;
    }
}