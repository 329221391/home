<?php

namespace app\models;


use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use yii\db\Query;

class HbPush {

    public $select_custom = 'id,school_id,class_id,token_type,cat_default_id,name_zh';
    const PENDINGARTICLE = '881';
    const PENDINGPIC = '880';
    const PENDINGEVA = '882';
    const PENDINGNOTE = '883';
    public function __construct(){

    }

    public function pushToCustom($custom_id){

    }

    //发布文章推送
    public function createArtPush($id,$article_type_id = 73){

        $query = new Query();
        $art = $query->select('id,author_id,school_id,class_id')->from('articles')->where(['id'=>$id])->one();

        //查找和文章相关的article_send_revieve
        $query = new Query();
        $asr_list = $query->select('*')->from('article_send_revieve')->where(['article_id'=>$id])->all();
        $user_ids = [];
        $class_ids = [];
        $school_id = 0;

        foreach ($asr_list as $asr) {
            if($asr['reciever_id'] > 0){
                $user_ids[] = $asr['reciever_id'];
                break;
            }elseif($asr['class_id'] > 0){
                $class_ids[] = $asr['class_id'];
                continue;
            }elseif($asr['school_id'] > 0){
                $school_id = $asr['school_id'];
                continue;
            }
        }


        $datas = [];
        $all_school = false;

        //如果设置的是全园成员
        if($school_id > 0){
            $query = new Query();
            $all_users = $query->select('id,school_id,class_id,token_type,cat_default_id ')->from('customs')->where(['school_id'=>$school_id])->andWhere('cat_default_id <> 207')->all();
            $datas = $this->addPushData($all_users,$datas);
            $all_school= true;
        }

        //如果设置的班级
        if(count($class_ids) > 0 && !$all_school){
            $query = new Query();
            $all_users = $query->select('id,school_id,class_id,token_type,cat_default_id')->from('customs')->where(['in','class_id',$class_ids])->andWhere('cat_default_id <> 207')->all();
            $datas = $this->addPushData($all_users,$datas);
        }else{//如如果不是班级，如果当前文章的作者是老师，那就推送给该老师，因为老师是作者
            $custom_id = $art['author_id'];
            $query = new Query();
            $teacher_user = $query->select('id,cat_default_id,token_type')->from('customs')->where(['id'=>$custom_id])->one();
            if($teacher_user['cat_default_id'] == HintConst::$ROLE_TEACHER){
                $platform = $teacher_user['token_type'] == 0 ? 'android' : 'ios';
                $datas[$platform]['teacher'][] = $teacher_user['id'];
            }
        }
        if(count($user_ids) > 0 && !$all_school){
            $query = new Query();
            $all_users = $query->select('id,school_id,class_id,token_type,cat_default_id ')->from('customs')->where(['in','id',$user_ids])->andWhere('cat_default_id <> 207')->all();
            $datas = $this->addPushData($all_users,$datas);
        }

        //永远给园长推送创建文章
        if($school_id == 0){
            $school_id = $art['school_id'];
        }

        $query = new Query();
        $master = $query->select('id,token_type')->from('customs')->where(['school_id'=>$school_id,'cat_default_id'=>HintConst::$ROLE_HEADMASTER])->one();
        $platform = $master['token_type'] == 0 ? 'android' : 'ios';
        $datas[$platform]['master'][] = $master['id'];
        if(!empty($datas)){
            $this->push($datas,'-'.$article_type_id.'-'.$id.'-0-0-0');
        }
    }

