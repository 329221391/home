<?php

namespace app\modules\Admin\Articles\models;
use Yii;
/**
 * This is the model class for table "customs".
 * @property integer $id
 * @property integer $school_id
 * @property integer $class_id
 * @property integer $cat_default_id
 * @property integer $catalogue_des_id
 * @property string $name
 * @property string $name_zh
 * @property string $nickname
 * @property string $logo
 * @property string $password
 * @property string $description
 * @property string $token
 * @property string $tel
 * @property string $phone
 * @property string $ip
 * @property string $ip_last
 * @property integer $ispassed
 * @property integer $isdeleted
 * @property integer $isout
 * @property integer $isstar
 * @property integer $iscansend
 * @property string $createtime
 * @property string $updatetime
 * @property string $starttime
 * @property string $endtime
 * @property string $article_max_id
 * @property string $pingjia_max_id
 * @property string $reply_max_id
 * @property string $message_max_id
 * @property string $unpass_a_max_id
 * @property string $unpass_j_max_id
 */
class Customs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customs';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id', 'class_id', 'cat_default_id', 'catalogue_des_id', 'ispassed', 'isdeleted', 'isout', 'isstar', 'iscansend', 'article_max_id', 'pingjia_max_id', 'reply_max_id', 'message_max_id', 'unpass_a_max_id', 'unpass_j_max_id'], 'integer'],
            [['createtime', 'updatetime', 'starttime', 'endtime'], 'safe'],
            [['name', 'name_zh', 'nickname', 'password', 'token', 'tel', 'phone'], 'string', 'max' => 45],
            [['logo'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['ip', 'ip_last'], 'string', 'max' => 20]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_id' => 'School ID',
            'class_id' => 'Class ID',
            'cat_default_id' => 'Cat Default ID',
            'catalogue_des_id' => 'Catalogue Des ID',
            'name' => 'Name',
            'name_zh' => 'Name Zh',
            'nickname' => 'Nickname',
            'logo' => 'Logo',
            'password' => 'Password',
            'description' => 'Description',
            'token' => 'Token',
            'tel' => 'Tel',
            'phone' => 'Phone',
            'ip' => 'Ip',
            'ip_last' => 'Ip Last',
            'ispassed' => 'Ispassed',
            'isdeleted' => 'Isdeleted',
            'isout' => 'Isout',
            'isstar' => 'Isstar',
            'iscansend' => 'Iscansend',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'article_max_id' => 'Article Max ID',
            'pingjia_max_id' => 'Pingjia Max ID',
            'reply_max_id' => 'Reply Max ID',
            'message_max_id' => 'Message Max ID',
            'unpass_a_max_id' => 'Unpass A Max ID',
            'unpass_j_max_id' => 'Unpass J Max ID',
        ];
    }
    //�����û������ѿ��������� ���� ����
    public function update_max($user_id, $arr)
    {
        $model = $this->findone($user_id);
        if (isset($model->id)) {
            foreach ($arr as $kk => $vv) {
                if ($vv) {
                    $model->$kk = $vv;
                    //�����û�session
                    Yii::$app->session['custominfo']->custom->$kk = $vv;
                }
            }
            $model->save();
            return true;
        } else {
            return false;
        }
    }
}
