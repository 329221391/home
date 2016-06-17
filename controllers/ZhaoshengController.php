<?php

namespace app\controllers;

use yii\db\Query;
use yii\web\Controller;
use Yii;
class ZhaoshengController extends Controller{

    public function actionPost(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $id = Yii::$app->request->get('id',0);

            return $this->render('post',[
                'zhaosheng_id'=>$id
            ]);
        }

        $baby_name = Yii::$app->request->post('baby_name','');
        $baby_age = Yii::$app->request->post('baby_age',0);
        $parent_name = Yii::$app->request->post('parent_name','');
        $parent_mobile = Yii::$app->request->post('parent_mobile','');
        $zhaosheng_id = Yii::$app->request->post('zhaosheng_id',0);

        $query = new Query();
        $c = $query->select('id')->from('zhaosheng_post')->where(['zs_id'=>$zhaosheng_id,'parent_mobile'=>$parent_mobile])->count();
        if($c > 0){
            return $this->render('fail');
        }

        $connection = Yii::$app->db;
        $connection->createCommand()->insert('zhaosheng_post',[
            'zs_id'=>$zhaosheng_id,
            'baby_name'=>$baby_name,
            'baby_age'=>$baby_age,
            'parent_name'=>$parent_name,
            'parent_mobile'=>$parent_mobile,
            'create_time'=>time()
        ])->execute();

        $connection->createCommand('update zhaosheng set post_count = post_count+1 where id=:id',[':id'=>$zhaosheng_id])->execute();


        return $this->render('success');
    }

    public function actionView(){
        $id = Yii::$app->request->get('id',0);

        $query = new Query();
        $zhaosheng = $query->select('zhaosheng.*,zhaosheng_content.id as content_id,zhaosheng_content.content,schools.name as school_name,schools.address,zh_cities.name as city,zh_provinces.name as province,zh_districts.name as district')
            ->from('zhaosheng')
            ->leftJoin('zhaosheng_content','zhaosheng.id=zhaosheng_content.zs_id')
            ->leftJoin('schools','schools.id=zhaosheng.school_id')
            ->leftJoin('zh_cities','zh_cities.id=schools.zh_citie_id')
            ->leftJoin('zh_provinces','zh_provinces.id=schools.zh_province_id')
            ->leftJoin('zh_districts','zh_districts.id=schools.zh_district_id')
            ->where(['zhaosheng.id'=>$id])
            ->one();


        $connection = Yii::$app->db;
        $connection->createCommand('update zhaosheng set view_times = view_times+1 where id=:id',[':id'=>$id])->execute();

        $query = new Query();
        $school = $query->select('name,tel,phone')->from('schools')->where(['id'=>$zhaosheng['school_id']])->one();

        return $this->render('view',[
            'zhaosheng'=>$zhaosheng,
            'school'=>$school,
            'id'=>$id
        ]);
    }

    public function actionSuccess(){
        return $this->render('success',[]);
    }

    public function actionDetail(){
        $id = Yii::$app->request->get('id',0);
        $query = new Query();
        $post_list = $query->select('parent_name,parent_mobile,baby_age')->from('zhaosheng_post')->where(['zs_id'=>$id])->all();
        return $this->render('post_list',['post_list'=>$post_list]);
    }
}