    //发布通知推送
    public function createNotePush($id){
        $query = new Query();
        $note = $query->select('id,author_id,obj_id,school_id,for_someone_type,for_someone_id')->from('notes')->where(['id'=>$id])->one();
        //全园老师和家长
        $query = new Query();
        $datas = [];
        if($note['obj_id'] == 5){
            $all_users = $query->select($this->select_custom)->from('customs')->where(['school_id'=>$note['school_id']])->andWhere(['in','cat_default_id',[HintConst::$ROLE_TEACHER,HintConst::$ROLE_PARENT]])->all();
            $datas = $this->addPushData($all_users,$datas);
        }elseif($note['obj_id'] == 9 && $note['for_someone_type'] == 5){//全园家长
            $all_users = $query->select($this->select_custom)->from('customs')->where(['school_id'=>$note['school_id'],'cat_default_id'=>HintConst::$ROLE_PARENT])->all();
            $datas = $this->addPushData($all_users,$datas);
        }elseif($note['obj_id'] == 6){//指定班级的老师和家长 for_someone_id为班级id
            $all_users = $query->select($this->select_custom)->from('customs')->where(['class_id'=>$note['for_someone_id']])->andWhere(['in','cat_default_id',[HintConst::$ROLE_TEACHER,HintConst::$ROLE_PARENT]])->all();
            $datas = $this->addPushData($all_users,$datas);
        }

        //永远给园长推送创建通知
        $query = new Query();
        $master = $query->select('id,token_type')->from('customs')->where(['school_id'=>$note['school_id'],'cat_default_id'=>HintConst::$ROLE_HEADMASTER])->one();
        $platform = $master['token_type'] == 0 ? 'android' : 'ios';
        $datas[$platform]['master'][] = $master['id'];

        if(!empty($datas)){
            $this->push($datas,'-252-'.$id.'-0-0-0');
        }
    }

    //发布调查推送
    public function createVotePush($id){
        $query = new Query();
        $vote = $query->select('id,author_id,class_id,school_id')->from('vote')->where(['id'=>$id])->one();
        $query = new Query();
        $vote_sr_list = $query->select('id,m_id,obj_id,for_someone_type,for_someone_id')->from('vote_s_r')->where(['m_id'=>$vote['id']])->all();
        $datas = [];
        for($i=0;$i<count($vote_sr_list);$i++){
            $vote_sr = $vote_sr_list[$i];

            if($vote_sr['obj_id'] == 5){
                $all_users = $query->select($this->select_custom)->from('customs')->where(['school_id'=>$vote['school_id']])->andWhere(['in','cat_default_id',[HintConst::$ROLE_TEACHER,HintConst::$ROLE_PARENT]])->all();
                $datas = $this->addPushData($all_users,$datas);
            }elseif($vote_sr['obj_id'] == 9 && $vote_sr['for_someone_type'] == 5){//全园家长
                $all_users = $query->select($this->select_custom)->from('customs')->where(['school_id'=>$vote['school_id'],'cat_default_id'=>HintConst::$ROLE_PARENT])->all();
                $datas = $this->addPushData($all_users,$datas);
            }elseif($vote_sr['obj_id'] == 6){//指定班级的老师和家长 for_someone_id为班级id
                $all_users = $query->select($this->select_custom)->from('customs')->where(['class_id'=>$vote_sr['for_someone_id']])->andWhere(['in','cat_default_id',[HintConst::$ROLE_TEACHER,HintConst::$ROLE_PARENT]])->all();
                $datas = $this->addPushData($all_users,$datas);
            }
            if(!empty($datas)){
                $this->push($datas,'-250-'.$id.'-0-0-0');
            }

        }

    }



