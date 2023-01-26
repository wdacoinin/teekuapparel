<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SkuT;

/**
 * Sku represents the model behind the search form of `app\models\SkuT`.
 */
class Sku extends SkuT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sku', 'user', 'size'], 'integer'],
            [['sku_kode', 'sku_date_dreate', 'nama_foto', 'type', 'url'], 'safe'],
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
        $query = SkuT::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'sku' => $this->sku,
            'user' => $this->user,
            'sku_date_dreate' => $this->sku_date_dreate,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'sku_kode', $this->sku_kode])
            ->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
