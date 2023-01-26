<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdukT;

/**
 * Produk represents the model behind the search form of `app\models\ProdukT`.
 */
class Produk extends ProdukT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk', 'harga_pokok', 'harga_jual'], 'integer'],
            [['nama', 'kategori', 'status'], 'safe'],
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
        $query = ProdukT::find();

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
            'produk' => $this->produk,
            'harga_pokok' => $this->harga_pokok,
            'harga_jual' => $this->harga_jual,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'kategori', $this->kategori])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