    //发布点赞推送
    public function createPraisePush($id){

        //$query = new Query();
        //$praise = $query->select('id,author_id,school_id,class_id')->from('articles')->where(['id'=>$id])->one();

        //查找和文章相关的article_send_revieve
        $query = new Query();
        $art_sr = $query->select('*')->from('article_send_revieve')->where(['article_id'=>$id])->one();

        //得到赞的作者
        $query = new Query();
        $author = $query->select($this->select_custom)->from('customs')->where(['id'=>$art_sr['sender_id']])->one();
        $datas = [];

        $class_id = $art_sr['class_id'];
        $receiver_id = $art_sr['reciever_id'];

        //班级
        $query = new Query();
        $class = $query->select('id,school_id,teacher_id')->from('classes')->where(['id'=>$class_id])->one();
        //老师
        $query = new Query();
        $teacher = $query->select($this->select_custom)->from('customs')->where(['id'=>$class['teacher_id']])->one();

        //接收者
        $query = new Query();
        $receiver = $query->select($this->select_custom)->from('customs')->where(['id'=>$receiver_id])->one();

        if($author['cat_default_id'] == HintConst::$ROLE_HEADMASTER){ //园长发的赞 发家长和老师发推送
            if($receiver['cat_default_id'] == HintConst::$ROLE_TEACHER){//接收者是老师
                //给老师推送
                $datas = $this->addPushData([$teacher],$datas);
            }elseif($receiver['cat_default_id'] == HintConst::$ROLE_PARENT){//接收者是家长

                //给老师推送
                $datas = $this->addPushData([$teacher],$datas);
                //给家长推送
                $datas = $this->addPushData([$receiver],$datas);
            }
        }elseif($author['cat_default_id'] == HintConst::$ROLE_PARENT){ //家长发的赞 给老师发推送
            //给老师推送
            $datas = $this->addPushData([$teacher],$datas);
        }elseif($author['cat_default_id'] == HintConst::$ROLE_TEACHER){//老师发的赞 给家长发推送
            //给家长推送
            $datas = $this->addPushData([$receiver],$datas);
        }
        if(!empty($datas)){
            $this->push($datas,'-225-'.$id.'-0-0-0');
        }

    }

    //发布感谢信推送
    public function createLetterPush($id){
        //查找和文章相关的article_send_revieve
        $query = new Query();
        $art_sr = $query->select('*')->from('article_send_revieve')->where(['article_id'=>$id])->one();

        //得到赞的作者
        $query = new Query();
        $author = $query->select($this->select_custom)->from('customs')->where(['id'=>$art_sr['sender_id']])->one();
        $datas = [];


        $receiver_id = $art_sr['reciever_id'];

        //接收者
        $query = new Query();
        $receiver = $query->select($this->select_custom)->from('customs')->where(['id'=>$receiver_id])->one();

        if($author['cat_default_id'] == HintConst::$ROLE_PARENT){ //家长发的感谢信
            if($receiver['cat_default_id'] == HintConst::$ROLE_TEACHER){//接收者是老师
                $class_id = $art_sr['class_id'];
                //班级
                $query = new Query();
                $class = $query->select('id,school_id,teacher_id')->from('classes')->where(['id'=>$class_id])->one();
                //老师
                $query = new Query();
                $teacher = $query->select($this->select_custom)->from('customs')->where(['id'=>$class['teacher_id']])->one();
                //给老师推送
                $datas = $this->addPushData([$teacher],$datas);
            }elseif($receiver['cat_default_id'] == HintConst::$ROLE_HEADMASTER){//接收者是园长

                $query = new Query();
                $master = $query->select($this->select_custom)->from('customs')->where(['school_id'=>$art_sr['school_id'],'cat_default_id'=>HintConst::$ROLE_HEADMASTER])->one();
                //推送给园长
                $datas = $this->addPushData([$master],$datas);

            }
        }
        if(!empty($datas)){
            $this->push($datas,'-226-'.$id.'-0-0-0');
        }
    }

