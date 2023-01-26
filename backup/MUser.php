<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * MUser represents the model behind the search form of `app\models\User`.
 */
class MUser extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'password', 'authKey', 'accessToken', 'nama', 'phone', 'divisi', 'create_date'], 'safe'],
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
        $query = User::find();

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
            'id' => $this->id,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            //->andFilterWhere(['like', 'password', $this->password])
            //->andFilterWhere(['like', 'authKey', $this->authKey])
            //->andFilterWhere(['like', 'accessToken', $this->accessToken])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'divisi', $this->divisi]);

        return $dataProvider;
    }
}
