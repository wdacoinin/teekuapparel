<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanProdukStepT;


/**
 * PenjualanProdukStep represents the model behind the search form of `app\models\PenjualanProdukStepT`.
 * 
 */
class PenjualanProdukStep extends PenjualanProdukStepT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk_step', 'penjualan_produk', 'jml', 'divisi', 'user'], 'integer'],
            [['start', 'end'], 'safe'],
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
    public function search($params, $divisi)
    {
        $query = PenjualanProdukStepT::find()->where(['divisi' => $divisi]);

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
            'penjualan_produk_step' => $this->penjualan_produk_step,
            'penjualan_produk' => $this->penjualan_produk,
            'jml' => $this->jml,
            'divisi' => $this->divisi,
            'start' => $this->start,
            'end' => $this->end,
            'user' => $this->user,
        ]);

        return $dataProvider;
    }
}
