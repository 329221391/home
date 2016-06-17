<?php

namespace app\models;

use app\modules\AppBase\base\cat_def\CatDef;
use \MessageIOS;
use \XingeApp;


/**
 * 信鸽IOS端推送消息的API实现
 * Class XingeIos
 * @package app\models
 */
class XingeIos implements XingeProxy{



    /**
     * 信鸽app的access_id
     */
    protected $access_id;


    /**
     * 信鸽app的secret_key
     */
    protected $secret_key;


    /**
     * IOS推送证书类型
     */
    protected $env;



    public function __construct($access_id,$secret_key,$env){
        $this->access_id = $access_id;
        $this->secret_key = $secret_key;
        $this->env = $env;
    }




    /**
     * 构建基本的MessageIOS对象方法
     * @param $title
     * @param $content
     * @param int $expire
     * @return MessageIOS
     */
    protected function getBaseMessage($title,$content,$expire = 86400){
        $mess = new MessageIOS();
        var_dump($title);
        $mess->setAlert($title); //$mess->setAlert($content['head'] . $content['body']);
        $mess->setSound('default');
        $mess->setCustom(['type' => $content]);//$mess->setCustom(['type' => $content['type']]);
        $mess->setExpireTime($expire);
        return $mess;
    }

    /**
     * 给单个TOKEN设备发送消息，简单参数
     * @param $token
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByTokenSimple($token, $title, $content, $expire = 86400)
    {
        $mess = $this->getBaseMessage($title,$content,$expire);
        return $this->pushByToken($token,$mess);
    }

    /**
     * 给单个账号发送消息，简单参数
     * @param $account
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByAccountSimple($account, $title, $content, $expire = 86400)
    {
        $mess = $this->getBaseMessage($title,$content,$expire);
        return $this->pushByAccount($account,$mess);
    }

    /**
     * 给多个账号发送消息，简单参数
     * @param $account_list
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByAccountListSimple($account_list, $title, $content, $expire = 86400)
    {
        $mess = $this->getBaseMessage($title,$content,$expire);
        return $this->pushByAccountList($account_list,$mess);
    }

    /**
     * 给单个TOKEN设备发送消息
     * @param $token
     * @param $message
     * @return mixed
     */
    public function pushByToken($token, $message)
    {
        $push = new XingeApp($this->access_id,$this->secret_key);
        $ret = $push->PushSingleDevice($token, $message,$this->env);
        return $ret;
    }

    /**
     * 给单个账号发送消息
     * @param $account
     * @param $message
     * @return mixed
     */
    public function pushByAccount($account, $message)
    {
        $push = new XingeApp($this->access_id,$this->secret_key);
        $ret = $push->PushSingleAccount(0,$account, $message,$this->env);
        return $ret;
    }

    /**
     * 给单个账号发送消息
     * @param $account_list
     * @param $message
     * @return mixed
     */
    public function pushByAccountList($account_list, $message)
    {
        $push = new XingeApp($this->access_id, $this->secret_key);
        $ret = $push->PushAccountList(0, $account_list, $message,$this->env);
        return $ret;
    }

    /**
     * 给单个标签发消息，简单参数
     * @param $tag
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByTagSimple($tag, $title, $content, $expire = 86400)
    {
        return $this->pushByTagsSimple(array($tag), $title, $content, $expire);
    }

    /**
     * 给多个标签发消息，简单参数
     * @param $tags
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByTagsSimple($tags,$title,$content,$expire = 86400){
        $message = $this->getBaseMessage($title,$content,$expire);
        return $this->pushByTags($tags,$message);
    }

    /**
     * 给标签推送消息
     * @param $tags
     * @param $message
     * @return mixed
     */
    public function pushByTags($tags, $message)
    {
        $push = new XingeApp($this->access_id, $this->secret_key);
        $tagOp = count($tags) == 1 ? 'OR' : 'AND';
        return $push->PushTags(0,$tags,$tagOp,$message,$this->env);
    }

    /**
     * 推送一个批量任务给账号
     * @param $push_id
     * @param $account_list
     * @return mixed
     */
    public function pushTaskByAccounts($push_id, $account_list)
    {
        $push = new XingeApp($this->access_id, $this->secret_key);
        return $push->PushAccountListMultiple($push_id,$account_list,$this->env);
    }

    /**
     * 推送一个批量任务给设备
     * @param $push_id
     * @param $token_list
     * @return mixed
     */
    public function pushTaskByTokens($push_id, $token_list)
    {
        $push = new XingeApp($this->access_id, $this->secret_key);
        return $push->PushDeviceListMultiple($push_id,$token_list,$this->env);
    }

    /**
     * 创建一个推送任务
     * @param $message
     * @return mixed
     */
    public function createTask($message)
    {
        $push = new XingeApp($this->access_id, $this->secret_key);
        return $push->CreateMultipush($message,$this->env);
    }

    /**
     * 创建一个推送任务，简单参数
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function createTaskSimple($title, $content, $expire = 86400)
    {
        $message = $this->getBaseMessage($title,$content,$expire);
        return $this->createTask($message);
    }
}