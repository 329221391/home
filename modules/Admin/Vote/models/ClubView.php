<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/2
 * Time: 16:53
 */
namespace app\modules\Admin\Vote\models;
class ClubView extends VoteView
{
    function __construct()
    {
        parent::__construct();
        $this->mc->setFlag(2);
    }
}