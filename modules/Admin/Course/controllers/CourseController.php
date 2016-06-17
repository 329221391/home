<?php


namespace app\modules\Admin\Course\controllers;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;

class CourseController extends BaseController{

    /**
     * 保存和更新课程表条目
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionSave(){
        $id = Yii::$app->request->post('id',0);
        $week = Yii::$app->request->post('week',0);
        $type = Yii::$app->request->post('type',0);
        $section = Yii::$app->request->post('section',0);
        $text = Yii::$app->request->post('text',0);
        $class_id = Yii::$app->request->post('class_id',Yii::$app->session['custominfo']->custom->class_id);

        if($week<1 || $week >7){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'week error']);
        }
        if($type != 0 && $type != 1 && $type != 2){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Message'=>'type error']);
        }

        $query = new Query();
        $exist = $query->select('*')->from('course')->where([
            'class_id'=>$class_id,
            'week'=>$week,
            'type'=>$type,
            'section'=>$section
        ])->one();

        $connection = Yii::$app->db;
        if($exist){
            $n = $connection->createCommand()->update('course',[
                'text'=>$text,
                'update_time'=>time()
            ],['id'=>$id])->execute();
            if($n > 0)
                return json_encode(['ErrCode'=>0,'Content'=>$id]);
            else
                return json_encode(['ErrCode'=>HintConst::$DATA_NOT_FOUND,'Message'=>'not found']);
        }
        $now = time();
        $connection->createCommand()->insert('course',[
            'class_id'=>$class_id,
            'week'=>$week,
            'type'=>$type,
            'section'=>$section,
            'text'=>$text,
            'create_time'=>$now,
            'update_time'=>$now
        ])->execute();

        $new_id = $connection->getLastInsertID();
        return json_encode(['ErrCode'=>0,'Content'=>$new_id]);
    }


    /**
     * 删除课程表条目
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionDel(){
        $id = Yii::$app->request->post('id',0);
        $query = new Query();
        $exist = $query->select('*')->from('course')->where(['id'=>$id])->one();
        if(!$exist){
            return json_encode(['ErrCode'=>HintConst::$DATA_NOT_FOUND,'Message'=>'not found']);
        }

        if(Yii::$app->session['custominfo']->custom->cat_default_id != HintConst::$ROLE_TEACHER
            || $exist['class_id'] != Yii::$app->session['custominfo']->custom->class_id){
            return json_encode(['ErrCode'=>HintConst::$NO_PERMISION,'Message'=>'no permission']);
        }
        $connection = Yii::$app->db;
        $connection->createCommand()->delete('course',['id'=>$id])->execute();
        return json_encode(['ErrCode'=>0]);
    }


    /**
     * 班级一周全部课程表
     * @return string
     */
    public function actionTable(){
        $class_id = Yii::$app->request->get('class_id',Yii::$app->session['custominfo']->custom->class_id);

        $query = new Query();
        $list = $query->select('*')->from('course')->where(['class_id'=>$class_id])->all();
        return json_encode(['ErrCode'=>0,'Content'=>$list]);
    }

    /**
     * 班级一天课程表
     * @return string
     */
    public function actionWeek(){
        $week = Yii::$app->request->get('week',0);
        $class_id = Yii::$app->request->get('class_id',Yii::$app->session['custominfo']->custom->class_id);
        $query = new Query();
        $list = $query->select('*')->from('course')->where([
            'class_id'=>$class_id,
            'week'=>$week
        ])->all();
        return json_encode(['ErrCode'=>0,'Content'=>$list]);
    }

}