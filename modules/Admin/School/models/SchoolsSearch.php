<?php

namespace app\modules\Admin\School\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\School\models\Schools;
use yii\db\Query;
/**
 * SchoolsSearch represents the model behind the search form about `app\modules\Admin\School\models\Schools`.
 */
class SchoolsSearch extends Schools
{
    public $custom_name_zh;
    public $custom_phone;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zh_province_id', 'zh_citie_id', 'zh_district_id', 'id', 'cat_default_id', 'catalogue_des_id', 'headmaster_id', 'creater_id', 'ispassed', 'isdeleted', 'isout'], 'integer'],
            [['custom_name_zh', 'custom_phone', 'zh_province_id', 'zh_citie_id', 'zh_district_id', 'creater_name', 'code', 'name', 'nickname', 'logo', 'tel', 'phone', 'createtime', 'starttime', 'endtime'], 'safe'],
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
        $query = Schools::find()->orderBy('id desc');
        $query->joinWith(['customs']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    'label' => 'ID'
                ],
                'headmaster_id' => [
                    'asc' => ['headmaster_id' => SORT_ASC],
                    'desc' => ['headmaster_id' => SORT_DESC],
                    'label' => '园长ID'
                ],
                'custom_name_zh' => [
                    'asc' => ['customs.name_zh' => SORT_ASC],
                    'desc' => ['customs.name_zh' => SORT_DESC],
                    'label' => '园长姓名'
                ],
                'custom_phone' => [
                    'asc' => ['customs.phone' => SORT_ASC],
                    'desc' => ['customs.phone' => SORT_DESC],
                    'label' => '园长电话'
                ],
            ]
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'schools.id' => $this->id,
            'schools.cat_default_id' => $this->cat_default_id,
            'schools.catalogue_des_id' => $this->catalogue_des_id,
            'schools.headmaster_id' => $this->headmaster_id,
            'schools.creater_id' => $this->creater_id,
            'schools.createtime' => $this->createtime,
            'schools.starttime' => $this->starttime,
            'schools.endtime' => $this->endtime,
            'schools.ispassed' => $this->ispassed,
            'schools.isdeleted' => $this->isdeleted,
            'schools.isout' => $this->isout,
            'schools.zh_province_id' => $this->zh_province_id,
            'schools.zh_citie_id' => $this->zh_citie_id,
            'schools.zh_district_id' => $this->zh_district_id,
        ]);
        $query->andFilterWhere(['like', 'schools.creater_name', $this->creater_name])
            ->andFilterWhere(['like', 'schools.code', $this->code])
            ->andFilterWhere(['like', 'schools.schools.name', $this->name])
            ->andFilterWhere(['like', 'schools.nickname', $this->nickname])
            ->andFilterWhere(['like', 'schools.logo', $this->logo])
            ->andFilterWhere(['like', 'schools.tel', $this->tel])
            ->andFilterWhere(['like', 'schools.phone', $this->phone])
            ->andFilterWhere(['like', 'customs.name_zh', $this->custom_name_zh])
            ->andFilterWhere(['like', 'customs.phone', $this->custom_phone]);
        return $dataProvider;
    }
}
