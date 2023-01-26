<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BahanBakuSoT;

/**
 * BahanBakuSo represents the model behind the search form of `app\models\BahanBakuSoT`.
 */
class BahanBakuSo extends BahanBakuSoT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahan_baku_so', 'bahan_baku', 'pembelian_bahan', 'jml', 'us'], 'integer'],
            [['berat'], 'number'],
            [['date'], 'safe'],
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
        $query = BahanBakuSoT::find();

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
            'bahan_baku_so' => $this->bahan_baku_so,
            'bahan_baku' => $this->bahan_baku,
            'pembelian_bahan' => $this->pembelian_bahan,
            'jml' => $this->jml,
            'berat' => $this->berat,
            'date' => $this->date,
            'us' => $this->us,
        ]);

        return $dataProvider;
    }
}
