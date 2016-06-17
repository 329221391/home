<?php
/**
 * Created by PhpStorm.
 * User: guojianchao
 * Date: 2014/11/22
 * Time: 20:33
 */
namespace app\modules\AppBase\base;
class CustomInfo
{
    public $custom;
    /**
     * @return mixed
     */
    public function getCustom()
    {
        return $this->custom;
    }
    function __construct()
    {
        // TODO: Implement __construct() method.
        $this->custom = new CustomMode();
    }
}