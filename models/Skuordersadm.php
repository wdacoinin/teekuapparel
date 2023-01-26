<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SkuT;

/**
 * Skus represents the model behind the search form of `app\models\Sku`.
 */
class Skuordersadm extends SkuT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sku', 'user', 'size', 'co'], 'integer'],
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
        $m = date('Y-m');
        $query = SkuT::find()
        ->select(['sku.*', 'COUNT(sku.sku) AS co', 'penjualan_produk.timestamp AS mo'])
        ->join("LEFT JOIN", "penjualan_produk", "penjualan_produk.sku = sku.sku")
        ->where(['DATE_FORMAT(penjualan_produk.timestamp,"%Y-%m")' => $m])
        ->groupBy('sku.sku')
        ->orderBy('co DESC');

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
            'mo' => $this->mo,
            'size' => $this->size,
            'co' => $this->co,
        ]);

        $query->andFilterWhere(['like', 'sku_kode', $this->sku_kode])
            ->andFilterWhere(['like', 'nama_foto', $this->nama_foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
