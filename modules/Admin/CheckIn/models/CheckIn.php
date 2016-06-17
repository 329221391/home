<?php
namespace app\modules\Admin\CheckIn\models;

use app\modules\AppBase\base\appbase\BaseAnalyze;
use app\modules\AppBase\base\HintConst;
use yii\db\Query;

class CheckIn {



    /**
     * 创建考勤记录
     * @param $stu_id
     * @param $teacher_id
     * @param $type
     * @param $checkin_date
     * @throws \Exception
     */
    public function create($stu_id,$teacher_id,$type,$checkin_date,$checkin_day_status = 0){

        $data['stu_id'] = $stu_id;
        $data['teacher_id'] = $teacher_id;
        $data['type'] = $type;
        $data['create_time'] = time();
        $data['checkin_day'] = date('Ymd',$checkin_date);
        $data['checkin_date'] = $checkin_date;

        $checkin_date_timestamp = strtotime(date('Y-m-d',$data['checkin_date']));


        //get class_id
        $query = new Query();
        $stu = $query->select('class_id,school_id')->from('customs')->where([
            'id'=>$stu_id
        ])->one();

        $data['class_id'] = $stu['class_id'];
        $data['school_id'] = $stu['school_id'];
        $connection = \Yii::$app->db;

        $transaction = $connection->beginTransaction();
        try{

            $op_checkin_class = false;
            $d = date('d',$checkin_date);

            //insert or checkin_index
            $query = new Query();
            $checkin_index_exists = $query->select('*')->from('checkin_index')->where(['stu_id'=>$data['stu_id'],'type'=>$type])->one();
            if($checkin_index_exists["day$d"] == 0){
                $op_checkin_class = true;
            }
            $day = date('d',$checkin_date);
            if($checkin_index_exists){
                $sql = 'update checkin_index set day'.$day.'=1,day'.$day.'_time=:day_time where stu_id = :stu_id and type = :type';
                $connection->createCommand($sql,[':stu_id'=>$data['stu_id'],':day_time'=>$data['checkin_date'],':type'=>$type])->execute();
            }else{

                $insert_data = [];
                $insert_data['stu_id'] = $data['stu_id'];
                $insert_data['class_id'] = $data['class_id'];
                $insert_data['type'] = $type;
                $insert_data['day'.$day] = $data['checkin_date'];
                $d = date('j');
                for($i=1;$i<=31;$i++){
                    $f = sprintf("%02d", $i);
                    if($d > $i){
                        $insert_data['day'.$f] = 3;
                    }elseif($d == $i){
                        $insert_data['day'.$f] = $checkin_day_status;
                    }else{
						$insert_data['day'.$f] = 0;
					}
                }
                $connection->createCommand()->insert('checkin_index',$insert_data)->execute();

                /*$sql = 'insert into checkin_index(stu_id,class_id,day'.$day.',day'.$day.'_time,type) values(:stu_id,:class_id,1,:day_time,:type)';
                $connection->createCommand($sql,[
                    ':stu_id'=>$data['stu_id'],
                    ':class_id'=>$data['class_id'],
                    ':day_time'=>$data['checkin_date'],
                    ':type'=>$type
                ])->execute();*/
            }



            //insert or update checkin_class
            if($op_checkin_class){
                $count_field = 'checkin_count';
                if($type == 1){
                    $count_field = 'checkout_count';
                }
                $query = new Query();
                $checkin_exists = $query->from('checkin_class')->where(['class_id'=>$data['class_id'],'checkin_date'=>$checkin_date_timestamp])->count();
                if($checkin_exists > 0){
                    $sql = 'update checkin_class set '.$count_field.' = '.$count_field.' + 1 where class_id = :class_id and checkin_date=:checkin_date';
                    $connection->createCommand($sql,[':class_id'=>$data['class_id'],':checkin_date'=>$checkin_date_timestamp])->execute();
                }else{

                    $query = new Query();
                    $member_count = $query->from('customs')->where([
                        'class_id'=>$data['class_id']
                    ])->andWhere('cat_default_id <> '.HintConst::$ROLE_TEACHER)->count();

                    $sql = 'insert into checkin_class(class_id,school_id,'.$count_field.',member_count,checkin_date) values(:class_id,:school_id,:'.$count_field.',:member_count,:checkin_date)';
                    $connection->createCommand($sql,[
                        ':school_id'=>$data['school_id'],
                        ':class_id'=>$data['class_id'],
                        ':member_count'=>$member_count,
                        ':checkin_date'=>$checkin_date_timestamp,
                        ':'.$count_field=>1
                    ])->execute();
                }
            }




            //insert checkin_log
            $connection->createCommand()->insert('checkin_log',$data)->execute();
            $transaction->commit();
        }catch (\Exception $e){
            $transaction->rollBack();
            throw $e;
        }

    }




