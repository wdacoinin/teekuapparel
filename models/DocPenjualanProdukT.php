<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_penjualan_produk".
 *
 * @property int $id_img
 * @property int $penjualan
 * @property string $Nama_Foto
 * @property string $type
 * @property int $size
 * @property string $url
 * @property string|null $keterangan
 * @property int|null $user
 *
 * @property Penjualan $penjualan0
 */
class DocPenjualanProdukT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_penjualan_produk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'Nama_Foto', 'type', 'size', 'url'], 'required'],
            [['penjualan', 'size', 'user'], 'integer'],
            [['keterangan'], 'string'],
            [['Nama_Foto', 'url'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_img' => 'Id Img',
            'penjualan' => 'Penjualan',
            'Nama_Foto' => 'Nama  Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
            'keterangan' => 'Keterangan',
        ];
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
}
