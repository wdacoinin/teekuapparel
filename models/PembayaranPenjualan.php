<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PembayaranPenjualanv;

/**
 * PembayaranPenjualan represents the model behind the search form of `app\models\PembayaranPenjualanv`.
 */
class PembayaranPenjualan extends PembayaranPenjualanv
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembayaran_penjualanv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akun_log', 'idref', 'jml', 'user', 'id_img'], 'integer'],
            [['tgl'], 'safe'],
            [['inorout'], 'string', 'max' => 50],
            [['faktur', 'url', 'Nama_Foto', 'akun_nama'], 'string', 'max' => 255],
            [['admin'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akun_log' => 'Akun Log',
            'akun_nama' => 'Rekening',
            'idref' => 'Idref',
            'inorout' => 'Inorout',
            'faktur' => 'Faktur',
            'jml' => 'Jml.Pembayaran',
            'tgl' => 'Tgl',
            'user' => 'User',
            'url' => 'Url',
            'id_img' => 'Id_img',
            'Nama_Foto' => 'Nama  Foto',
            'admin' => 'Admin',
        ];
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
        $query = PembayaranPenjualanv::find();
        

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
            'akun_nama' => $this->akun_nama,
            'idref' => $this->idref,
            //'inorout' => $this->inorout,
            //'faktur' => $this->faktur,
            'jml' => $this->jml,
            'user' => $this->user,
            'url' => $this->url,
            'id_img' => $this->id_img,
            //'admin' => $this->admin,
        ]);

        $query->andFilterWhere(['like', 'idref', $this->faktur])
        ->andFilterWhere(['like', 'inorout', $this->inorout])
        ->andFilterWhere(['like', 'admin', $this->admin]);
        
        if (!is_null($this->tgl) && 

            strpos($this->tgl, ' - ') !== false ) {

            list($start_date, $end_date) = explode(' - ', $this->tgl);

            $query->andFilterWhere(['between', 'tgl', $start_date, $end_date]);

        }

        return $dataProvider;
    }
}
