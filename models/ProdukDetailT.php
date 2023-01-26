<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produk_detail".
 *
 * @property int $produk_detail
 * @property int $penjualan_produk
 * @property int $produk_item
 *
 * @property PenjualanProduk $penjualanProduk
 * @property ProdukItem $produkItem
 */
class ProdukDetailT extends \yii\db\ActiveRecord
{
    public $produk;
    public $sku;
    public $qty;
    public $nick;
    public $size;
    public $neck;
    public $lengan;
    public $vareasi;
    public $bahan_baku;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produk_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'produk_item'], 'required'],
            [['penjualan_produk', 'produk_item', 'size', 'neck', 'lengan', 'vareasi', 'qty', 'produk', 'sku', 'bahan_baku'], 'integer'],
            [['nick'], 'string'],
            [['produk_item'], 'exist', 'skipOnError' => true, 'targetClass' => ProdukItem::className(), 'targetAttribute' => ['produk_item' => 'produk_item']],
            [['penjualan_produk'], 'exist', 'skipOnError' => true, 'targetClass' => PenjualanProduk::className(), 'targetAttribute' => ['penjualan_produk' => 'penjualan_produk']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produk' => 'Produk',
            'sku' => 'SKU',
            'produk_detail' => 'Produk Detail',
            'penjualan_produk' => 'Penjualan Produk',
            'produk_item' => 'Produk Item',
            'qty' => 'Qty',
            'nick' => 'Nickname',
            'size' => 'Size',
            'neck' => 'Neck',
            'lengan' => 'Lengan',
            'vareasi' => 'Vareasi',
            'bahan_baku' => 'Bahan Baku',
        ];
    }

    /**
     * Gets query for [[PenjualanProduk]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProduk()
    {
        return $this->hasOne(PenjualanProduk::className(), ['penjualan_produk' => 'penjualan_produk']);
    }

    /**
     * Gets query for [[ProdukItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdukItem()
    {
        return $this->hasOne(ProdukItem::className(), ['produk_item' => 'produk_item']);
    }
}
