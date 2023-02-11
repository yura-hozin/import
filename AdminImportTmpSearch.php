<?php

namespace backend\modules\import;

use backend\widgets\Options\OptionsWidget;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\import\AdminImportTmp;

/**
 * AdminImportTmpSearch represents the model behind the search form of `backend\modules\import\AdminImportTmp`.
 */
class AdminImportTmpSearch extends AdminImportTmp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'key', 'type', 'status'], 'integer'],
            [['data', 'comment', 'create_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = AdminImportTmp::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => OptionsWidget::widget(['ident' => 'management_pagination_adminka'])
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'key' => $this->key,
            'type' => $this->type,
            'status' => $this->status,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
