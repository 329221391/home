<?php

namespace app\modules\Club\controllers;
use app\modules\Admin\Articles\models\ArticlesFav;
use app\modules\Admin\Vote\models\Club;
use app\modules\Admin\Vote\models\ClubReplies;
use app\modules\Admin\Vote\models\ClubView;
use app\modules\AppBase\base\appbase\base\BaseAtt;
use app\modules\AppBase\base\appbase\ClubBC;
use app\modules\AppBase\base\appbase\MultThread;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use Yii;
class ClubController extends ClubBC
{
    public function actionAddclub()
    {
        $pri_type_id = isset($_REQUEST['pri_type_id']) ? trim($_REQUEST['pri_type_id']) : CatDef::$mod['club_arti'];
        return (new Club())->Addvote($pri_type_id);
    }
    public function actionUploadforclubarti()
    {
        return (new Club())->FileUpload('club_arti');
    }
    public function actionUploadforclubreply()
    {
        $arr = new BaseAtt();
        $result = $arr->FileUpload('club_reply');
        return ($result);
    }
    public function actionClubfilt()
    {
        return (new Club())->Clublist();
    }
    public function  actionReply()
    {
        return json_encode((new ClubReplies())->Reply());
    }
    public function  actionGetreply()
    {
        parent::myjsonencode((new ClubReplies())->Getreply());
    }
    public function actionDetailforclub()
    {
        return (new Club())->Getdetail();
    }
    public function actionPraise()
    {
        return (new Club())->Praise();
    }
    public function actionAddFav()
    {
        $fav = new ArticlesFav();
        $result = $fav->addFav();
        return ($result);
    }
    public function actionDelfav()
    {
        $ErrCode = HintConst::$Zero;
        $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : 0;
        if ($id == 0 || !is_numeric($id)) {
            $ErrCode = HintConst::$NoId;
        } else {
            $fav = new ArticlesFav();
            $fav->del($id);
        }
        $result = ['ErrCode' => $ErrCode, 'Message' => '', 'Content' => HintConst::$NULLARRAY];
        return (json_encode($result));
    }
    public function actionFav()
    {
        $fav = new ArticlesFav();
        $result = $fav->Fav();
        return ($result);
    }
    public function actionViewuser()
    {
        return ((new ClubView())->getViewUser());
    }
    public function actionAdopt()
    {
        return ((new ClubReplies())->Adopt());
    }
    public function actionShare()
    {
        return (new Club())->Share();
    }
    public function actionDel()
    {
        return (new Club())->mydel();
    }
    public function actionDelreply()
    {
        return (new ClubReplies())->Delreply();
    }
    public function actionDelrr()
    {
        return (new ClubReplies())->Delrr();
    }
    public function actionPushaddclub()
    {
        $pri_type_id = isset($_REQUEST['pri_type_id']) ? $_REQUEST['pri_type_id'] : 0;
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : 0;
        (new MultThread())->push_club($pri_type_id, $title);
    }
}
