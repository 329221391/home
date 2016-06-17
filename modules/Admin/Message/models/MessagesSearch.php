<?php

namespace app\modules\Admin\Message\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Message\models\Messages;

/**
 * MessagesSearch represents the model behind the search form about `app\modules\Admin\Message\models\Messages`.
 */
class MessagesSearch extends Messages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'school_id', 'class_id', 'ispassed', 'isdeleted', 'isview', 'istimer'], 'integer'],
            [['contents', 'starttime', 'endtime', 'createtime', 'updatetime'], 'safe'],
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
        $query = Messages::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'school_id' => $this->school_id,
            'class_id' => $this->class_id,
            'ispassed' => $this->ispassed,
            'isdeleted' => $this->isdeleted,
            'isview' => $this->isview,
            'istimer' => $this->istimer,
            'starttime' => $this->starttime,
            'endtime' => $this->endtime,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'contents', $this->contents]);

        return $dataProvider;
    }
}
