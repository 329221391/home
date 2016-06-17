<?php

namespace app\modules\Admin\Logs\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Logs\models\LogsClasses;

/**
 * LogsClassesSearch represents the model behind the search form about `app\modules\Admin\Logs\models\LogsClasses`.
 */
class LogsClassesSearch extends LogsClasses
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'catalogue_id', 'table_id', 'ispassed', 'isdeleted'], 'integer'],
            [['describe', 'action', 'table_name', 'field', 'before', 'after', 'createtime', 'updatetime'], 'safe'],
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
        $query = LogsClasses::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'catalogue_id' => $this->catalogue_id,
            'table_id' => $this->table_id,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'ispassed' => $this->ispassed,
            'isdeleted' => $this->isdeleted,
        ]);

        $query->andFilterWhere(['like', 'describe', $this->describe])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'field', $this->field])
            ->andFilterWhere(['like', 'before', $this->before])
            ->andFilterWhere(['like', 'after', $this->after]);

        return $dataProvider;
    }
}
