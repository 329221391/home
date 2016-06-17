<?php
/**
 * Created by PhpStorm.
 * User: gjc
 * Date: 2015/3/23
 * Time: 10:22
 */
namespace app\modules\AppBase\base\myevent;
use yii\base\Component;
class Pusher extends Component
{
    const EVENT_MSG_SEND = 'msgSent';
    function __construct()
    {
    }
    public function pushMsg($msg)
    {
        $event = new MsgEvent();
        $event->msg = $msg;
        $this->trigger(self::EVENT_MSG_SEND, $event);
    }
    public function sendmsg()
    {
        echo "i am coming!";
    }
}