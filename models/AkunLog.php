<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AkunLogT;

/**
 * AkunLog represents the model behind the search form of `app\models\AkunLogT`.
 */
class AkunLog extends AkunLogT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akun_log', 'idref', 'akun', 'jml', 'user'], 'integer'],
            [['inorout', 'tgl', 'id_img'], 'safe'],
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
        $query = AkunLogT::find();

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
            'akun_log' => $this->akun_log,
            'idref' => $this->idref,
            'akun' => $this->akun,
            'jml' => $this->jml,
            'tgl' => $this->tgl,
            'user' => $this->user,
            'id_img' => $this->id_img,
        ]);

        $query->andFilterWhere(['like', 'inorout', $this->inorout]);

        return $dataProvider;
    }
}
