<?php

namespace app\modules\Admin\Articles\models;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use Yii;
/**
 * This is the model class for table "article_send_revieve".
 * @property integer $id
 * @property integer $article_id
 * @property integer $sender_id
 * @property integer $reciever_id
 * @property integer $isread
 * @property string $createtime
 * @property integer $type
 */
class ArticleSendRevieve extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_send_revieve';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'sender_id', 'reciever_id', 'isread', 'type'], 'integer'],
            [['createtime', 'type'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'sender_id' => 'Sender ID',
            'reciever_id' => 'Reciever ID',
            'isread' => 'Isread',
            'createtime' => 'Createtime',
            'type' => 'Type',
        ];
    }
    public function updateIsRead($article_id, $yesorno)
    {
        $mode = ArticleSendRevieve::find()
            ->where(['reciever_id' => Yii::$app->session['custominfo']->custom->id, 'article_id' => $article_id, 'isread' => HintConst::$YesOrNo_NO])
            ->one();
        if ($mode) {
            ArticleSendRevieve::updateAll(['isread' => HintConst::$YesOrNo_YES], 'id=' . $mode['id']);
        }
    }
    public function  addArsr($dsr, $role, $school, $class, $user)
    {
		//$ba = new BaseAnalyze();
		//$ba->writeToAnal('11111111');
        if (isset(Yii::$app->session['custominfo'])) {
			//$ba->writeToAnal('22222222');
            $dsr['sender_id'] = Yii::$app->session['custominfo']->custom->id;
			//$ba->writeToAnal('3333333');
        } else {
			//$ba->writeToAnal('4444444');
            $dsr['sender_id'] = 0;
			//$ba->writeToAnal('5555555');
        }
        $dsr['role'] = $role;
        $dsr['createtime'] = CommonFun::getCurrentDateTime();
        $dsr['isread'] = HintConst::$YesOrNo_NO;
		//$ba->writeToAnal('66666666');
        if (isset($school)) {
			//$ba->writeToAnal('7777777');
            $school_arr = $this->haschar(',', $school);
            if ($school_arr) {
                $dsr['class_id'] = 0;
                $dsr['reciever_id'] = 0;
                foreach ($school_arr as $v) {
                    $dsr['school_id'] = $v;
                    $this->addNew($dsr);
                }
            } else {
                $dsr['school_id'] = $school;
                if ($school == 0) {//only admin_user  can add
                    if (isset(Yii::$app->session['admin_user'])) {
                        $this->addNew($dsr);
                    }
                } else {
                    $this->addNew($dsr);
                }
            }
        }
        if (isset($class)) {
			//$ba->writeToAnal('8888888');
            $class_arr = $this->haschar(',', $class);
            $dsr['reciever_id'] = 0;
            if ($class_arr) {
				//$ba->writeToAnal('aaaaaaa');
                foreach ($class_arr as $v) {
                    $tmp = explode('-', $v);
                    $dsr['school_id'] = $tmp[0];
                    $dsr['class_id'] = $tmp[1];
                    $this->addNew($dsr);
					//$ba->writeToAnal('bbbbbbb');
                }
            } else {
				//$ba->writeToAnal('ccccccc:'.$class);
                $tmp = $this->haschar('-', $class);
                if ($tmp) {
					//$ba->writeToAnal('ddddddd');
                    $dsr['school_id'] = $tmp[0];
                    $dsr['class_id'] = $tmp[1];
                    $this->addNew($dsr);
					//$ba->writeToAnal('eeeeeee');
                }
            }
        }
        if (isset($user)) {
			//$ba->writeToAnal('9999999');
            $user_arr = $this->haschar(',', $user);
            if ($user_arr) {
                foreach ($user_arr as $v) {
                    $tmp = explode('-', $v);
                    $dsr['school_id'] = $tmp[0];
                    $dsr['class_id'] = $tmp[1];
                    $dsr['reciever_id'] = $tmp[2];
                    $this->addNew($dsr);
                }
            } else {
                $tmp = $this->haschar('-', $user);
                if ($tmp) {
                    $dsr['school_id'] = $tmp[0];
                    $dsr['class_id'] = $tmp[1];
                    $dsr['reciever_id'] = $tmp[2];
                    $this->addNew($dsr);
                }
            }
        }
    }
    public function addNew($d)
    {
        $arsr = new self();
        foreach ($d as $k => $v) {
            $arsr->$k = $v;
        }
        $arsr->save(false);
    }
    public function getEvaReceiver($id)
    {
        $m = $this->getFeild('article_id', $id);
        if ($m !== null) {
            return $m->school_id . '-' . $m->class_id . '-' . $m->reciever_id;
        }
    }
}