    //发布月评价推送
    public function createYuePjPush($id){
        //查找和文章相关的article_send_revieve
        $query = new Query();
        $art_sr = $query->select('*')->from('article_send_revieve')->where(['article_id'=>$id])->one();

        //得到赞的作者
        $query = new Query();
        $author = $query->select($this->select_custom)->from('customs')->where(['id'=>$art_sr['sender_id']])->one();
        $datas = [];


        $receiver_id = $art_sr['reciever_id'];
        if($author['cat_default_id'] == HintConst::$ROLE_PARENT) { //家长发的月评价，推送给园长和老师
            $class_id = $art_sr['class_id'];
            //班级
            $query = new Query();
            $class = $query->select('id,school_id,teacher_id')->from('classes')->where(['id'=>$class_id])->one();
            //老师
            $query = new Query();
            $teacher = $query->select($this->select_custom)->from('customs')->where(['id'=>$class['teacher_id']])->one();
            //给老师推送
            $datas = $this->addPushData([$teacher],$datas);

            $query = new Query();
            $master = $query->select($this->select_custom)->from('customs')->where(['school_id'=>$art_sr['school_id'],'cat_default_id'=>HintConst::$ROLE_HEADMASTER])->one();
            //推送给园长
            $datas = $this->addPushData([$master],$datas);
        }elseif($author['cat_default_id'] == HintConst::$ROLE_TEACHER){//老师发的月评价，推送给家长
            //接收者
            $query = new Query();
            $receiver = $query->select($this->select_custom)->from('customs')->where(['id'=>$receiver_id])->one();
            $datas = $this->addPushData([$receiver],$datas);
        }
        if(!empty($datas)){
            $query = new Query();
            $receiver = $query->select($this->select_custom)->from('customs')->where(['id'=>$receiver_id])->one();
            $this->push($datas,'-75-'.$id.'-0-0-0',$receiver,null);
        }
    }

    //发布年评价推送
    public function createNianPjPush($id){
        //查找和文章相关的article_send_revieve
        $query = new Query();
        $art_sr = $query->select('*')->from('article_send_revieve')->where(['article_id'=>$id])->one();

        //得到赞的作者
        $query = new Query();
        $author = $query->select($this->select_custom)->from('customs')->where(['id'=>$art_sr['sender_id']])->one();
        $datas = [];



        if($author['cat_default_id'] == HintConst::$ROLE_PARENT) { //家长发的年评价，推送给园长和老师
            $class_id = $art_sr['class_id'];
            //班级
            $query = new Query();
            $class = $query->select('id,school_id,teacher_id')->from('classes')->where(['id'=>$class_id])->one();
            //老师
            $query = new Query();
            $teacher = $query->select($this->select_custom)->from('customs')->where(['id'=>$class['teacher_id']])->one();
            //给老师推送
            $datas = $this->addPushData([$teacher],$datas);

            $query = new Query();
            $master = $query->select($this->select_custom)->from('customs')->where(['school_id'=>$art_sr['school_id'],'cat_default_id'=>HintConst::$ROLE_HEADMASTER])->one();
            //推送给园长
            $datas = $this->addPushData([$master],$datas);
        }elseif($author['cat_default_id'] == HintConst::$ROLE_TEACHER){//老师发的年评价，推送给家长
            $receiver_id = $art_sr['reciever_id'];
            //接收者
            $query = new Query();
            $receiver = $query->select($this->select_custom)->from('customs')->where(['id'=>$receiver_id])->one();
            $datas = $this->addPushData([$receiver],$datas);
        }
        if(!empty($datas)){
            $this->push($datas,'-229-'.$id.'-0-0-0');
        }
    }


    //发布红花推送
    public function createFlowerPush($id){
        $query = new Query();
        $redfl = $query->select('*')->from('redfl')->where(['id'=>$id])->one();

        $query = new Query();
        $receiver = $query->select($this->select_custom)->from('customs')->where(['id'=>$redfl['receiver_id']])->one();

        $query = new Query();
        $sender = $query->select($this->select_custom)->from('customs')->where(['id'=>$redfl['author_id']])->one();

        $query = new Query();
        $parent = $query->select($this->select_custom)->from('customs')->where(['id'=>$redfl['receiver_id']])->one();
        $datas = [];
        $datas = $this->addPushData([$parent],$datas);
        if(!empty($datas)){
            $this->push($datas,'-229-'.$id.'-0-0-0',$receiver,$sender);
        }
    }


