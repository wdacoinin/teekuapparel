<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdukDetailT;

/**
 * ProdukDetail represents the model behind the search form of `app\models\ProdukDetailT`.
 */
class ProdukDetail extends ProdukDetailT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk_detail', 'penjualan_produk', 'produk_item'], 'integer'],
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
        $query = ProdukDetailT::find();

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
            'produk_detail' => $this->produk_detail,
            'penjualan_produk' => $this->penjualan_produk,
            'produk_item' => $this->produk_item,
        ]);

        return $dataProvider;
    }
}
