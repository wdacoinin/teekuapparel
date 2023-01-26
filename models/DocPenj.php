<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocPenjT;

/**
 * DocPenj represents the model behind the search form of `app\models\DocPenjT`.
 */
class DocPenj extends DocPenjT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_img', 'penjualan', 'size', 'is_nota'], 'integer'],
            [['Nama_Foto', 'type', 'url'], 'safe'],
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
        $query = DocPenjT::find();

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
            'id_img' => $this->id_img,
            'penjualan' => $this->penjualan,
            'size' => $this->size,
            'is_nota' => $this->is_nota,
        ]);

        $query->andFilterWhere(['like', 'Nama_Foto', $this->Nama_Foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