    /**
     * 学生考勤信息
     * @param $stu_id
     * @param $checkin_date
     * @return array
     */
    public function getStudentCheckInInfo($stu_id,$checkin_date = 0){

        $now_month = date('m',time());
        $month = date('m',$checkin_date);
        $year = date('Y',$checkin_date);
        $table_subfix = '';
        if($now_month != $month){
            $table_subfix = '_'.date('Ym',$checkin_date);
        }


        $isrun = false;
        $day_count = 31;
        if($month == '02') {
            if (is_run($year)) {
                $isrun = true;
            }
        }
		
        if($month == '02'){
            if($isrun)
                $day_count = 29;
            else
                $day_count = 28;
        }else{
            if(in_array($month,['04','06','09','11'])){
                $day_count = 30;
            }
        }

        $ym = date('Y-m-',$checkin_date);
        $result = [];
        $key_offset = 3;
        //如果小于2016-05-01
        if(mktime(0,0,0,5,1,2016) > $checkin_date){
            for($i=1;$i<=$day_count;$i++){
                $result[] = ['checkin_time'=>0,'day'=>$i,'status'=>0,'date'=>$ym.sprintf("%02d", $i)];
            }
            return $result;
        }

		try{
			$query = new Query();
			$stu_checkin = $query->select('*')->from('checkin_index'.$table_subfix)->where(['stu_id'=>$stu_id,'type'=>0])->one();
		}catch(\Exception $e){
			//table or view not found
			for($i=1;$i<=$day_count;$i++){
                $result[] = ['check_time'=>0,'status'=>0,'day'=>$i,'date'=>$ym.sprintf("%02d", $i)];
            }
			return $result;
		}
        
        //$stu_checkout = $query->select('*')->from('checkin_index'.$table_subfix)->where(['stu_id'=>$stu_id,'type'=>1])->one();

        
        //处理checkin
        if(empty($stu_checkin)){
            $d = date('j'); //1-31
            for($i=1;$i<=$day_count;$i++){
                if($d > $i){
                    $result[] = ['check_time'=>0,'status'=>3,'day'=>$i,'date'=>$ym.sprintf("%02d", $i)];
                }else{
                    $result[] = ['check_time'=>0,'status'=>0,'day'=>$i,'date'=>$ym.sprintf("%02d", $i)];
                }
            }
        }else{
            $keys = array_keys($stu_checkin);
            //循环列
            for($i=0;$i<$day_count;$i++){
                $index = $i+$key_offset;
                $result[] = ['checkin_time'=>$stu_checkin[$keys[$index].'_time'],'day'=>($i+1),'status'=>$stu_checkin[$keys[$index]],'date'=>$ym.sprintf("%02d", ($i+1))];
            }
        }

        //处理checkout
        /*if(empty($stu_checkout)){
            for($i=1;$i<=31;$i++){
                $result['checkout'][] = ['check_time'=>0,'check'=>0,'day'=>$i];
            }
            $keys = array_keys($stu_checkin);
            for($i=0;$i<31;$i++){
                $index = $i+$key_offset;
                $result['checkout'][] = ['checkout_time'=>$stu_checkin[$keys[$index].'_time'],'day'=>($i+1),'check'=>$stu_checkin[$keys[$index]]];
            }
        }*/

        return $result;
    }


