<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembelian_bahan".
 *
 * @property int $pembelian_bahan
 * @property int $pembelian
 * @property int $bahan_baku
 * @property int $item_bonus
 * @property float $pembelian_jml
 * @property float $pembelian_berat
 * @property int $pembelian_harga
 * @property int $harga_jual
 * @property int $pembelian_bahan_status
 * @property float $jml_now
 * @property string $pembelian_bahan_date
 * @property string $timestamp
 *
 * @property BahanBaku $bahanBaku
 * @property Pembelian $pembelian0
 */
class PembelianBahanT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembelian_bahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian', 'bahan_baku', 'pembelian_jml', 'pembelian_harga', 'pembelian_bahan_date'], 'required'],
            [['pembelian', 'bahan_baku', 'item_bonus', 'pembelian_harga', 'harga_jual', 'pembelian_bahan_status'], 'integer'],
            [['pembelian_jml', 'pembelian_berat', 'jml_now'], 'number'],
            [['pembelian_bahan_date', 'timestamp'], 'safe'],
            [['pembelian'], 'exist', 'skipOnError' => true, 'targetClass' => Pembelian::className(), 'targetAttribute' => ['pembelian' => 'pembelian']],
            [['bahan_baku'], 'exist', 'skipOnError' => true, 'targetClass' => BahanBaku::className(), 'targetAttribute' => ['bahan_baku' => 'bahan_baku']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pembelian_bahan' => 'Pembelian Bahan',
            'pembelian' => 'Pembelian',
            'bahan_baku' => 'Bahan Baku',
            'item_bonus' => 'Item Bonus',
            'pembelian_jml' => 'Pembelian Jml',
            'pembelian_berat' => 'Pembelian Berat',
            'pembelian_harga' => 'Pembelian Harga @Satuan',
            'harga_jual' => 'Harga Jual',
            'pembelian_bahan_status' => 'Pembelian Bahan Status',
            'jml_now' => 'Jml Now',
            'pembelian_bahan_date' => 'Pembelian Bahan Date',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[BahanBaku]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBahanBaku()
    {
        return $this->hasOne(BahanBaku::className(), ['bahan_baku' => 'bahan_baku']);
    }

    /**
     * Gets query for [[Pembelian0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembelian0()
    {
        return $this->hasOne(Pembelian::className(), ['pembelian' => 'pembelian']);
    }
}
