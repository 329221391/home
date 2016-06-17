<?php

namespace app\modules\manage\controllers;
use app\modules\admin\Redfl\models\Redfl;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;
use yii\data\Pagination;

class RedFlowerController extends BaseController{


    public function actionIndex(){

        //花类型 （0红花）
        $f_type = Yii::$app->request->get('f_type',0);

        //发送人id
        $sender_id = Yii::$app->request->get('sender_id',0);

        //班级id
        $class_id = Yii::$app->request->get('class_id',0);

        //接收人id
        $receiver_id = Yii::$app->request->get('receiver_id',0);

        //时间范围
        $s_date = Yii::$app->request->get('s_date',0);
        $e_date = Yii::$app->request->get('e_date',0);

        //当前登录用户的school_id
        $school_id = Yii::$app->session['manage_user']['school_id'];


        //获得该园所下的发送人列表(老师)
        $query = new Query();
        $sender_list = $query->select('id,name_zh,cat_default_id')
            ->from('customs')
            ->where(['school_id'=>$school_id,'cat_default_id'=>HintConst::$ROLE_TEACHER])
            ->all();


        //获得班级列表
        $query = new Query();
        $class_list = $query->select('id,name')
            ->from('classes')
            ->where(['school_id'=>$school_id,'isdeleted'=>HintConst::$YesOrNo_NO])->all();


        $receiver_list = [];
        $sender = [];
        //获得教师
        if($sender_id > 0){
            $query = new Query();
            $sender = $query->select('id,name_zh,class_id')
                ->from('customs')
                ->where(['school_id'=>$school_id,'cat_default_id'=>HintConst::$ROLE_TEACHER,'id'=>$sender_id])
                ->one();
            if($sender && $class_id > 0){
                $query = new Query();
                //如果有设置老师，那么接收人列表就应该是这个老师所在班级下的
                $receiver_list = $query->select('id,name_zh')
                    ->where(['school_id'=>$school_id,'cat_default_id'=>HintConst::$ROLE_PARENT,'class_id'=>$class_id])
                    ->from('customs')
                    ->all();
            }

        }


//        if($class_id != 0){
//
//        }else{
//            //如果默认需要显示全员家长，取消这段注释即可
//            /*$receiver_list = $query->select('id,name_zh')
//                ->where(['school_id'=>$school_id,'cat_default_id'=>HintConst::$ROLE_PARENT])
//                ->from('customs')
//                ->all();*/
//        }

        //构建where条件
        $where['redfl.school_id'] = $school_id;

        if($f_type > 0){
            $where['redfl.pri_type_id'] = $f_type;
        }
        if($sender_id > 0){
            $where['redfl.class_id'] = $sender['class_id'];
        }
        if($receiver_id > 0){
            $where['redfl.receiver_id'] = $receiver_id;
        }
        if($sender_id > 0){
            $where['redfl.author_id'] = $sender_id;
        }




        $query = new Query();
        $query = $query->select('redfl.*,classes.name as class_name')
            ->leftjoin('classes', 'classes.id = redfl.class_id')
            ->from('redfl')
            ->where($where);
        if(!empty($s_date) && !empty($e_date)){
            $query = $query->andWhere("redfl.createtime >='$s_date' and redfl.createtime <='$e_date'");
        }

        $queryString = Yii::$app->request->getQueryParams();

        $keys = ['f_type', 'sender_id', 'receiver_id','class_id','s_date','e_date'];
        foreach ($keys as $k) {
            if(!array_key_exists($k,$queryString)){
                $queryString[$k] = '';
            }
        }

        $countQuery = clone $query;
        $pager_array = ['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1,'params'=>$queryString];
        //$pager_array = array_merge($pager_array,$queryString);

        $pages = new Pagination($pager_array);

        $redfl_list = $query->offset($pages->offset)
            ->orderby(['id' => SORT_DESC])
            ->limit($pages->limit)
            ->all();
        //var_dump($where);


        return $this->render('index', [
            'redfl_list' => $redfl_list,
            'class_list'=>$class_list,
            'sender_list' => $sender_list,
            'receiver_list'=>$receiver_list,
            'pages' => $pages,
            'queryString' => $queryString,
        ]);
    }

    /**
     * 根据班级id获得学生列表
     */
    public function actionGetStudent(){

        //班级id
        $class_id = Yii::$app->request->get('class_id',0);
        if($class_id == 0){
            return json_encode([]);
        }
        //当前登录用户的school_id
        $school_id = Yii::$app->session['manage_user']['school_id'];

//        $query = new Query();
//        $teacher = $query->select('id,name_zh,class_id')
//            ->from('customs')
//            ->where(['school_id'=>$school_id,'cat_default_id'=>HintConst::$ROLE_TEACHER])
//            ->one();

//        if(empty($teacher)){
//            return json_encode([]);
//        }

        $where['school_id'] = $school_id;
        $where['cat_default_id'] = HintConst::$ROLE_PARENT;

        //$where['class_id'] = $teacher['class_id'];
        $where['class_id'] = $class_id;



        $query = new Query();
        $receiver_list = $query->select('id,name_zh')
            ->where($where)
            ->from('customs')
            ->all();

        return json_encode($receiver_list);
    }


    public function actionDelete(){
        $redfl_id = Yii::$app->request->get('redfl_id',0);
        $refl = Redfl::findOne($redfl_id);
        if($refl){
            $refl->delete();
            return json_encode(['error'=>0]);
        }
        return json_encode(['error'=>1]);
    }


    public function actionView(){
        $redfl_id = Yii::$app->request->get('id',0);
        $query = new Query();
        $redfl = $query->select('*')->from('redfl')->where(['id'=>$redfl_id])->one();
        if($redfl){
            return $this->render('view.php',['model'=>$redfl]);
        }
        return 'result not found';
    }
}