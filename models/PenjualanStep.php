<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanStepT;

/**
 * PenjualanStep represents the model behind the search form of `app\models\PenjualanStepT`.
 */
class PenjualanStep extends PenjualanStepT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_step', 'penjualan', 'jml', 'divisi', 'user'], 'integer'],
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
    public function search($params)
    {
        $query = PenjualanStepT::find();

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
            'penjualan_step' => $this->penjualan_step,
            'penjualan' => $this->penjualan,
            'jml' => $this->jml,
            'divisi' => $this->divisi,
            'start' => $this->start,
            'end' => $this->end,
            'user' => $this->user,
        ]);

        return $dataProvider;
    }
}
