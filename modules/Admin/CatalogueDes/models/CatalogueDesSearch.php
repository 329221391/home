<?php

namespace app\modules\Admin\CatalogueDes\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\CatalogueDes\models\CatalogueDes;

/**
 * CatalogueDesSearch represents the model behind the search form about `app\modules\Admin\CatalogueDes\models\CatalogueDes`.
 */
class CatalogueDesSearch extends CatalogueDes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'school_id', 'parent_id', 'priority', 'last_admin_id', 'ispassed', 'isdeleted'], 'integer'],
            [['name_zh', 'describe', 'createtime', 'updatetime'], 'safe'],
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
        $query = CatalogueDes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'school_id' => $this->school_id,
            'parent_id' => $this->parent_id,
            'priority' => $this->priority,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'last_admin_id' => $this->last_admin_id,
            'ispassed' => $this->ispassed,
            'isdeleted' => $this->isdeleted,
        ]);

        $query->andFilterWhere(['like', 'name_zh', $this->name_zh])
            ->andFilterWhere(['like', 'describe', $this->describe]);

        return $dataProvider;
    }
}
