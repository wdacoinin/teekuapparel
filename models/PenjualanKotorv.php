<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan_kotorv".
 *
 * @property int $penjualan
 * @property string|null $faktur
 * @property string|null $penjualan_tgl
 * @property string|null $penjualan_status
 * @property string|null $konsumen_nama
 * @property float|null $subtotal
 * @property int|null $total_bahan
 * @property float|null $total_kotor
 */
class PenjualanKotorv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan_kotorv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subtotal', 'total_kotor'], 'number'],
            [['total_bahan', 'penjualan'], 'integer'],
            [['penjualan_tgl', 'penjualan_status'], 'safe'],
            [['faktur', 'konsumen_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'faktur' => 'Faktur',
            'penjualan_tgl' => 'Tgl',
            'konsumen_nama' => 'Konsumen Nama',
            'subtotal' => 'Subtotal',
            'total_bahan' => 'Total Bahan',
            'total_kotor' => 'Laba Kotor',
        ];
    }
}
