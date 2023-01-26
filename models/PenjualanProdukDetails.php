<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanProdukDetailv;

/**
 * PenjualanProdukDetails represents the model behind the search form of `app\models\PenjualanProdukDetailv`.
 */
class PenjualanProdukDetails extends PenjualanProdukDetailv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'penjualan_produk', 'produk', 'penjualan_jml', 'penjualan_harga', 'subtotal', 'id_agen'], 'integer'],
            [['nama', 'nick', 'item', 'url', 'sku_kode', 'agen', 'followup_team'], 'safe'],
            [['subtotal_detail', 'total_detail'], 'number'],
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
    public function search($params, $penjualan_produk)
    {
        $query = PenjualanProdukDetailv::find()->where(['penjualan_produk' => $penjualan_produk]);

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
            'penjualan' => $this->penjualan,
            'penjualan_produk' => $this->penjualan_produk,
            'id_agen' => $this->id_agen,
            'produk' => $this->produk,
            'penjualan_jml' => $this->penjualan_jml,
            'penjualan_harga' => $this->penjualan_harga,
            'subtotal_detail' => $this->subtotal_detail,
            'total_detail' => $this->total_detail,
            'subtotal' => $this->subtotal,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'agen', $this->agen])
            ->andFilterWhere(['like', 'followup_team', $this->followup_team])
            ->andFilterWhere(['like', 'sku_kode', $this->sku_kode])
            ->andFilterWhere(['like', 'item', $this->item]);

        return $dataProvider;
    }
}
