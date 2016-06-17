<?php


namespace app\modules\Admin\CheckIn\controllers;
use app\modules\Admin\CheckIn\models\CheckIn;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;

class CheckInController extends BaseController{

    /**
     * 魔法棒签到
     * stu_id 学生id
     * teacher_id 教师id
     * type 0签到 1签退
     * checkin_date 棒子记录的时间
     * @return string
     * @throws \Exception
     */
    public function actionCreate(){
        $stu_id = Yii::$app->request->post('stu_id',0);
        $teacher_id = Yii::$app->request->post('teacher_id',0);
        //$class_id = Yii::$app->request->post('class_id',0);
        $type = Yii::$app->request->post('type',0);
        $checkin_date = Yii::$app->request->post('checkin_date',0);

        if($checkin_date == 0){
            $checkin_date = time();
        }else{
            $checkin_date = strtotime($checkin_date);
        }

        $checkin = new CheckIn();
        $checkin->create($stu_id,$teacher_id,$type,$checkin_date);
        return json_encode(['ErrCode'=>0]);
    }


    /**
     *
     */
    public function actionClassInfo(){
        $class_id = Yii::$app->request->get('class_id',0);
        $date = Yii::$app->request->get('date',0);
        $type = Yii::$app->request->get('type',0);
        $fetch = Yii::$app->request->get('fetch',0);

        if($date == 0){
            $date = date('Y-m-d H:i:s',time());
        }
        $checkin = new CheckIn();
        if($fetch == 1){
            $list = $checkin->getAlreadyCheckInByClass($class_id,$date,$type);
            return json_encode(['ErrCode'=>0,'Content'=>$list]);
        }
        elseif($fetch == 2){
            $list = $checkin->getUnCheckInByClass($class_id,$date,$type);
            return json_encode(['ErrCode'=>0,'Content'=>$list]);
        }


        $list1 = $checkin->getAlreadyCheckInByClass($class_id,$date,$type);
        $list2 = $checkin->getUnCheckInByClass($class_id,$date,$type);

        return json_encode(['ErrCode'=>0,'Content'=>array_merge($list1,$list2)]);
    }


    public function actionClassBasicInfo(){

        $class_id = Yii::$app->request->get('class_id',0);
        $date = Yii::$app->request->get('date',0);
        if($date == 0){
            $date = date('Y-m-d',time());
        }
        $checkin = new CheckIn();
        $ret = $checkin->getClassCheckInBasicInfo($class_id,$date);
        return json_encode(['ErrCode'=>0,'Content'=>$ret]);
    }


    public function actionStudent1(){
        $check_date = Yii::$app->request->get('month',0);
        $stu_id = Yii::$app->request->get('stu_id',0);

        if($check_date == 0){
            $check_date = time();
        }else{
            $check_date = strtotime($check_date);
        }

        $checkin = new CheckIn();
        $checkin_info = $checkin->getStudentCheckInInfo($stu_id,$check_date);
        return json_encode(['ErrCode'=>0,'Content'=>$checkin_info]);
    }



    public function actionEdit(){

        if(\Yii::$app->session['custominfo']->custom->cat_default_id != HintConst::$ROLE_HEADMASTER){
            return json_encode(['ErrCode'=>HintConst::$NO_PERMISION,'Content'=>'','Message'=>'no permission']);
        }

        $stu_id = Yii::$app->request->post('stu_id',0);
        $type = Yii::$app->request->post('type',0);
        $op_date = Yii::$app->request->post('op_date',0);
        $status = Yii::$app->request->post('status',0);

        if($op_date == 0){
            $op_date = time();
        }else{
            $op_date = strtotime($op_date);
        }

        $checkin = new CheckIn();

        if($checkin->isRedflowerCheck($stu_id,$type,$op_date,$status)){
            return json_encode(['ErrCode'=>HintConst::$REDFLOWER_CHECKIN,'Content'=>'can\'t edit']);
        }

        $checkin->editStudentCheckIn($stu_id,$type,$op_date,$status);
        return json_encode(['ErrCode'=>0,'Content'=>'']);
    }


    /**
     * 考勤，全园班级考勤情况列表
     * @return string
     */
    public function actionSchool(){
        $date = time();
        $school_id = \Yii::$app->session['custominfo']->custom->school_id;
        $checkin_date = strtotime(date('Y-m-d',$date));
        $checkin = new CheckIn();
        $result = ['member_count'=>0,'real_count'=>0,'class_list'=>[]];

        $memberCount = $checkin->getSchoolMemberCount($school_id);
        $result['member_count'] = $memberCount;

        //$checkin_count = $checkin->getCheckinMemberCountBySchoolId($school_id,0,$date);
        //$result['real_count'] =$checkin_count;


        $class_list = $checkin->getClassCheckInBasicInfoBySchoolId($school_id,$checkin_date);
        $result['class_list']=$class_list;

        $checkin_count = 0;
        foreach ($class_list as $class) {
            $checkin_count += $class['checkin_count'];
        }
        $result['real_count'] =$checkin_count;


        return json_encode(['ErrCode'=>0,'Content'=>$result]);
    }


    public function actionClass(){
        $date = time();
        $class_id = Yii::$app->request->get('class_id',Yii::$app->session['custominfo']->custom->class_id);
        $checkin = new CheckIn();
        $result = ['member_count'=>0,'real_count'=>0,'check_list'=>[],'uncheck_list'=>[]];

        if($class_id == 0 && Yii::$app->session['custominfo']->custom->cat_default_id == HintConst::$ROLE_HEADMASTER){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'invalid class_id']);
        }

        $checkin_student_list = $checkin->getAlreadyCheckInByClass($class_id,$date,0);
        $result['real_count'] = count($checkin_student_list);
        $result['check_list'] = $checkin_student_list;

        $member_count = $checkin->getClassMemberCount($class_id);
        $result['member_count'] = $member_count;

        $uncheck_student_list = $checkin->getUnCheckInByClass($class_id,$date,0);
        $result['uncheck_list'] = $uncheck_student_list;

        return json_encode(['ErrCode'=>0,'Content'=>$result]);
    }
}