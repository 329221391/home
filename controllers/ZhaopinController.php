<?php

namespace app\controllers;

use yii\db\Query;
use yii\web\Controller;
use Yii;
class ZhaopinController extends Controller{

    public function actionPost(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $id = Yii::$app->request->get('id',0);

            return $this->render('post',[
                'zhaopin_id'=>$id
            ]);
        }

        $person_name = Yii::$app->request->post('person_name','');
        $age = Yii::$app->request->post('age',0);
        $mobile = Yii::$app->request->post('mobile','');

        $zhaopin_id = Yii::$app->request->post('zhaopin_id',0);

        $query = new Query();
        $c = $query->select('id')->from('zhaopin_post')->where(['zp_id'=>$zhaopin_id,'mobile'=>$mobile])->count();
        if($c > 0){
            return $this->render('fail');
        }

        $connection = Yii::$app->db;
        $connection->createCommand()->insert('zhaopin_post',[
            'zp_id'=>$zhaopin_id,
            'person_name'=>$person_name,
            'age'=>$age,
            'mobile'=>$mobile,
            'create_time'=>time()
        ])->execute();

        $connection->createCommand('update zhaopin set post_count = post_count+1 where id=:id',[':id'=>$zhaopin_id])->execute();


        return $this->render('success');
    }

    public function actionView(){
        $id = Yii::$app->request->get('id',0);

        $query = new Query();
        $zhaopin = $query->select('zhaopin.*,zhaopin_content.id as content_id,zhaopin_content.content,schools.name as school_name,schools.address,zh_cities.name as city,zh_provinces.name as province,zh_districts.name as district')
            ->from('zhaopin')
            ->leftJoin('zhaopin_content','zhaopin.id=zhaopin_content.zp_id')
            ->leftJoin('schools','schools.id=zhaopin.school_id')
            ->leftJoin('zh_cities','zh_cities.id=schools.zh_citie_id')
            ->leftJoin('zh_provinces','zh_provinces.id=schools.zh_province_id')
            ->leftJoin('zh_districts','zh_districts.id=schools.zh_district_id')
            ->where(['zhaopin.id'=>$id])
            ->one();

        $connection = Yii::$app->db;
        $connection->createCommand('update zhaopin set view_times = view_times+1 where id=:id',[':id'=>$id])->execute();

        $query = new Query();
        $school = $query->select('name,tel,phone')->from('schools')->where(['id'=>$zhaopin['school_id']])->one();


        return $this->render('view',[
            'zhaopin'=>$zhaopin,
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
        $post_list = $query->select('person_name,mobile,age')->from('zhaopin_post')->where(['zp_id'=>$id])->all();
        return $this->render('post_list',['post_list'=>$post_list]);
    }
}