<?php
/**
 * User: gjc
 *  2015/5/22 17:07
 */
namespace app\modules\AppBase\base\appbase\base;
use app\modules\AppBase\base\appbase\BaseAR;
class BaseReply extends BaseAR
{
    public function merge_reply(&$reply_list, $tmp)
    {
        $aim = [];
        foreach ($reply_list as $v) {
            $aim[] = $v;
            foreach ($tmp as $y) {
                if ($v['id'] == $y['link_id']) {
                    $aim[] = $y;
                }
            }
        }
        $reply_list=$aim;
    }
}