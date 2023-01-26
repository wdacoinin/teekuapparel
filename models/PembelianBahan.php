<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PembelianBahanT;

$satuan;
/**
 * PembelianBahan represents the model behind the search form of `app\models\PembelianBahanT`.
 */
class PembelianBahan extends PembelianBahanT
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian_bahan', 'pembelian', 'bahan_baku', 'item_bonus', 'pembelian_jml', 'pembelian_harga', 'harga_jual', 'pembelian_bahan_status', 'jml_now'], 'integer'],
            [['pembelian_berat'], 'number'],
            [['bahan_baku', 'pembelian_bahan_date', 'timestamp'], 'safe'],
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
        $query = PembelianBahanT::find();

        // add conditions that should always apply here
        $query->joinWith(['bahanBaku', 'pembelian0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['bahanBaku'] = [
            'asc' => ['bahanBaku.nama' => SORT_ASC],
            'desc' => ['bahanBaku.nama' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['bahanBaku'] = [
            'asc' => ['bahanBaku.satuan' => SORT_ASC],
            'desc' => ['bahanBaku.satuan' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['pembelian0'] = [
            'asc' => ['pembelian0.faktur' => SORT_ASC],
            'desc' => ['pembelian0.faktur' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pembelian_bahan' => $this->pembelian_bahan,
            'pembelian0.faktur' => $this->pembelian,
            'bahan_baku.bahan_baku' => $this->bahan_baku,
            'item_bonus' => $this->item_bonus,
            'pembelian_jml' => $this->pembelian_jml,
            'pembelian_berat' => $this->pembelian_berat,
            'pembelian_harga' => $this->pembelian_harga,
            'harga_jual' => $this->harga_jual,
            'pembelian_bahan_status' => $this->pembelian_bahan_status,
            'jml_now' => $this->jml_now,
            'pembelian_bahan_date' => $this->pembelian_bahan_date,
            'timestamp' => $this->timestamp,
        ]);

       /*  $query->andFilterWhere(['like', 'bahanBaku.satuan', $this->bahan_baku]); */

        return $dataProvider;
    }
}
