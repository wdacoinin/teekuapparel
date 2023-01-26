<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanKotorv;

/**
 * Penjualan represents the model behind the search form of `app\models\PenjualanT`.
 */
class PenjualanKotor extends PenjualanKotorv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subtotal', 'total_kotor'], 'number'],
            [['penjualan', 'total_bahan'], 'integer'],
            [['faktur', 'konsumen_nama', 'penjualan_status'], 'string'],
            [['faktur', 'konsumen_nama', 'penjualan_tgl'], 'safe'],
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
        $query = PenjualanKotorv::find()->where('penjualan_status != "Batal Order"');

        // add conditions that should always apply here// 

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
            'faktur' => $this->faktur,
            'konsumen_nama' => $this->konsumen_nama,
        ]);

        if (!is_null($this->penjualan_tgl) && 

            strpos($this->penjualan_tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->penjualan_tgl);

            $query->andFilterWhere(['between', 'penjualan_tgl', $start_date, $end_date]);

        }
        //echo json_encode($dataProvider);
        return $dataProvider;
    }
}
