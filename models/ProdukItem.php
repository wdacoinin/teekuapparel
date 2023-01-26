<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdukItemT;

/**
 * ProdukItem represents the model behind the search form of `app\models\ProdukItemT`.
 */
class ProdukItem extends ProdukItemT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk_item', 'produk_item_harga'], 'integer'],
            [['produk_item_nama', 'produk_item_status', 'produk_item_kat'], 'safe'],
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
        $query = ProdukItemT::find()->orderBy('produk_item_kat ASC');

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
            'produk_item' => $this->produk_item,
            'produk_item_harga' => $this->produk_item_harga,
            'produk_item_kat' => $this->produk_item_kat,
        ]);

        $query->andFilterWhere(['like', 'produk_item_nama', $this->produk_item_nama])
            ->andFilterWhere(['like', 'produk_item_status', $this->produk_item_status]);

        return $dataProvider;
    }
}
