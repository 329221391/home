<?php

namespace app\controllers;


use app\models\HbPush;
use app\models\XingeProxyFactory;
use yii\web\Controller;

class XgController extends Controller{

    public function actionIndex(){
        $token = '6b3cc72cdd5c6bab4ff9918671007ad98929b98f';
        $xgProxy = XingeProxyFactory::getXingeProxy('android','teacher');
        //发布文章
        $ret = $xgProxy->pushByAccountListSimple(array('9980'),'title','208-73-20734-0-0-0');
        //发布通知
        //$ret = $xgProxy->pushByTokenSimple($token,'title','208-252-20734-650-2011-11332');
        //发布照片
        //$ret = $xgProxy->pushByTokenSimple($token,'title','209-222-20734-650-2011-11332');
        //发布调查
        //$ret = $xgProxy->pushByTokenSimple($token,'title','209-250-20734-650-2011-11125');
        //发红花
        //$ret = $xgProxy->pushByTokenSimple($token,'title','209-249-20734-650-2011-11125');
        //发月评价
        //$ret = $xgProxy->pushByTokenSimple($token,'title','208-75-20734-650-1801-9979');
        //发年评价
        //$ret = $xgProxy->pushByTokenSimple($token,'title','209-229-20734-650-2011-11125');

        //发点赞
        //$ret = $xgProxy->pushByTokenSimple($token,'title','209-225-20057-650-1801-9982');
        //发感谢信
        //$ret = $xgProxy->pushByTokenSimple($token,'title','208-226-20734-650-2011-11332');

        //发布俱乐部 话题:101 求助102 教师学习103 家长学习104 招生安全105 政策趋势106
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-106-10-20734-650-0-5706');


        //回复文章
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-65-73-20734-650-0-5706');
        //学期评价回复
        //$ret = $xgProxy->pushByTokenSimple($token,'title','208-65-229-20734-650-2011-11332');
        //通知回复
        //$ret = $xgProxy->pushByTokenSimple($token,'title','208-65-252-20734-650-2011-11332');
        //回复俱乐部话题
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-65-101-20734-650-0-5706');
        //回复俱乐部求助
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-65-102-20734-650-0-5706');
        //回复俱乐部教师学习
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-65-103-20734-650-0-5706');
        //回复俱乐部家长学习
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-65-104-20734-650-0-5706');
        //回复俱乐部招生安全
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-65-105-20734-650-0-5706');
        //回复俱乐部政策趋势
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-65-106-20734-650-0-5706');


        //待审图片 端-880-222-文章id-接受者学校id-接受者班级id-接受者id
        //待审通知 端-883-252-文章id-接受者学校id-接受者班级id-接受者id
        //待审文章 端-881-73-文章id-接受者学校id-接受者班级id-接受者id
        //待审月评价 端-882-75-文章id-接受者学校id-接受者班级id-接受者id
        //待审年评价 端-882-229-文章id-接受者学校id-接受者班级id-接受者id
        //$ret = $xgProxy->pushByTokenSimple($token,'title','207-880-222-20734-650-0-5706');

        //文章审核通过
        /*$ret = $xgProxy->pushByTokenSimple($token,'title','208-15-75-20734-10-650-2011-11332');*/

        //$ret = $xgProxy->pushByAccountSimple('15518781976','11111','张三');
        //$ret = $xgProxy->pushByTagSimple('6b3cc72cdd5c6bab4ff9918671007ad98929b98f','title','content');
        //$ret = $xgProxy->createTaskSimple('mytitle','mycontent');
        //$ret = $xgProxy->pushTaskByAccounts($ret['result']['push_id'],array('15518781976'));
        var_dump($ret);
        exit;
    }

    public function actionIndex1(){
        $push = new HbPush();
        //$push->createArtPush(20375);##
        $push->createNotePush(/*5293*/5471); //##ios端测试没通过
        //$push->createVotePush(3537); //##家长有推送无红点
        //$push->createPraisePush(20057);##
        //$push->createLetterPush(20250);##
        //$push->createFlowerPush(28518);## //红花，app红点没有取消
        //$push->createYuePjPush(20288);##
        //$push->createPicPush(20260);##
        //$push->createNianPjPush(12330);##
        //$push->replyArtContentPush(9432,73);## //回复文章
        //$push->replyBabyPingjiaReply(20288,75);##//回复月评价;
        //$push->replyBabyPingjiaReply(20288,229);##//年评价
        //话题:101 求助102 教师学习103 家长学习104 招生安全105 政策趋势106
        //$push->createClubPush(2989,103);##
        //$push->replyClubContent(1,101);##
        //Article/article/review-pic 图片审核通过
        //Article/article/delpic 图片审核不通过
        //Articles/articles/review del 审核文章通过,不通过,月评价，年评价也是
        //Notes/notes/pass del 审核通知通过,不通过

        //$push->auditPush(5293,'883-252'); //图片880-222,通知883-252,文章881-73,月评价882-75，年评价882-229
        //$push->sendMessage(4492);
    }

    /**
     * 给指定账号推送
     */
    public function actionPushAccount(){

    }


    /**
     * 给指定token推送
     */
    public function actionPushToken(){

    }


}