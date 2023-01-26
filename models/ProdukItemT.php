<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produk_item".
 *
 * @property int $produk_item
 * @property string $produk_item_nama
 * @property int $produk_item_harga
 * @property string $produk_item_status
 *
 * @property ProdukDetailT $produkDetail
 */
class ProdukItemT extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produk_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk_item_nama', 'produk_item_harga'], 'required'],
            [['produk_item_harga'], 'integer'],
            [['produk_item_nama'], 'string', 'max' => 255],
            [['produk_item_status', 'produk_item_kat'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produk_item' => 'Item',
            'produk_item_nama' => 'Item Nama',
            'produk_item_harga' => 'Item Harga',
            'produk_item_kat' => 'Kategori',
            'produk_item_status' => 'Item Status',
        ];
    }

    /**
     * Gets query for [[ProdukDetail]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdukDetail()
    {
        return $this->hasOne(ProdukDetailT::className(), ['produk_item' => 'produk_item']);
    }
}