    //发布照片推送
    public function createPicPush($id){

        $query = new Query();
        $art = $query->select('id,author_id,school_id,class_id')->from('articles')->where(['id'=>$id])->one();

        //查找和文章相关的article_send_revieve
        $query = new Query();
        $art_sr = $query->select('*')->from('article_send_revieve')->where(['article_id'=>$id])->one();

        //得到照片的作者
        $query = new Query();
        $author = $query->select($this->select_custom)->from('customs')->where(['id'=>$art_sr['sender_id']])->one();
        $datas = [];

        $query = new Query();
        $asr_list = $query->select('*')->from('article_send_revieve')->where(['article_id'=>$id])->all();
        $user_ids = [];
        $class_ids = [];
        $school_id = 0;

        foreach ($asr_list as $asr) {
            if($asr['reciever_id'] > 0){
                $user_ids[] = $asr['reciever_id'];
                break;
            }elseif($asr['class_id'] > 0){
                $class_ids[] = $asr['class_id'];
                continue;
            }elseif($asr['school_id'] > 0){
                $school_id = $asr['school_id'];
                continue;
            }
        }


        $datas = [];
        $all_school = false;

        //如果设置的是全园成员
        if($school_id > 0){
            $query = new Query();
            $all_users = $query->select('id,school_id,class_id,token_type,cat_default_id ')->from('customs')->where(['school_id'=>$school_id])->andWhere('cat_default_id <> 207')->all();
            $datas = $this->addPushData($all_users,$datas);
            $all_school= true;
        }

        //如果设置的班级
        if(count($class_ids) > 0 && !$all_school){
            $where1 = 'cat_default_id = 209';
            if($author['cat_default_id'] == HintConst::$ROLE_HEADMASTER){
                //园长发照片，也给相关班级的老师
                $where1 = 'cat_default_id <> 207';
            }

            $query = new Query();
            $all_users = $query->select('id,school_id,class_id,token_type,cat_default_id')->from('customs')->where(['in','class_id',$class_ids])->andWhere($where1)->all();
            $datas = $this->addPushData($all_users,$datas);
        }
        //如果设置的指定人
        if(count($user_ids) > 0 && !$all_school){
            $query = new Query();
            $all_users = $query->select('id,school_id,class_id,token_type,cat_default_id ')->from('customs')->where(['in','id',$user_ids])->all();
            $datas = $this->addPushData($all_users,$datas);

            if($author['cat_default_id'] == HintConst::$ROLE_HEADMASTER){ //园长发照片，也给相关班级的老师
                foreach ($all_users as $user) {
                    //得到每一个家长的老师
                    $query = new Query();
                    $class = $query->select('*')->from('classes')->where(['id'=>$user['class_id']])->one();
                    $query = new Query();
                    $teacher = $query->select($this->select_custom)->from('customs')->where(['id'=>$class['teacher_id']])->one();
                    $datas = $this->addPushData([$teacher],$datas);
                }

            }
        }

        if(!empty($datas)){
            $this->push($datas,'-222-'.$id.'-0-0-0');
        }

    }

    //回复内容推送（文章73）
    public function replyArtContentPush($id){

        $datas = [];

        $query = new Query();
        $art_reply = $query->select('*')->from('article_replies')->where(['id'=>$id])->one();
        $query = new Query();
        $reply_author = $query->select($this->select_custom)->from('article_replies')->where(['id'=>$art_reply['repliers_id']])->one();
        if($art_reply['reply_id'] > 0){
            //推消息给被引用人
            $query = new Query();
            $reply_user = $query->select($this->select_custom)->from('customs')->where(['id'=>$art_reply['reply_id']])->one();
            $datas = $this->addPushData([$reply_user],$datas);
            $sender = $reply_author;
            $receiver = $reply_user;
            if(!empty($datas)){
                $this->push($datas,'-65-73-'.$id.'-'.$reply_user['school_id'].'-'.$reply_user['class_id'].'-'.$reply_user['id'],$receiver,$sender);
            }
        }
        //把datas清空
        unset($datas);
        $datas = [];

        //推送消息给文章的作者
        $query = new Query();
        $art = $query->select('author_id')->from('articles')->where(['id'=>$art_reply['article_id']])->one();
        $query = new Query();
        $author = $query->select($this->select_custom)->from('customs')->where(['id'=>$art['author_id']])->one();
        if($art_reply['repliers_id'] != $author['id']){//回复者并不是文章作者，可以推送给作者
            $datas = $this->addPushData([$author],$datas);
            if(!empty($datas)){
                $sender = $reply_author;
                $receiver = $author;
                $this->push($datas,'-65-73-'.$id.'-'.$author['school_id'].'-'.$author['class_id'].'-'.$author['id'],$receiver,$sender);
            }
        }

    }


