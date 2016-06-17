<?php

namespace app\modules\manage\controllers;


use app\modules\AppBase\base\appbase\BaseController;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\Url;

class ZhaopinController extends BaseController {


    //招生列表
    public function actionIndex(){
        //var_dump(Yii::$app->session['manage_user']);
        $keyword = Yii::$app->request->get('keyword','');
        $page_title = '招生管理';
        $school_id = Yii::$app->session['manage_user']['school_id'];
        //$author_id = Yii::$app->session['manage_user']['id'];
        $query = new Query();
        $query->select('id,title,post_phone,prepare_count,create_time')
            ->from('zhaopin')
            ->where(['school_id'=>$school_id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);
        //$query->orderBy('id','desc');
        $zhaopin_list = $query->orderBy(['id'=>SORT_DESC])->offset($pages->offset)->limit($pages->limit)->all();




        return $this->render('index', [
            'zhaopin_list' => $zhaopin_list,
            'pages' => $pages,
            'page_title' => $page_title,
            'keyword' => $keyword,
        ]);
    }

    //添加招生信息
    public function actionCreate(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            return $this->render('create',[]);
        }

        $title = Yii::$app->request->post('title','');
        $post_phone = Yii::$app->request->post('post_phone','');
        $content = Yii::$app->request->post('content','');
        $prepare_count = Yii::$app->request->post('prepare_count','');
        $first_img = Yii::$app->request->post('first_img','');
        if($title == ''){
            die('title is null');
        }

        $school_id = Yii::$app->session['manage_user']['school_id'];
        $author_id = Yii::$app->session['manage_user']['id'];
        $author_name = Yii::$app->session['manage_user']['name_zh'];
        $connection = \Yii::$app->db;
        $connection->createCommand()->insert('zhaopin',[
            'title'=>$title,
            'school_id'=>$school_id,
            'author_id'=>$author_id,
            'author_name'=>$author_name,
            'post_phone'=>$post_phone,
            'prepare_count'=>$prepare_count,
            'img_url'=>$first_img,
            'create_time'=>time()
        ])->execute();

        $insert_id = Yii::$app->db->getLastInsertID();

        $connection->createCommand()->insert('zhaopin_content',[
            'zp_id'=>$insert_id,
            'content'=>$content
        ])->execute();

        return $this->redirect(Url::to('index.php?r=manage/zhaopin/index'));
    }

    public function actionEdit(){
        $id = Yii::$app->request->get('id',0);

        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $query = new Query();
            $zhaopin = $query->select('zhaopin.*,zhaopin_content.id as content_id,zhaopin_content.content')
                ->from('zhaopin')
                ->leftJoin('zhaopin_content','zhaopin.id=zhaopin_content.zp_id')
                ->where(['zhaopin.id'=>$id])
                ->one();

            return $this->render('edit',[
                'zhaopin'=>$zhaopin
            ]);
        }

        $id = Yii::$app->request->post('id',0);
        $title = Yii::$app->request->post('title','');
        $content = Yii::$app->request->post('content','');
        $content_id = Yii::$app->request->post('content_id','');
        $post_phone = Yii::$app->request->post('post_phone','');
        $prepare_count = Yii::$app->request->post('prepare_count','');
        $first_img = Yii::$app->request->post('first_img','');

        if($title == ''){
            die('title is null');
        }
        if(mb_strlen($title) >=30){
            die('title is too large');
        }

        $school_id = Yii::$app->session['manage_user']['school_id'];
        $author_id = Yii::$app->session['manage_user']['id'];
        $author_name = Yii::$app->session['manage_user']['name_zh'];
        $connection = \Yii::$app->db;

        $connection->createCommand()->update('zhaopin',[
            'title'=>$title,
            'school_id'=>$school_id,
            'author_id'=>$author_id,
            'author_name'=>$author_name,
            'prepare_count'=>$prepare_count,
            'post_phone'=>$post_phone,
            'img_url'=>$first_img,
        ],['id'=>$id])->execute();

        $connection->createCommand()->update('zhaopin_content',['content'=>$content],'id='.$content_id)->execute();
        return $this->redirect(Url::to('index.php?r=manage/zhaopin/index'));

    }


    public function actionDelete(){
        $id = Yii::$app->request->get('id',0);
        $connection = \Yii::$app->db;
        $connection->createCommand()->delete('zhaopin',['id'=>$id])->execute();
        $connection->createCommand()->delete('zhaopin_content',['zp_id'=>$id])->execute();
        return $this->redirect('index.php?r=manage/zhaopin/index');
    }


    public function actionPost(){
        $id = Yii::$app->request->get('id',0);
        $keyword = Yii::$app->request->get('keyword','');


        $sql = 'select * from zhaopin_post where zp_id=:zp_id and (person_name like :keyword or mobile like :keyword) order by id desc';
        $sql_count = 'select count(*) from zhaopin_post where zp_id=:zp_id and (person_name like :keyword or mobile like :keyword) order by id desc';

        $connection = Yii::$app->db;
        $bindValues = [':keyword'=>'%'.$keyword.'%','zp_id'=>$id];
        $post_count = $connection->createCommand($sql_count)->bindValues($bindValues)->queryScalar();
        $post_list = $connection->createCommand($sql)->bindValues($bindValues)->queryAll();

        $pages = new Pagination(['totalCount' => $post_count, 'pageSize' => 20, 'pageSizeLimit' => 1]);

        return $this->render('post',[
            'post_list'=>$post_list,
            'pages'=>$pages,
            'id'=>$id,
            'keyword'=>$keyword
        ]);

    }

    public function actionCreateByTemplate(){
        $id = Yii::$app->request->get('id',0);

        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $query = new Query();
            $zhaopin = $query->select('zhaopin.*,zhaopin_content.id as content_id,zhaopin_content.content')
                ->from('zhaopin')
                ->leftJoin('zhaopin_content','zhaopin.id=zhaopin_content.zp_id')
                ->where(['zhaopin.id'=>$id])
                ->one();
        }
        $title = $zhaopin['title'];
        $post_phone=Yii::$app->session['manage_user']['phone'];
        $img_url=$zhaopin['img_url'];
        $content=$zhaopin['content'];
        $prepare_count = $zhaopin['prepare_count'];

        return $this->render('createByTemplate', [
            'title'=>$title,
            'content'=>$content,
            'post_phone'=>$post_phone,
            'prepare_count'=>$prepare_count
        ]);
    }
}