    /**
     * 班级已签学生列表 (包含签到或者签退)
     * @param $class_id
     * @param $date_time
     * @param $type  0签到 1签退
     * @return array
     */
    public function getAlreadyCheckInByClass($class_id,$date_time,$type){
        //$date_time = strtotime($date);
        $table_month = date('Ym',$date_time);
        $now_month = date('m',time());
        $month = date('m',$date_time);
        $table_name = 'checkin_index';
        if($now_month != $month){
            //$table_subfix = str_replace('-','',$month);
            $table_name = $table_name.'_'.$table_month;
        }

        $day=date('d',$date_time);

//        $query = new Query();
//        $list = $query->select('ci.stu_id,c.name_zh as name_zh,ci.day'.$day.'_time as check_time')
//            ->from($table_name.' as ci')
//            ->innerJoin('customs as c','c.id=ci.stu_id')
//            ->where(['ci.type'=>$type,'ci.class_id'=>$class_id,'ci.day'.$day=>1])
//            ->all();

        $sql = 'select ci.stu_id,c.name_zh as name_zh,ci.day'.$day.'_time as check_time from '.$table_name.' as ci inner join customs as c on c.id=ci.stu_id where ci.type=:type and ci.class_id=:class_id and (ci.day'.$day.'=1 or ci.day'.$day.'=2)';
        $connection = \Yii::$app->db;
        $list = $connection->createCommand($sql,[':type'=>$type,':class_id'=>$class_id])->queryAll();
        //$sql = 'select stu_id,day'.$day.'_time as check_time from '.$table_name.' where type='.$type.' and class_id='.$class_id.' and day'.$day.'=1';

        //$connection = \Yii::$app->db;
        //$list = $connection->createCommand($sql)->queryAll();
        return $list;
    }


    /**
     * 班级未签到学生列表
     * @param $class_id
     * @param $date_time

     * @return array
     */
    public function getUnCheckInByClass($class_id,$date_time/*,$type*/){
        //$date_time = strtotime($date);
        $table_month = date('Ym',$date_time);
        $now_month = date('m',time());
        $month = date('m',$date_time);
        $table_name = 'checkin_index';
        if($now_month != $month){
            //$table_subfix = str_replace('-','',$month);
            $table_name = $table_name.'_'.$table_month;
        }

        $day=date('d',$date_time);

//        $sql = 'select id from customs where class_id='.$class_id.' and cat_default_id='.HintConst::$ROLE_PARENT.' and id not in (select stu_id from '.$table_name.' where type='.$type.' and class_id='.$class_id.' and day'.$day.'=1)';
//
//        $connection = \Yii::$app->db;
//        $list = $connection->createCommand($sql)->queryAll();
//        foreach ($list as &$item) {
//            $item['check_time'] = 0;
//        }

        $query = new Query();
        $list = $query->select('c.id as stu_id,c.name_zh as name_zh,ci.day'.$day.'_time as check_time')
            ->from('customs as c')
            ->leftJoin($table_name.' as ci','c.id = ci.stu_id')
            ->where(['c.cat_default_id'=>HintConst::$ROLE_PARENT,'c.class_id'=>$class_id])
            ->andWhere('ci.stu_id is null or ci.day'.$day.' = 0')
            ->all();

        foreach($list as &$item){
            $item['check_time'] = 0;
        }

        return $list;
    }





    /**
     * 获得班级今日考勤记录基本信息(实到人数/应到人数)
     * @param $class_id
     * @return array
     */
    public function getClassCheckInBasicInfo($class_id,$date){
        $query = new Query();
        $ret = $query->select('checkin_count,checkout_count,member_count')->from('checkin_class')->where(['class_id'=>$class_id])->one();
        return $ret;
    }


