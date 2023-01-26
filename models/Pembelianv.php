<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembelianv".
 *
 * @property int|null $pembelian
 * @property string|null $faktur
 * @property string|null $pembelian_tgl
 * @property string|null $pembelian_tempo
 * @property int|null $supplier
 * @property string|null $supplier_nama
 * @property int|null $us
 * @property string|null $nama
 * @property float|null $total
 * @property int|null $pembelian_diskon
 * @property float|null $total_bayar
 * @property float|null $hutang
 * @property int|null $akun
 * @property string|null $akun_nama
 */
class Pembelianv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembelianv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian', 'supplier', 'us', 'pembelian_diskon', 'akun'], 'integer'],
            [['pembelian_tgl', 'pembelian_tempo'], 'safe'],
            [['total', 'total_bayar', 'hutang'], 'number'],
            [['akun_nama'], 'string'],
            [['faktur', 'supplier_nama'], 'string', 'max' => 255],
            [['nama'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pembelian' => 'Pembelian',
            'faktur' => 'Faktur',
            'pembelian_tgl' => 'Pembelian Tgl',
            'pembelian_tempo' => 'Pembelian Tempo',
            'supplier' => 'Supplier',
            'supplier_nama' => 'Supplier Nama',
            'us' => 'Us',
            'nama' => 'Nama',
            'total' => 'Total',
            'pembelian_diskon' => 'Pembelian Diskon',
            'total_bayar' => 'Total Bayar',
            'hutang' => 'Hutang',
            'akun' => 'Akun',
            'akun_nama' => 'Akun Nama',
        ];
    }
}
