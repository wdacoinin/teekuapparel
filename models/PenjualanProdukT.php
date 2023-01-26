<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan_produk".
 *
 * @property int $penjualan_produk
 * @property int $penjualan
 * @property int $produk
 * @property int|null $bahan_baku
 * @property int $penjualan_jml
 * @property int $penjualan_hpp
 * @property int $penjualan_harga
 * @property string|null $penjualan_produksi_status
 * @property int|null $retur_qty
 * @property string|null $retur_date
 * @property int|null $item_from_retur
 * @property string $timestamp
 * @property int $sku
 * @property string $nick
 *
 * @property DocPenjualanProduk[] $docPenjualanProduks
 * @property Penjualan $penjualan0
 * @property PenjualanProdukStep[] $penjualanProdukSteps
 * @property Produk $produk0
 * @property ProdukDetail[] $produkDetails
 * @property Sku $sku0
 */
class PenjualanProdukT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan_produk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'produk', 'penjualan_jml', 'penjualan_harga', 'sku'], 'required'],
            [['penjualan', 'produk', 'bahan_baku', 'penjualan_jml', 'penjualan_hpp', 'penjualan_harga', 'retur_qty', 'item_from_retur', 'sku'], 'integer'],
            [['retur_date', 'timestamp'], 'safe'],
            [['nick'], 'string'],
            [['penjualan_produksi_status'], 'string', 'max' => 50],
            [['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
            [['produk'], 'exist', 'skipOnError' => true, 'targetClass' => Produk::className(), 'targetAttribute' => ['produk' => 'produk']],
            [['sku'], 'exist', 'skipOnError' => true, 'targetClass' => Sku::className(), 'targetAttribute' => ['sku' => 'sku']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualan_produk' => 'Penjualan Produk',
            'penjualan' => 'Penjualan',
            'produk' => 'Produk',
            'bahan_baku' => 'Bahan',
            'penjualan_jml' => 'Penjualan Jml',
            'penjualan_hpp' => 'Penjualan Hpp',
            'penjualan_harga' => 'Penjualan Harga',
            'penjualan_produksi_status' => 'Penjualan Produksi Status',
            'retur_qty' => 'Retur Qty',
            'retur_date' => 'Retur Date',
            'item_from_retur' => 'Item From Retur',
            'timestamp' => 'Timestamp',
            'sku' => 'Sku',
            'nick' => 'Nickname',
        ];
    }

    /**
     * Gets query for [[DocPenjualanProduks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocPenjualanProduks()
    {
        return $this->hasMany(DocPenjualanProduk::className(), ['penjualan_produk' => 'penjualan_produk']);
    }

    /**
     * Gets query for [[Penjualan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualan0()
    {
        return $this->hasOne(Penjualan::className(), ['penjualan' => 'penjualan']);
    }

    /**
     * Gets query for [[PenjualanProdukSteps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProdukSteps()
    {
        return $this->hasMany(PenjualanProdukStep::className(), ['penjualan_produk' => 'penjualan_produk']);
    }

    /**
     * Gets query for [[Produk0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduk0()
    {
        return $this->hasOne(Produk::className(), ['produk' => 'produk']);
    }

    /**
     * Gets query for [[ProdukDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdukDetails()
    {
        return $this->hasMany(ProdukDetail::className(), ['penjualan_produk' => 'penjualan_produk']);
    }

    /**
     * Gets query for [[Sku0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSku0()
    {
        return $this->hasOne(Sku::className(), ['sku' => 'sku']);
    }
}
