<?php


namespace app\modules\Admin\Homework\controllers;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
use yii\db\Query;

class HomeworkController extends BaseController{


    /**
     * 创建作业
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionCreate(){
        $text = Yii::$app->request->post('text','');
        $urls = Yii::$app->request->post('pic_urls',[]);

        $class_id = Yii::$app->session['custominfo']->custom->class_id;
        $day = date('Y-m-d');
        $query = new Query();

        $exist = $query->select('id')->from('homework')->where([
            'class_id'=>$class_id,
            'day'=>$day
        ])->one();

        if($exist){
            return json_encode(['ErrCode'=>HintConst::$HOMEWORK_ALREADY_EXIST,'Message'=>'homework is exist']);
        }

        $connection = Yii::$app->db;
        $now = time();

        //insert homework
        $connection->createCommand()->insert('homework',[
            'class_id'=>$class_id,
            'day'=>$day,
            'teacher_id'=>$this->getCustomId(),
            'text'=>$text,
            'create_time'=>$now,
            'update_time'=>$now
        ])->execute();

        $homework_id = $connection->getLastInsertID();
        //insert homework_img
        foreach($urls as $url){
            $connection->createCommand()->insert('homework_img',[
                'target_id'=>$homework_id,
                'type'=>0,
                'url'=>$url
            ])->execute();
        }

        //添加积分
        $score = new Score();
        $data['contents'] = $text;
        $data['related_id'] = $homework_id;
        $score->HomeworkCreate($data);
        /*if ($d['article_type_id'] == CatDef::$mod['homework']) {
            //high score
            $data['related_id'] = $newid;
            $score->ImgCreate($data);
        } else {
            //not high
            $data['sub_type_id'] = $d['article_type_id'];
            $data['related_id'] = $id;
            $score->ArtiCreate($data);
        }*/

        return json_encode(['ErrCode'=>0,'Content'=>$homework_id]);
    }

    /**
     * 修改作业
     * @return string
     */
    public function actionEdit(){
        $homework_id = Yii::$app->request->post('homework_id',0);
        $text = Yii::$app->request->post('text','');


        $query = new Query();
        $exist = $query->select('id')->from('homework')->where(['id'=>$homework_id])->one();
        if(!$exist){
            return json_encode(['ErrCode'=>HintConst::$DATA_NOT_FOUND,'Message'=>'homework not found']);
        }

        $connection = Yii::$app->db;
        $connection->createCommand()->update('homework',[
            'text'=>$text,
            'update_time'=>time()
        ],['id'=>$homework_id])->execute();
        return json_encode(['ErrCode'=>0]);
    }


    /**
     * 添加照片
     * @return string
     */
    public function actionAddPic(){
        $urls = Yii::$app->request->post('pic_urls',[]);
        $homework_id = Yii::$app->request->post('homework_id',0);

        if(!$homework_id || count($urls) == 0){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong]);
        }
        $connection = Yii::$app->db;
        foreach($urls as $url){
            $connection->createCommand()->insert('homework_img',[
                'target_id'=>$homework_id,
                'type'=>0,
                'url'=>$url
            ])->execute();
        }
        return json_encode(['ErrCode'=>0]);
    }


    /**
     * 删除照片
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionDelPic(){
        $homework_id = Yii::$app->request->post('homework_id',0);
        $pic_id = Yii::$app->request->post('pic_id',0);

        $connection = Yii::$app->db;
        $connection->createCommand()->delete('homework_img',['target_id'=>$homework_id,'id'=>$pic_id])->execute();

        return json_encode(['ErrCode'=>0]);
    }


    public function actionGet(){
        //$homework_id = Yii::$app->request->get('homework_id',0);
        $class_id = Yii::$app->request->get('class_id',0);
        $day = Yii::$app->request->get('day',date('Y-m-d'));
        $query = new Query();
        $homework = $query->select('*')->from('homework')->where(['class_id'=>$class_id,'day'=>$day])->one();
        $query = new Query();
        $img_list = $query->select('id,url')->from('homework_img')->where(['target_id'=>$homework['id'],'type'=>0])->all();
        if($homework){
            $homework['create_time'] = date('Y-m-d H:i:s',$homework['create_time']);
            $homework['update_time'] = date('Y-m-d H:i:s',$homework['update_time']);
            $homework['images'] = $img_list;
            return json_encode(['ErrCode'=>0,'Content'=>$homework]);
        }
        return json_encode(['ErrCode'=>0,'Content'=>null]);
    }

    public function actionGetByid(){
        $id = Yii::$app->request->get('homework_id',0);
        $query = new Query();
        $homework = $query->select('*')->from('homework')->where(['id'=>$id])->one();
        if($homework == null){
            return json_encode(['ErrCode'=>0,'Content'=>null]);
        }
        $query = new Query();
        $img_list = $query->select('id,url')->from('homework_img')->where(['target_id'=>$homework['id'],'type'=>0])->all();

        if($homework){
            $homework['create_time'] = date('Y-m-d H:i:s',$homework['create_time']);
            $homework['update_time'] = date('Y-m-d H:i:s',$homework['update_time']);
            $homework['images'] = $img_list;
            return json_encode(['ErrCode'=>0,'Content'=>$homework]);
        }
        return json_encode(['ErrCode'=>0,'Content'=>null]);
    }
}