    public function getClassCheckInBasicInfoBySchoolId($school_id,$checkin_date){

        //$query = new Query();
        //$class_list = $query->select('id')->from('classes')->where(['school_id'=>$school_id])->all();

//        $sql = 'select class_id,checkin_count,checkout_count,member_count from checkin_class where class_id in (select id from classes where school_id=:school_id) and checkin_date=:checkin_date';
//        $connection = \Yii::$app->db;
//        $class_checkin_list = $connection->createCommand($sql,[':school_id'=>$school_id,':checkin_date'=>$checkin_date])->queryAll();

        //有签到信息的班级
        $query = new Query();
        $class_checkin_list = $query->select('c.id as class_id,c.teacher_id as teacher_id,c.name as class_name,cc.checkin_count,cc.member_count,cc.checkout_count')->from('checkin_class as cc')
            ->innerJoin('classes as c','c.id = cc.class_id')
            ->where(['c.school_id'=>$school_id,'cc.checkin_date'=>$checkin_date])
            ->orderBy('cc.checkin_count desc')
            ->all();




        //这个算法是有问题的
//        $query = new Query();
//        $uncheckin_class = $query->select('c.id,c.name,c.teacher_id')->from('classes as c')
//            ->leftJoin('checkin_class as cc','c.id = cc.class_id')
//            ->where(['c.school_id'=>$school_id,'cc.checkin_date'=>$checkin_date])->andWhere('cc.class_id is null')
//            ->all();

        //查询没有相关考勤记录的班级
        $sql = "select id,name,teacher_id from classes where id not in (select class_id from checkin_class where checkin_date = :checkin_date and school_id = :school_id) and school_id = :school_id;";
        $connection = \Yii::$app->db;
        $uncheckin_class= $connection->createCommand($sql,[':school_id'=>$school_id,':checkin_date'=>$checkin_date])->queryAll();
        foreach ($uncheckin_class as $class) {
            $sql = 'select count(*) as count from customs where class_id = :class_id and cat_default_id='.HintConst::$ROLE_PARENT;
            $ret = $connection->createCommand($sql,[':class_id'=>$class['id']])->queryOne();
            $class_checkin_list[] = ['class_id'=>$class['id'],'teacher_id'=>$class['teacher_id'],'class_name'=>$class['name'],'checkin_count'=>0,'checkout_count'=>0,'member_count'=>$ret['count']];
        }
        return $class_checkin_list;
    }


    /**
     * 修改学生签到签退状态，手动修改状态，不操作checkin_log
     * @param $stu_id 学生id
     * @param $type int 0签到 1签退
     * @param $op_date int 操作的日期，哪一天
     * @param $status 修改考勤的状态，2园长修改考勤 3 未出勤
     */
    public function editStudentCheckIn($stu_id,$type,$op_date,$status){

        $now_month = date('m',time());
        $month = date('m',$op_date);
        $table_subfix = '';
        $day = date('d',$op_date);
        if($now_month != $month){
            $table_subfix = '_'.$month;
        }
        $connection = \Yii::$app->db;

        $checkin_date = time();
        $checkin_date_timestamp = strtotime(date('Y-m-d',$op_date));
//        if($checkin_date == 0){
//            $sql = 'update checkin_index'.$table_subfix.' set day'.$day.'=0,day'.$day.'_time=0 where stu_id = :stu_id and type = :type';
//            $connection->createCommand($sql,[':stu_id'=>$stu_id,':type'=>$type])->execute();
//        }else{
//            $sql = 'update checkin_index'.$table_subfix.' set day'.$day.'=1,day'.$day.'_time=:time where stu_id = :stu_id and type = :type';
//            $connection->createCommand($sql,[':stu_id'=>$stu_id,':type'=>$type,':time'=>$checkin_date])->execute();
//        }
        $query = new Query();
        $stu = $query->select('*')->from('customs')->where(['id'=>$stu_id])->one();

        //查询checkin_index记录是否存在，如果不存在，创建一条空的记录
        $query = new Query();
        $exist = $query->select('stu_id')->from('checkin_index'.$table_subfix)->where(['stu_id'=>$stu_id])->one();
        if(!$exist){
            //$query = new Query();
            //$stu = $query->select('id,class_id')->from('customs')->where(['id'=>$stu_id])->one();

            $insert_data = [];
            $insert_data['stu_id'] = $stu_id;
            $insert_data['class_id'] = $stu['class_id'];
            $insert_data['type'] = $type;
            //$insert_data['day'.$day.'_time'] = $data['checkin_date'];
            $d = date('j');
            for($i=1;$i<=31;$i++){
                $f = sprintf("%02d", $i);
                if($d > $i){
                    $insert_data['day'.$f] = 3;
                }else{
                    $insert_data['day'.$f] = 0;
                }
            }
            $connection->createCommand()->insert('checkin_index'.$table_subfix,$insert_data)->execute();

            //$ba = new BaseAnalyze();
            //$ba->writeToAnal("stu:".var_export($stu,true));
            /*$connection->createCommand()
                ->insert('checkin_index'.$table_subfix,['stu_id'=>$stu_id,'type'=>$type,'class_id'=>$stu['class_id']])
                ->execute();*/
        }
        $sql = 'update checkin_index'.$table_subfix.' set day'.$day.'=:status,day'.$day.'_time=:time where stu_id = :stu_id and type = :type';
        $connection->createCommand($sql,[':stu_id'=>$stu_id,':type'=>$type,':time'=>$checkin_date,':status'=>$status])->execute();

        //查询checkin_class记录是否存在，如果不存在，创建一条空记录
        $count_field = 'checkin_count';
        if($type == 1){
            $count_field = 'checkout_count';
        }
        $query = new Query();
        $checkin_class_exists = $query->from('checkin_class')->where(['class_id'=>$stu['class_id'],'checkin_date'=>$checkin_date_timestamp])->one();
        if($checkin_class_exists){
            //判断是园长签手动到，还是园长手动未签到
            if($status == 2){
                $sql = 'update checkin_class set '.$count_field.' = '.$count_field.' + 1 where class_id = :class_id and checkin_date=:checkin_date';
            }elseif($status == 3){
                $sql = 'update checkin_class set '.$count_field.' = '.$count_field.' - 1 where class_id = :class_id and checkin_date=:checkin_date';
            }

            $connection->createCommand($sql,[':class_id'=>$stu['class_id'],':checkin_date'=>$checkin_date_timestamp])->execute();
        }else{
            $query = new Query();
            $member_count = $query->from('customs')->where([
                'class_id'=>$stu['class_id']
            ])->andWhere('cat_default_id <> '.HintConst::$ROLE_TEACHER)->count();

            $sql = 'insert into checkin_class(class_id,school_id,'.$count_field.',member_count,checkin_date) values(:class_id,:school_id,:'.$count_field.',:member_count,:checkin_date)';
            $connection->createCommand($sql,[
                ':school_id'=>$stu['school_id'],
                ':class_id'=>$stu['class_id'],
                ':member_count'=>$member_count,
                ':checkin_date'=>$checkin_date_timestamp,
                ':'.$count_field=>1
            ])->execute();
        }


        $connection->createCommand()->insert('checkin_master_log',[
            'stu_id'=>$stu_id,
            'master_id'=>\Yii::$app->session['custominfo']->custom->id,
            'type'=>$type,
            'create_time'=>time()
        ])->execute();

    }


