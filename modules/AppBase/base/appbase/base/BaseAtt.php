<?php
/**
 * User: gjc
 *  2015/5/22 17:07
 */
namespace app\modules\AppBase\base\appbase\base;
use app\modules\admin\vote\models\VoteReplyAtt;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
class BaseAtt extends BaseAR
{
    public function FileUpload($mod_str)
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $d['m_id'] = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $d['link_id'] = isset($_REQUEST['link_id']) && is_numeric($_REQUEST['link_id']) ? $_REQUEST['link_id'] : 0;
        if (empty($d['m_id']) || !is_numeric($d['m_id']) || $d['m_id'] == 0) {
            $ErrCode = HintConst::$NoId;
        } else {
            $mod=null;
            if ($mod_str == 'club_reply') {
                $mod = new VoteReplyAtt();
            }
            $school_id = $this->getCustomSchool_id();
            $class_id = $this->getCustomClass_id();
            $file_name = $this->create_img($school_id, $class_id, 'images');
            if ($file_name <> '' && $file_name) {
                $d['url'] = $file_name . '.jpg';
                $d['url_thumb'] = $file_name . '.thumb.jpg';
                $d['type_id'] = CatDef::$vote_att_cat['vote_opt'];
                $Content = $mod->addNew($d);
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => $Content];
        return (json_encode($result));
    }
}