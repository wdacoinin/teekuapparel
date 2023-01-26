<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualanv".
 *
 * @property int $penjualan
 * @property int|null $user
 * @property int $sales
 * @property string $faktur
 * @property string|null $konsumen_nama
 * @property string $penjualan_tgl
 * @property string $penjualan_status
 * @property string|null $penjualan_tempo
 * @property int $penjualan_diskon
 * @property int $penjualan_ongkir
 * @property int $fee
 * @property int|null $hprint
 * @property int|null $acc_desain
 * @property string|null $acc_date
 * @property int|null $desainer
 * @property float|null $Total
 * @property string|null $divisi
 * @property string|null $nama_sales
 * @property float|null $total_bayar
 * @property float|null $GT
 * @property float|null $piutang
 */
class OrderT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualanv';
    }
    
    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["penjualan"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'user', 'sales', 'penjualan_diskon', 'penjualan_ongkir', 'fee', 'hprint', 'acc_desain', 'desainer'], 'integer'],
            [['sales', 'faktur', 'penjualan_tgl'], 'required'],
            [['penjualan_tgl', 'penjualan_tempo', 'acc_date'], 'safe'],
            [['Total', 'total_bayar', 'GT', 'piutang'], 'number'],
            [['faktur', 'konsumen_nama', 'divisi'], 'string', 'max' => 255],
            [['nama_sales'], 'string', 'max' => 150],
            [['penjualan_status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualan' => 'Penjualan',
            'user' => 'User',
            'sales' => 'Sales',
            'faktur' => 'Faktur',
            'konsumen_nama' => 'Konsumen',
            'penjualan_tgl' => 'Penjualan Tgl',
            'penjualan_status' => 'Status',
            'penjualan_tempo' => 'Tempo',
            'penjualan_diskon' => 'Diskon',
            'penjualan_ongkir' => 'Ongkir',
            'fee' => 'Fee',
            'hprint' => 'Hprint',
            'acc_desain' => 'Acc Desain',
            'acc_date' => 'Acc Date',
            'desainer' => 'Desainer',
            'Total' => 'Total',
            'divisi' => 'Divisi',
            'nama_sales' => 'Nama Sales',
            'total_bayar' => 'Total Bayar',
            'GT' => 'Gt',
            'piutang' => 'Piutang',
        ];
    }
}
