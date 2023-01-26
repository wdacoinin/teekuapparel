<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Timelinev;

/**
 * PenjualanProduk represents the model behind the search form of `app\models\Timelinev`.
 */
class Timeline extends Timelinev
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'penjualan_produk_step', 'divisi', 'user'], 'integer'],
            [['faktur'],'string'],
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
        if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2){
            $query = Timelinev::find();
        }else{
            $query = Timelinev::find()->where(['divisi' => Yii::$app->user->identity->divisi, 'user' => Yii::$app->user->identity->id]);
        }

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
            'faktur' => $this->faktur,
            'penjualan_produk' => $this->penjualan_produk,
            'penjualan_produk_step' => $this->penjualan_produk_step,
            'divisi' => $this->divisi,
            'user' => $this->user,
            'start' => $this->start,
            'end' => $this->end,
            'nama_divisi' => $this->nama_divisi,
            'nama_user' => $this->nama_user,
        ]);

        $query->andFilterWhere(['like', 'nama_divisi', $this->nama_divisi]);
        
        if (!is_null($this->start) && 

            strpos($this->start, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->start);

            $query->andFilterWhere(['between', 'start', $start_date, $end_date]);

        }
        
        if (!is_null($this->end) && 

            strpos($this->end, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->end);

            $query->andFilterWhere(['between', 'end', $start_date, $end_date]);

        }

        return $dataProvider;
    }

    

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchm($params, $id, $divisi)
    {
            $query = Timelinev::find()->where(['divisi' => $divisi, 'user' => $id]);

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
            'faktur' => $this->faktur,
            'penjualan_produk' => $this->penjualan_produk,
            'penjualan_produk_step' => $this->penjualan_produk_step,
            'divisi' => $this->divisi,
            'user' => $this->user,
            'start' => $this->start,
            'end' => $this->end,
            'nama_divisi' => $this->nama_divisi,
            'nama_user' => $this->nama_user,
        ]);

        $query->andFilterWhere(['like', 'nama_divisi', $this->nama_divisi]);
        
        if (!is_null($this->start) && 

            strpos($this->start, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->start);

            $query->andFilterWhere(['between', 'start', $start_date, $end_date]);

        }
        
        if (!is_null($this->end) && 

            strpos($this->end, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->end);

            $query->andFilterWhere(['between', 'end', $start_date, $end_date]);

        }

        return $dataProvider;
    }
}
