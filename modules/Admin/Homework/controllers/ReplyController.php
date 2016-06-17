<?php


namespace app\modules\Admin\Homework\controllers;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\score\Score;
use Yii;
use yii\db\Query;

class ReplyController extends BaseController{


    /**
     * 添加回复
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionCreate(){
        $homework_id = Yii::$app->request->post('homework_id',0);
        $text = Yii::$app->request->post('text','');
        $urls = Yii::$app->request->post('pic_urls',[]);
        $stu_id = Yii::$app->request->post('stu_id',$this->getCustomId());

        $connection = Yii::$app->db;
        $connection->createCommand()->insert('homework_reply',[
            'homework_id'=>$homework_id,
            'text'=>$text,
            'stu_id'=>$stu_id,
            'create_time'=>time()
        ])->execute();

        $reply_id = $connection->getLastInsertID();

        foreach ($urls as $url) {
            $connection->createCommand()->insert('homework_img',[
                'target_id'=>$reply_id,
                'type'=>1,
                'url'=>$url
            ])->execute();
        }

        //添加积分
        $score = new Score();
        $data['contents'] = $text;
        $data['related_id'] = $homework_id;
        $score->HomeworkReplyCreate($data);

        return json_encode(['ErrCode'=>0,'Content'=>$reply_id]);
    }


    /**
     * 删除回复
     * @return string
     */
    public function actionDel(){
        $reply_id = Yii::$app->request->post('reply_id',0);
        $cat_default_id = Yii::$app->session['custominfo']->custom->cat_default_id;

        if($cat_default_id != HintConst::$ROLE_HEADMASTER){
            return json_encode(['ErrCode'=>HintConst::$NO_PERMISION,'Message'=>'no permission']);
        }

        $connection = Yii::$app->db;
        $connection->createCommand()->delete('homework_reply',['id'=>$reply_id])->execute();
        $connection->createCommand()->delete('homework_img',['target_id'=>$reply_id,'type'=>1])->execute();
        return json_encode(['ErrCode'=>0]);
    }


    /**
     * 回复列表
     * @return string
     */
    public function actionList(){
        $homework_id = Yii::$app->request->get('homework_id',0);
        $page = Yii::$app->request->get('page',1);
        $size = Yii::$app->request->get('size',10);
        $offset = ($page-1) * $size;
        if($homework_id == 0){
            return json_encode(['ErrCode'=>HintConst::$ParmaWrong,'Messsage'=>'invalid homework_id']);
        }
        $query = new Query();
        $where = ['hr.homework_id'=>$homework_id];
        if(Yii::$app->session['custominfo']->custom->cat_default_id == HintConst::$ROLE_PARENT){
            $where['hr.stu_id'] = $this->getCustomId();
        }
        $list = $query->select('hr.id,hr.stu_id,c.name_zh,hr.text,hr.create_time')
            ->from('homework_reply as hr')
            ->leftJoin('customs as c','hr.stu_id = c.id')
            ->where($where)
            ->offset($offset)
            ->limit($size)
            ->all();
        foreach ($list as &$item) {
            $query = new Query();
            $img_list = $query->select('id,url')->from('homework_img')->where(['target_id'=>$item['id'],'type'=>1])->all();
            $item['images'] = $img_list;
        }
        return json_encode(['ErrCode'=>0,'Content'=>$list]);
    }
    
}