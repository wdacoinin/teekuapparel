<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "global_stokv".
 *
 * @property string|null $nama
 * @property float|null $pembelian_jml
 * @property float|null $stok_out
 * @property float|null $jml_now
 * @property int $harga_satuan
 * @property string|null $satuan
 * @property float|null $total
 */
class GlobalStokv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'global_stokv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian_jml', 'stok_out', 'jml_now', 'total'], 'number'],
            [['harga_satuan'], 'required'],
            [['harga_satuan'], 'integer'],
            [['nama'], 'string', 'max' => 255],
            [['satuan'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nama' => 'Nama',
            'pembelian_jml' => 'Stok Masuk',
            'stok_out' => 'Stok Out',
            'jml_now' => 'Stok Now',
            'harga_satuan' => 'Harga Satuan',
            'satuan' => 'Satuan',
            'total' => 'Total',
        ];
    }
}
