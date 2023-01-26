<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanProdukT;

/**
 * PenjualanProduk represents the model behind the search form of `app\models\PenjualanProdukT`.
 */
class PenjualanProduk extends PenjualanProdukT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'penjualan', 'produk', 'bahan_baku', 'penjualan_jml', 'penjualan_hpp', 'penjualan_harga', 'retur_qty', 'item_from_retur', 'sku'], 'integer'],
            [['penjualan_produksi_status', 'nick', 'retur_date', 'timestamp'], 'safe'],
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
        $query = PenjualanProdukT::find();

        // add conditions that should always apply here
        $query->joinWith(['produk0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['produk0'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['produk0.nama' => SORT_ASC],
            'desc' => ['produk0.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'penjualan_produk' => $this->penjualan_produk,
            'penjualan' => $this->penjualan,
            'produk' => $this->produk,
            'bahan_baku' => $this->bahan_baku,
            'penjualan_jml' => $this->penjualan_jml,
            'penjualan_hpp' => $this->penjualan_hpp,
            'penjualan_harga' => $this->penjualan_harga,
            'retur_qty' => $this->retur_qty,
            'retur_date' => $this->retur_date,
            'item_from_retur' => $this->item_from_retur,
            'timestamp' => $this->timestamp,
            'sku' => $this->sku,
        ]);

        $query->andFilterWhere(['like', 'penjualan_produksi_status', $this->penjualan_produksi_status])
        ->andFilterWhere(['like', 'produk0.nama', $this->produk]);

        return $dataProvider;
    }
}
