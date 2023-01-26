<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanT;

/**
 * Penjualan represents the model behind the search form of `app\models\PenjualanT`.
 */
class Penjualan extends PenjualanT
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'konsumen', 'penjualan_ongkir', 'fee', 'sales', 'penjualan_diskon', 'user', 'akun', 'total_bahan'], 'integer'],
            [['followup_team'], 'string'],
            [['penjualan_tgl', 'penjualan_tempo', 'faktur', 'surat_jalan', 'keterangan', 'fee_date', 'penjualan_status', 'followup_team'], 'safe'],
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
        //$query = PenjualanT::find();
        if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2){
            $query = PenjualanT::find();
        }else{
            $query = PenjualanT::find()->where(['user' => Yii::$app->user->identity->id]);
        }

        // add conditions that should always apply here// 
        
        //Important: lets join the query with our previously mentioned relations
        // I do not make any other configuration like aliases or whatever, feel free
        // to investigate that your self
        $query->joinWith(['user0', 'konsumen0', 'penjualanProduks']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['konsumen0'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['konsumen0.konsumen_nama' => SORT_ASC],
            'desc' => ['konsumen0.konsumen_nama' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['user0'] = [
            'asc' => ['user0.nama' => SORT_ASC],
            'desc' => ['user0.nama' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'penjualan' => $this->penjualan,
            //'penjualan_tgl' => $this->penjualan_tgl,
            'penjualan_tempo' => $this->penjualan_tempo,
            //'alamat' => $this->alamat,
            'penjualan_ongkir' => $this->penjualan_ongkir,
            'fee' => $this->fee,
            'fee_date' => $this->fee_date,
            //'sales' => $this->sales,
            'penjualan_diskon' => $this->penjualan_diskon,
            //'user' => $this->user,
            'akun' => $this->akun,
            'followup_team' => $this->followup_team,
        ]);

        $query->andFilterWhere(['like', 'faktur', $this->faktur])
            ->andFilterWhere(['like', 'surat_jalan', $this->surat_jalan])
            //->andFilterWhere(['between', 'penjualan_tgl', $this->start_date, $this->end_date])
            ->andFilterWhere(['like', 'konsumen.konsumen', $this->konsumen])
            ->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'sales', $this->sales])
            ->andFilterWhere(['like', 'penjualan_status', $this->penjualan_status]);

        if (!is_null($this->penjualan_tgl) && 

            strpos($this->penjualan_tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->penjualan_tgl);

            $query->andFilterWhere(['between', 'penjualan_tgl', $start_date, $end_date]);

        }
        //echo json_encode($dataProvider);
        return $dataProvider;
    }
}
