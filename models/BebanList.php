<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BebanListT;

/**
 * BebanList represents the model behind the search form of `app\models\BebanListT`.
 */
class BebanList extends BebanListT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['beban_list', 'beban_owner', 'akun', 'beban', 'jumlah', 'size'], 'integer'],
            [['detail', 'tgl', 'nama_foto', 'type', 'url', 'size'], 'safe'],
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
        $query = BebanListT::find();

        // add conditions that should always apply here
        $query->joinWith(['akun0', 'beban0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['akun0'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['akun0.akun_ref' => SORT_ASC],
            'desc' => ['akun0.akun_ref' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['beban0'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['beban0.nama' => SORT_ASC],
            'desc' => ['beban0.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'beban_list' => $this->beban_list,
            'akun.akun' => $this->akun,
            'beban.beban' => $this->beban,
            'jumlah' => $this->jumlah,
            //'tgl' => $this->tgl,
        ]);

        if (!is_null($this->tgl) && 

            strpos($this->tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->tgl);

            $query->andFilterWhere(['between', 'tgl', $start_date, $end_date]);

        }

        return $dataProvider;
    }
}
