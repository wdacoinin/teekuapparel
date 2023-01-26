<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PembelianT;

/**
 * MPembelianT represents the model behind the search form of `app\models\PembelianT`.
 */
class MPembelianT extends PembelianT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian', 'supplier', 'us', 'pembelian_diskon'], 'integer'],
            [['pembelian_tgl', 'pembelian_status', 'faktur', 'pembelian_tempo', 'no_sj', 'keterangan'], 'safe'],
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
        $query = PembelianT::find();

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
            'pembelian' => $this->pembelian,
            'pembelian_tgl' => $this->pembelian_tgl,
            'supplier' => $this->supplier,
            'us' => $this->us,
            'pembelian_tempo' => $this->pembelian_tempo,
            'pembelian_diskon' => $this->pembelian_diskon,
        ]);

        $query->andFilterWhere(['like', 'pembelian_status', $this->pembelian_status])
            ->andFilterWhere(['like', 'faktur', $this->faktur])
            ->andFilterWhere(['like', 'no_sj', $this->no_sj])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
