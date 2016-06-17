<?php

namespace app\models;


/**
 * 信鸽代理接口
 * Interface XingeProxy
 * @package app\models
 */
interface XingeProxy {


    /**
     * 给单个TOKEN设备发送消息，简单参数
     * @param $token
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByTokenSimple($token,$title,$content,$expire);

    /**
     * 给单个账号发送消息，简单参数
     * @param $account
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByAccountSimple($account,$title,$content,$expire);

    /**
     * 给多个账号发送消息，简单参数
     * @param $account_list
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByAccountListSimple($account_list,$title,$content,$expire);

    /**
     * 给单个标签发消息，简单参数
     * @param $tag
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function pushByTagSimple($tag,$title,$content,$expire);

    /**
     * 给单个TOKEN设备发送消息
     * @param $token
     * @param $message
     * @return mixed
     */
    public function pushByToken($token,$message);

    /**
     * 给单个账号发送消息
     * @param $account
     * @param $message
     * @return mixed
     */
    public function pushByAccount($account,$message);

    /**
     * 给单个账号发送消息
     * @param $account_list
     * @param $message
     * @return mixed
     */
    public function pushByAccountList($account_list,$message);


    /**
     * 给标签推送消息
     * @param $tags
     * @param $message
     * @return mixed
     */
    public function pushByTags($tags,$message);


    /**
     * 推送一个批量任务给账号
     * @param $push_id
     * @param $account_list
     * @return mixed
     */
    public function pushTaskByAccounts($push_id,$account_list);


    /**
     * 推送一个批量任务给设备
     * @param $push_id
     * @param $token_list
     * @return mixed
     */
    public function pushTaskByTokens($push_id,$token_list);


    /**
     * 创建一个推送任务
     * @param $message
     * @return mixed
     */
    public function createTask($message);


    /**
     * 创建一个推送任务，简单参数
     * @param $title
     * @param $content
     * @param $expire
     * @return mixed
     */
    public function createTaskSimple($title,$content,$expire);

}