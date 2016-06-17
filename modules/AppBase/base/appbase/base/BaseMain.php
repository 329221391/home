<?php
/**
 * User: gjc
 *  2015/5/22 17:05
 */
namespace app\modules\AppBase\base\appbase\base;
use app\modules\Admin\Vote\models\Vote;
use app\modules\Admin\Vote\models\VoteAtt;
use app\modules\Admin\Vote\models\VoteOptAtt;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use Yii;
class BaseMain extends BaseAR
{
    public function FileUpload($mod_str)
    {
        $ErrCode = HintConst::$Zero;
        $Content = HintConst::$NULLARRAY;
        $d['m_id'] = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        if (empty($d['m_id']) || !is_numeric($d['m_id']) || $d['m_id'] == 0) {
            $ErrCode = HintConst::$NoId;
        } else {
            if ($mod_str == 'opt') {
                $mod = new VoteOptAtt();
            } else {
                $mod = new VoteAtt();
            }
            $school_id = $this->getCustomSchool_id();
            $class_id = $this->getCustomClass_id();
            $file_name = $this->create_img($school_id, $class_id, 'images');
            if ($file_name <> '' && $file_name) {
                $d['url'] = $file_name . '.jpg';
                $d['url_thumb'] = $file_name . '.thumb.jpg';
                $d['type_id'] = CatDef::$vote_att_cat['vote_opt'];
                $Content = $mod->addNew($d);
                $r = (new Vote())->findId($d['m_id']);
                if ($r !== null) {
                    if ($r->url_thumb == null) {
                        $r->url_thumb = $d['url_thumb'];
                        $r->save();
                    }
                }
            }
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => HintConst::$Success, 'Content' => $Content];
        return (json_encode($result));
    }
    public function getAuthor($id)
    {
        $mc_name = $this->getMcName() . $this->tableName() . 'getAuthor' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $d = $val;
        } else {
            $d = $this->find()->asArray()
                ->select('author_id')
                ->where("id=$id")
                ->one();
            $this->mc->add($mc_name, $d);
        }
        return $d;
    }
    public function increaseViewTimes($id)
    {
        $this->increaseF($id, 'view_times', 1);
    }
    public function increasePraisewTimes($id)
    {
        $this->increaseF($id, 'praise_times', 1);
    }
    public function increaseShareTimes($id)
    {
        $this->increaseF($id, 'share_times', 1);
    }
}