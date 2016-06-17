<?php

namespace app\controllers;
use app\modules\Admin\Articles\models\Articles;
use app\modules\Admin\Articles\models\ArticlesFav;
use app\modules\Admin\Message\models\Msgsendrecieve;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;
class PhoneController extends BaseController
{
    public function actionIndex()
    {
        if ($this->checkUserSession()) {
            return $this->index_all_com();
        } else {
            return $this->render('index');
        }
    }
    public function actionIndex_all()
    {
        return $this->index_all_com();
    }
    protected function index_all_com()
    {
        //注意卸载model中的mc,使用的都是同一个action,那么mc_name就要为其中一个添加识别
        $date = !empty($_REQUEST['date']) ? $_REQUEST['date'] : CommonFun::getCurrentDate();
        $date = CommonFun::getDateFitFormat($date);
        $school = new Schools();
        $parentInfo = $school->getParentGroupInfoA();//不用为getParentGroupInfoA中mc添加识别
        $article = new Articles();
        $today = json_decode($article->DaySummary());//要为DaySummary的mc添加识别
        return $this->render('index_all', ['date' => $date, 'parentInfo' => $parentInfo[HintConst::$F_Content], 'today' => $today->Content]);
    }
    public function actionClassmessage()
    {
        $school = new Schools();
        $parentInfo = $school->getParentGroupInfoA();
        return $this->render('classmessage', ['parentInfo' => $parentInfo[HintConst::$F_Content]]);
    }
    public function actionBabymessage()
    {
        $school = new Schools();
        $parentInfo = $school->getParentGroupInfoA();
        return $this->render('babymessage', ['parentInfo' => $parentInfo[HintConst::$F_Content]]);
    }
    public function actionYsq()
    {
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $size = !empty($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $article = new Articles();
        $newart = json_decode($article->AEList(HintConst::$ARTICLE_PATH));
        $relateme = json_decode($article->RelateMe());
        return $this->render('ysq', ['newart' => $newart->Content, 'relateme' => $relateme->Content, 'page' => $page, 'size' => $size]);
    }
    public function actionBabyevaluate()
    {
        $article = new Articles();
        $webtype = !empty($_REQUEST['webtype']) ? $_REQUEST['webtype'] : 3;
        $month = !empty($_REQUEST['month']) ? $_REQUEST['month'] : date("Ym");
        $term = !empty($_REQUEST['term']) ? $_REQUEST['term'] : date('Y');
        if ($webtype == 3) {
            $eva = json_decode($article->AEList(HintConst::$YUEPINGJIA_PATH));
        } elseif ($webtype == 4) {
            $eva = json_decode($article->AEList(HintConst::$NIANPINGJIA_PATH));
        }
        return $this->render('babyevaluate', ['eva' => $eva->Content, 'webtype' => $webtype, 'month' => $month, 'term' => $term]);
    }
    public function actionDetail()
    {
        $webtype = !empty($_REQUEST['webtype']) ? $_REQUEST['webtype'] : HintConst::$WEBTYPE_ARTALL;
        $article = new Articles();
        $art_detail = json_decode($article->ArticleDetail());
        return $this->render('detail', ['art_detail' => $art_detail->Content, 'webtype' => $webtype]);
    }
    public function actionReply()
    {
        $article_id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $article = new Articles();
        $art_reply = json_decode($article->ReplyList());
        return $this->render('reply', ['art_reply' => $art_reply->Content, 'article_id' => $article_id]);
    }
    public function actionAmail()
    {
        $school = new Schools();
        $parentInfo = $school->getParentGroupInfoA();
        return $this->render('amail', ['parentInfo' => $parentInfo[HintConst::$F_Content]]);
    }
    public function actionAmail_con()
    {
        $myid = Yii::$app->session['custominfo']->custom->id;
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $another_id = !empty($_REQUEST['another_id']) ? $_REQUEST['another_id'] : '';
        $name = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $cat_default_id = !empty($_REQUEST['cat_default_id']) ? $_REQUEST['cat_default_id'] : HintConst::$ROLE_PARENT;
        $msgSR = new Msgsendrecieve();
        $re = $msgSR->getMsgSR50TwoId($id, $another_id);
        return $this->render('amail_con', ['msg' => $re['Content'], 'name' => $name, 'myid' => $myid, 'cat_default_id' => $cat_default_id, 'another_id' => $another_id]);
    }
    public function actionDl()
    {
        return $this->render('dl');
    }
    public function actionDl_bbname()
    {
        return $this->render('dl_bbname');
    }
    public function actionDl_ma()
    {
        return $this->render('dl_ma');
    }
    public function actionDl_xyh()
    {
        return $this->render('dl_xyh');
    }
    public function actionEvaluate_detail()
    {
        return $this->render('evaluate_detail');
    }
    public function actionEvaluate_reply()
    {
        return $this->render('evaluate_reply');
    }
    public function actionExit()
    {
        $school = new Schools();
        $parentInfo = $school->getParentGroupInfoA();
        return $this->render('exit', ['parentInfo' => $parentInfo[HintConst::$F_Content]]);
    }
    public function actionExit_aboutjyq()
    {
        return $this->render('exit_aboutjyq');
    }
    public function actionExit_ms()
    {
        $school = new Schools();
        $parentInfo = $school->getParentGroupInfoA();
        return $this->render('exit_ms', ['parentInfo' => $parentInfo[HintConst::$F_Content]]);
    }
    public function actionExit_phone()
    {
        return $this->render('exit_phone');
    }
    public function actionIndex_img()
    {
        $img_url = !empty($_REQUEST['img_url']) ? $_REQUEST['img_url'] : 0;
        return $this->render('index_img', ['img_url' => $img_url]);
    }
    public function actionExit_qq()
    {
        return $this->render('exit_qq');
    }
    public function actionExit_xgmm()
    {
        $myid = Yii::$app->session['custominfo']->custom->id;
        return $this->render('exit_xgmm', ['myid' => $myid]);
    }
    public function actionGrow()
    {
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $size = !empty($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $article = new Articles();
        $grow = json_decode($article->Newgrow());
        return $this->render('grow', ['grow' => $grow->Content, 'page' => $page, 'size' => $size]);
    }
    public function actionGrowdetail()
    {
        $article = new Articles();
        $art_detail = json_decode($article->ArticleDetail());
        return $this->render('growdetail', ['art_detail' => $art_detail->Content]);
    }
    public function actionMymessage()
    {
        return $this->render('mymessage');
    }
    public function actionMystore()
    {
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $size = !empty($_REQUEST['size']) ? $_REQUEST['size'] : 10;
        $arfav = new ArticlesFav();
        $arfav->setName(CatDef::$mod['pic']);
        $fav = json_decode($arfav->Fav());
        return $this->render('mystore', ['fav' => $fav->Content, 'page' => $page, 'size' => $size]);
    }
    public function actionNewcont()
    {
        return $this->render('newcont');
    }
}