    /**
     * 判断是否是红花考勤
     * @param $stu_id
     * @param $type
     * @param $op_date
     * @return bool
     */
    public function isRedflowerCheck($stu_id,$type,$op_date){
        $now_month = date('m',time());
        $month = date('m',$op_date);
        $table_subfix = '';
        $day = date('d',$op_date);
        if($now_month != $month){
            $table_subfix = '_'.$month;
        }

        //判断已经是红花考勤
        $query = new Query();
        $exist = $query->select('id')->from('checkin_index'.$table_subfix)
            ->where(['type'=>$type,'stu_id'=>$stu_id,'day'.$day=>1])
            ->count();

        return $exist > 0 ? true : false;
    }


    /**
     * 获取园所应到人数
     * @param $school_id
     * @return int|string
     */
    public function getSchoolMemberCount($school_id){
        $query = new Query();
        $count = $query->select('id')->from('customs')->where(['cat_default_id'=>HintConst::$ROLE_PARENT,'school_id'=>$school_id])->count();
        return $count;
    }


    public function getClassMemberCount($class_id){
        $query = new Query();
        $count = $query->select('id')->from('customs')->where(['cat_default_id'=>HintConst::$ROLE_PARENT,'class_id'=>$class_id])->count();
        return $count;
    }

    /**
     * 获取园所下签到或者签退的总数量(废弃)
     * @param $school_id 学校id
     * @param $type 0签到 1签退
     * @param $date_time 日期
     * @return int
     */
    public function getCheckinMemberCountBySchoolId($school_id,$type,$date_time){
        $day = date('d',$date_time);
        $now_month = date('m',time());
        $month = date('m',$date_time);
        $table_subfix = '';
        $day = date('d',$date_time);
        if($now_month != $month){
            $table_subfix = '_'.$month;
        }

        $sql = 'select count(*) as count from checkin_index'.$table_subfix.' where class_id in (select id from classes where school_id = :school_id) and :day = 1 and type=:type';
        $connection = \Yii::$app->db;
        $result = $connection->createCommand($sql,[':type'=>$type,':school_id'=>$school_id,':day'=>'day'.$day])->queryAll();
        return array_key_exists('count',$result) ? $result['count'] : 0;
    }


}