<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Penjualanv;

/**
 * Penjualan represents the model behind the search form of `app\models\Penjualanv`.
 */
class PenjualanSrc extends Penjualanv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'user', 'sales', 'penjualan_diskon', 'fee'], 'integer'],
            [['sales', 'faktur', 'penjualan_tgl'], 'required'],
            [['penjualan_tgl', 'penjualan_tempo'], 'safe'],
            [['Total', 'total_bayar', 'GT', 'piutang'], 'number'],
            [['faktur', 'konsumen_nama', 'divisi'], 'string', 'max' => 255],
            [['nama_sales'], 'string', 'max' => 150],
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
        
        if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2){
            $query = Penjualanv::find();
        }else{
            $query = Penjualanv::find()->where(['user' => Yii::$app->user->identity->id]);
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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'penjualan' => $this->penjualan,
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

        $query->andFilterWhere(['like', 'penjualan', $this->faktur])
            ->andFilterWhere(['like', 'konsumen_nama', $this->konsumen_nama])
            ->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'nama_sales', $this->nama_sales])
            ->andFilterWhere(['like', 'divisi', $this->divisi]);

        if (!is_null($this->penjualan_tgl) && 

            strpos($this->penjualan_tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->penjualan_tgl);

            $query->andFilterWhere(['between', 'penjualan_tgl', $start_date, $end_date]);

        }
        //echo json_encode($dataProvider);
        return $dataProvider;
    }
}
