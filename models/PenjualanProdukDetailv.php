<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan_produk_detailv".
 *
 * @property int $penjualan_produk
 * @property int $produk
 * @property string|null $nama
 * @property string|null $url
 * @property string|null $sku_kode
 * @property int $penjualan_jml
 * @property int $penjualan_harga
 * @property string|null $item
 * @property float|null $subtotal_detail
 * @property float|null $total_detail
 * @property int $subtotal
 */
class PenjualanProdukDetailv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan_produk_detailv';
    }
    
    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["penjualan_produk"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'penjualan_produk', 'produk', 'penjualan_jml', 'penjualan_harga', 'subtotal', 'id_agen'], 'integer'],
            [['produk', 'penjualan_jml', 'penjualan_harga'], 'required'],
            [['item', 'nick', 'agen', 'followup_team'], 'string'],
            [['subtotal_detail', 'total_detail'], 'number'],
            [['nama', 'url'], 'string', 'max' => 255],
            [['sku_kode'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Penjualan' => 'ID Penjualan',
            'penjualan_produk' => 'Penjualan Produk',
            'produk' => 'Produk',
            'id_agen' => 'ID Agen',
            'agen' => 'Agen',
            'followup_team' => 'Desainer',
            'nama' => 'Nama',
            'url' => 'Img',
            'sku_kode' => 'SKU',
            'penjualan_jml' => 'Penjualan Jml',
            'penjualan_harga' => 'Penjualan Harga',
            'item' => 'Item',
            'nick' => 'Nickname',
            'subtotal_detail' => 'Subtotal Detail',
            'total_detail' => 'Total Detail',
            'subtotal' => 'Subtotal',
        ];
    }
}
