<?php

namespace app\modules\Admin\Admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Admin\models\Admins;

/**
 * AdminsSearch represents the model behind the search form about `app\modules\Admin\Admin\models\Admins`.
 */
class AdminsSearch extends Admins
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ispassed', 'isdeleted'], 'integer'],
            [['name', 'nickname', 'password', 'createtime', 'updatetime'], 'safe'],
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
        $query = Admins::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'ispassed' => $this->ispassed,
            'isdeleted' => $this->isdeleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
