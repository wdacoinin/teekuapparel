<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocPembT;

/**
 * DocPemb represents the model behind the search form of `app\models\DocPembT`.
 */
class DocPemb extends DocPembT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_img', 'pembelian', 'size'], 'integer'],
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
        $query = DocPembT::find();

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
            'pembelian' => $this->pembelian,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'Nama_Foto', $this->Nama_Foto])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