    //推送,月评价75，年评价229
    public function replyBabyPingjiaReply($id,$article_type_id){
        $datas = [];

        $query = new Query();
        $art_reply = $query->select('*')->from('article_replies')->where(['id'=>$id])->one();

        //内容的send_receive
        $query = new Query();
        $asr = $query->select('*')->from('article_send_revieve')->where(['article_id'=>$id])->one();

        $query = new Query();
        $sender = $query->select($this->select_custom)->from('customs')->where(['id'=>$art_reply['repliers_id']])->one();

        if($art_reply['reply_id'] > 0){
            //推消息给被引用人
            $query = new Query();
            $reply_user = $query->select($this->select_custom)->from('customs')->where(['id'=>$art_reply['reply_id']])->one();
            $datas = $this->addPushData([$reply_user],$datas);
        }
        //推给家长

        $reciever_id = $asr['reciever_id'];
        $parent_user = $query->select($this->select_custom)->from('customs')->where(['id'=>$reciever_id])->one();
        $datas = $this->addPushData([$parent_user],$datas);

        //推给老师
//        $query = new Query();
//        $class = $query->select('*')->from('classes')->where(['id'=>$parent_user['class_id']])->one();
//        $query = new Query();
//        $teacher_user = $query->select($this->select_custom)->from('customs')->where(['id'=>$class['teacher_id']])->one();
//        $datas = $this->addPushData([$teacher_user],$datas);


        //推给园长
//        $query = new Query();
//        $school = $query->select('*')->from('schools')->where(['id'=>$parent_user['school_id']])->one();
//        $query = new Query();
//        $master_user = $query->select($this->select_custom)->from('customs')->where(['id'=>$school['headmaster_id']])->one();
//        $datas = $this->addPushData([$master_user],$datas);


        if(!empty($datas)){
            //后三位是家长school_id class_id id
            $this->push($datas,'-65-'.$article_type_id.'-'.$id.'-'.$parent_user['school_id'].'-'.$parent_user['class_id'].'-'.$parent_user['id'],null,$sender);
        }
    }

    //发布俱乐部 话题:101 求助102 教师学习103 家长学习104 招生安全105 政策趋势106
    //$ret = $xgProxy->pushByTokenSimple($token,'title','207-106-10-20734-650-0-5706');
    public function createClubPush($id,$type_id){

        $query = new Query();
        $vote = $query->select('*')->from('vote')->where(['id'=>$id])->one();

        //作者信息
        $query = new Query();
        $author = $query->select($this->select_custom)->from('customs')->where(['id'=>$vote['author_id']])->one();

        $this->pushByTag('head','-'.$type_id.'-10-'.$id.'-'.$author['school_id'].'-'.$author['class_id'].'-'.$author['id']);
    }

