<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pembelianv;

/**
 * pembelian represents the model behind the search form of `app\models\Pembelianv`.
 */
class PembelianView extends Pembelianv
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian', 'supplier', 'us', 'pembelian_diskon', 'akun'], 'integer'],
            [['faktur', 'pembelian_tempo', 'pembelian_tgl', 'penjualan_tempo', 'nama', 'akun_nama', 'supplier_nama'], 'safe'],
            [['total', 'total_bayar', 'hutang'], 'number'],
            [['akun_nama', 'faktur', 'supplier_nama', 'nama'], 'string'],
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
        
        if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2 || Yii::$app->user->identity->divisi == 3){
            $query = Pembelianv::find();
        }else{
            $query = Pembelianv::find()->where(['us' => Yii::$app->user->identity->id]);
        }

        // add conditions that should always apply here// 
        
        //Important: lets join the query with our previously mentioned relations
        // I do not make any other configuration like aliases or whatever, feel free
        // to investigate that your self

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'pembelian' => $this->pembelian,
            //'penjualan_tempo' => $this->penjualan_tempo,
            //'fee' => $this->fee,
            //'penjualan_diskon' => $this->penjualan_diskon,
            //'Total' => $this->Total,
            //'total_bayar' => $this->total_bayar,
            //'piutang' => $this->piutang,
            //'GT' => $this->GT,
            //'faktur' => $this->faktur,
            //'konsumen_nama' => $this->konsumen_nama,
            //'nama_sales' => $this->nama_sales,
            //'divisi' => $this->divisi,
        ]);

        $query->andFilterWhere(['like', 'pembelian', $this->pembelian])
            ->andFilterWhere(['like', 'supplier_nama', $this->supplier_nama])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        if (!is_null($this->pembelian_tgl) && 

            strpos($this->pembelian_tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->pembelian_tgl);

            $query->andFilterWhere(['between', 'pembelian_tgl', $start_date, $end_date]);

        }

        if (!is_null($this->pembelian_tempo) && 

            strpos($this->pembelian_tempo, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->pembelian_tempo);

            $query->andFilterWhere(['between', 'pembelian_tempo', $start_date, $end_date]);

        }
        //echo json_encode($dataProvider);
        return $dataProvider;
    }
}
