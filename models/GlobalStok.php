<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GlobalStokv;

/**
 * Penjualan represents the model behind the search form of `app\models\PenjualanT`.
 */
class GlobalStok extends GlobalStokv
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'pembelian_jml', 'stok_out', 'jml_now', 'total', 'harga_satuan', 'satuan'], 'safe'],
            [['pembelian_jml', 'stok_out', 'jml_now', 'total', 'harga_satuan'], 'number'],
            [['satuan'], 'string'],
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
            $query = GlobalStokv::find();

        // add conditions that should always apply here// 
        
        //Important: lets join the query with our previously mentioned relations
        // I do not make any other configuration like aliases or whatever, feel free
        // to investigate that your self

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'satuan', $this->satuan]);

        return $dataProvider;
    }
}