    //回复俱乐部（话题101，求助102，教师学习103，家长学习104，招生安全105,政策趋势106）
    public function replyClubContent($id,$type_id){
        //如果园长直接回复，而不是引用回复receiver_id是否为0
        $query = new Query();
        $vote_reply = $query->select('*')->from('vote_replies')->where(['id'=>$id])->one();
        $query = new Query();
        $sender = $query->select($this->select_custom)->from('customs')->where(['id'=>$vote_reply['sender_id']])->one();
        $query = new Query();
        $receiver = $query->select($this->select_custom)->from('customs')->where(['id'=>$vote_reply['receiver_id']])->one();
        $datas = [];
        //给被回复者推送
        $this->addPushData([$receiver],$datas);
        $this->push($datas,'-65-'.$type_id.'-'.$id.'-'.$sender['school_id'].'-'.$sender['class_id'].'-'.$sender['id']);
    }


    //审核文章推送(图片880-222,通知883-252,文章881-73,月评价882-75，年评价882-229
    public function auditPush($id,$type_id){

        $table = 'articles';
        if($type_id == '883-252'){
            //通知
            $table = 'notes';
        }

        $datas = [];
        $query = new Query();
        $art = $query->select('school_id')->from($table)->where(['id'=>$id])->one();
        $query = new Query();
        $school = $query->select('id,headmaster_id')->from('schools')->where(['id'=>$art['school_id']])->one();
        $query = new Query();
        $master_user = $query->select($this->select_custom)->from('customs')->where(['id'=>$school['headmaster_id']])->one();

        $datas = $this->addPushData([$master_user],$datas);
        $this->push($datas,'-'.$type_id.'-'.$id.'-0-0-0');
    }



    //发私信
    public function sendMessage($id){
        $query = new Query();
        $msg_sr = $query->select('*')->from('msg_send_recieve')->where(['message_id'=>$id])->one();
        $query = new Query();
        $sender_user = $query->select($this->select_custom)->from('customs')->where(['id'=>$msg_sr['sender_id']])->one();
        $query = new Query();
        $reciever_user = $query->select($this->select_custom)->from('customs')->where(['id'=>$msg_sr['reciever_id']])->one();

        $datas = [];

        $datas = $this->addPushData([$reciever_user],$datas);
        //$role = $this->getRole($sender_user['cat_default_id']);
        $this->push($datas,'-993-'.$sender_user['cat_default_id'].'-'.$sender_user['id'],$reciever_user,$sender_user);
    }



    public function push($account_datas,$content,$receiver = null,$sender = null){
        foreach ($account_datas as $platform=>$datas_role) {
            foreach ($datas_role as $role=>$accounts) {
                $xgInstance = XingeProxyFactory::getXingeProxy($platform,$role);
                var_dump($platform.'_'.$role);
                var_dump($accounts);
                echo '<br/>';
                $tempContent = $content;
                $tempContent = $this->getRoleCode($role).$tempContent;
                var_dump($tempContent);
                echo '<br/>';
                if($platform == 'android'){
                    $ret = $xgInstance->pushByAccountListSimple($accounts,'title',$tempContent);
                }elseif($platform == 'ios'){
                    $title = $this->getHead($content,$receiver,$sender);
                    $ret = $xgInstance->pushByAccountListSimple($accounts,$title,$tempContent);
                }
                var_dump($ret);
                echo '<br />';
            }
        }
    }

    public function pushByTag($tag,$content,$receiver = null,$sender = null){
        $platform = 'android';
        $role = 'master';
        $xgInstance = XingeProxyFactory::getXingeProxy($platform,$role);

        var_dump($platform.'_'.$role);
        echo '<br/>';
        $tempContent = $content;
        $tempContent = $this->getRoleCode($role).$tempContent;
        var_dump($tempContent);
        echo '<br/>';
        $ret = $xgInstance->pushByTagSimple($tag,'title',$tempContent);
        var_dump($ret);
        echo '<br />';

        $platform = 'ios';
        $role = 'master';
        $xgInstance = XingeProxyFactory::getXingeProxy($platform,$role);
        var_dump($platform.'_'.$role);
        echo '<br/>';
        $title = $this->getHead($content,$receiver,$sender);
        $ret = $xgInstance->pushByTagSimple($tag,$title,$tempContent);
        var_dump($ret);
        echo '<br />';
    }

