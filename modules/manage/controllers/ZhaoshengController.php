<?php

namespace app\modules\manage\controllers;


use app\modules\AppBase\base\appbase\BaseController;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\Url;

class ZhaoshengController extends BaseController {


    //招生列表
    public function actionIndex(){
        //var_dump(Yii::$app->session['manage_user']);
        $keyword = Yii::$app->request->get('keyword','');
        $page_title = '招生管理';
        $school_id = Yii::$app->session['manage_user']['school_id'];
        //$author_id = Yii::$app->session['manage_user']['id'];
        $query = new Query();
        $query->select('id,title,post_phone,create_time')
            ->from('zhaosheng')
            ->where(['school_id'=>$school_id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'pageSizeLimit' => 1]);
        //$query->orderBy('id','desc');
        $zhaosheng_list = $query->orderBy(['id'=>SORT_DESC])->offset($pages->offset)->limit($pages->limit)->all();




        return $this->render('index', [
            'zhaosheng_list' => $zhaosheng_list,
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
        $first_img = Yii::$app->request->post('first_img','');

        if($title == ''){
            die('title is null');
        }

        $school_id = Yii::$app->session['manage_user']['school_id'];
        $author_id = Yii::$app->session['manage_user']['id'];
        $author_name = Yii::$app->session['manage_user']['name_zh'];
        $connection = \Yii::$app->db;
        $connection->createCommand()->insert('zhaosheng',[
            'title'=>$title,
            'school_id'=>$school_id,
            'author_id'=>$author_id,
            'author_name'=>$author_name,
            'post_phone'=>$post_phone,
            'img_url'=>$first_img,
            'create_time'=>time()
        ])->execute();

        $insert_id = Yii::$app->db->getLastInsertID();

        $connection->createCommand()->insert('zhaosheng_content',[
            'zs_id'=>$insert_id,
            'content'=>$content
        ])->execute();

        return $this->redirect(Url::to('index.php?r=manage/zhaosheng/index'));
    }

    public function actionEdit(){
        $id = Yii::$app->request->get('id',0);

        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $query = new Query();
            $zhaosheng = $query->select('zhaosheng.*,zhaosheng_content.id as content_id,zhaosheng_content.content')
                ->from('zhaosheng')
                ->leftJoin('zhaosheng_content','zhaosheng.id=zhaosheng_content.zs_id')
                ->where(['zhaosheng.id'=>$id])
                ->one();

            return $this->render('edit',[
                'zhaosheng'=>$zhaosheng
            ]);
        }

        $id = Yii::$app->request->post('id',0);
        $title = Yii::$app->request->post('title','');
        $content = Yii::$app->request->post('content','');
        $content_id = Yii::$app->request->post('content_id','');
        $post_phone = Yii::$app->request->post('post_phone','');
        $first_img = Yii::$app->request->post('first_img','');

        if($title == ''){
            die('title is null');
        }

        if(mb_strlen($title) >30){
            die('title is too large');
        }

        $school_id = Yii::$app->session['manage_user']['school_id'];
        $author_id = Yii::$app->session['manage_user']['id'];
        $author_name = Yii::$app->session['manage_user']['name_zh'];
        $connection = \Yii::$app->db;

        $connection->createCommand()->update('zhaosheng',[
            'title'=>$title,
            'school_id'=>$school_id,
            'author_id'=>$author_id,
            'author_name'=>$author_name,
            'post_phone'=>$post_phone,
            'img_url'=>$first_img,
        ],['id'=>$id])->execute();

        $connection->createCommand()->update('zhaosheng_content',['content'=>$content],'id='.$content_id)->execute();
        return $this->redirect(Url::to('index.php?r=manage/zhaosheng/index'));

    }


    public function actionDelete(){
        $id = Yii::$app->request->get('id',0);
        $connection = \Yii::$app->db;
        $connection->createCommand()->delete('zhaosheng',['id'=>$id])->execute();
        $connection->createCommand()->delete('zhaosheng_content',['zs_id'=>$id])->execute();
        return $this->redirect('index.php?r=manage/zhaosheng/index');
    }


    public function actionPost(){
        $id = Yii::$app->request->get('id',0);
        $keyword = Yii::$app->request->get('keyword','');


        $sql = 'select * from zhaosheng_post where zs_id=:zs_id and (parent_name like :keyword or parent_mobile like :keyword or baby_name like :keyword) order by id desc';
        $sql_count = 'select count(*) from zhaosheng_post where zs_id=:zs_id and (parent_name like :keyword or parent_mobile like :keyword or baby_name like :keyword) order by id desc';

        $connection = Yii::$app->db;
        $bindValues = [':keyword'=>'%'.$keyword.'%','zs_id'=>$id];
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

    public function actionCreatByTemplate()
    {
        $id = Yii::$app->request->get('id',0);

        if($_SERVER['REQUEST_METHOD'] == 'GET') {

            $query = new Query();
            $zhaosheng = $query->select('zhaosheng.*,zhaosheng_content.id as content_id,zhaosheng_content.content')
                ->from('zhaosheng')
                ->leftJoin('zhaosheng_content', 'zhaosheng.id=zhaosheng_content.zs_id')
                ->where(['zhaosheng.id' => $id])
                ->one();
        }
        $title = "美丽家园";
        $post_phone=Yii::$app->session['manage_user']['phone'];
        $img_url=$zhaosheng['img_url'];
        $content=$zhaosheng['content'];

        return $this->render('createByTemplate', [
            'title'=>$title,
            'content'=>$content,
            'post_phone'=>$post_phone
        ]);
    }

}