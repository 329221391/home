<?php

namespace app\modules\Admin\Apkversion\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Apkversion\models\Apkversion;

/**
 * ApkversionSearch represents the model behind the search form about `app\modules\Admin\Apkversion\models\Apkversion`.
 */
class ApkversionSearch extends Apkversion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_default_id', 'times', 'isdeleted', 'ispassed', 'ismust_update'], 'integer'],
            [['name', 'describe', 'primary_version', 'sub_version', 'url', 'createtime'], 'safe'],
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
        $query = Apkversion::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cat_default_id' => $this->cat_default_id,
            'times' => $this->times,
            'createtime' => $this->createtime,
            'isdeleted' => $this->isdeleted,
            'ispassed' => $this->ispassed,
            'ismust_update' => $this->ismust_update,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'describe', $this->describe])
            ->andFilterWhere(['like', 'primary_version', $this->primary_version])
            ->andFilterWhere(['like', 'sub_version', $this->sub_version])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