    public function &addPushData($customs,&$datas){
        foreach ($customs as $user) {
            $platform = $user['token_type'] == 0 ? 'android' : 'ios';
            $role = $this->getRole($user['cat_default_id']);
            $datas[$platform][$role][] = $user['id'];
            //排重
            $datas[$platform][$role] = array_unique($datas[$platform][$role]);
        }
        return $datas;
    }
    protected function getRoleCode($role){
        if($role == 'master'){
            return '207';
        }elseif($role == 'teacher'){
            return '208';
        }elseif($role == 'parent'){
            return '209';
        }
    }
    protected function getRole($cat_default_id){
        if($cat_default_id == HintConst::$ROLE_HEADMASTER){
            return 'master';
        }elseif($cat_default_id == HintConst::$ROLE_TEACHER){
            return 'teacher';
        }elseif($cat_default_id == HintConst::$ROLE_PARENT){
            return 'parent';
        }
    }


    public function getHead($content,$receiver = null,$sender = null){

        $cat = explode('-',$content);
        if(!$sender)
            $sender_name = $sender['name_zh'];
        if(!$receiver)
            $receiver_name = $receiver['name_zh'];
        switch ($cat[1]) {
            case CatDef::$mod['rf']:
            case CatDef::$mod['gf']:
                $head = $receiver_name . '小朋友表现太棒了，得到了小红花';
                break;
            case CatDef::$mod['club_topic']:
                $head = '您收到一篇新话题';
                break;
            case CatDef::$mod['club_help']:
                $head = '您收到一篇新求助';
                break;
            case CatDef::$mod['club_teacher']:
                $head = '您收到一篇新教师学习';
                break;
            case CatDef::$mod['club_parent']:
                $head = '您收到一篇新家长学习';
                break;
            case CatDef::$mod['club_se']:
                $head = '您收到一篇新招生安全';
                break;
            case CatDef::$mod['club_po']:
                $head = '您收到一篇新政策趋势';
                break;
            case CatDef::$mod['note']:
                $head = '您收到一篇新的通知';
                break;
            case CatDef::$mod['msg']:
                $head = '您收到'.$sender_name.'的私信';
                break;
            case CatDef::$mod['vote']:
                $head = '幼儿园有一项新调查期待您的参与';
                break;
            case CatDef::$mod['reply']:
                $head = '收到'.$sender_name.'的回复';
                break;
            case CatDef::$mod['pic']:
                $head = '收到的新照片';
                break;
            case CatDef::$mod['article']:
                $head = '您收到一篇新的文章';
                break;
            case CatDef::$mod['praise']:
                $head = '您收到一篇新的点赞';
                break;
            case CatDef::$mod['letter']:
                $head = '您收到一篇新的感谢信';
                break;
            case CatDef::$mod['moneva']:
            case CatDef::$mod['termeva']:
                $head = $receiver_name . '小朋友收到新的评价';
                break;
            case CatDef::$mod['club_topic']:
                $head = '有一篇新话题';
                break;
            case CatDef::$mod['club_help']:
                $head = "有一篇新求助";
                break;
            case CatDef::$mod['club_teacher']:
                $head = "有一篇新教师学习";
                break;
            case CatDef::$mod['club_parent']:
                $head = "有一篇新家长学习";
                break;
            case CatDef::$mod['club_se']:
                $head = "有一篇新招生安全";
                break;
            case CatDef::$mod['club_po']:
                $head = "有一篇新政策法规";
                break;
            case self::PENDINGPIC:
                $head = '您有新的照片需要审核!';
                break;
            case self::PENDINGARTICLE:
                $head = '您有新的文章需要审核!';
                break;
            case self::PENDINGEVA:
                $head = '您有新的评价需要审核!';
                break;
            case self::PENDINGNOTE:
                $head = '您有新的通知需要审核!';
                break;

            default:
                $head = '有新的内容';
                break;
        }
        return $head;
    }
}