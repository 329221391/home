<?php

namespace app\modules\Admin\Message\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Message\models\Msgsendrecieve;

/**
 * MsgsendrecieveSearch represents the model behind the search form about `app\modules\Admin\Message\models\Msgsendrecieve`.
 */
class MsgsendrecieveSearch extends Msgsendrecieve
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'message_id', 'sender_id', 'reciever_id', 'isread'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Msgsendrecieve::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'message_id' => $this->message_id,
            'sender_id' => $this->sender_id,
            'reciever_id' => $this->reciever_id,
            'isread' => $this->isread,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        return $dataProvider;
    }
}
