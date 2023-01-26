<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produk".
 *
 * @property int $produk
 * @property string $nama
 * @property string $kategori
 * @property int $harga_pokok
 * @property int $harga_jual
 * @property string $status
 */
class ProdukT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'kategori', 'harga_pokok', 'harga_jual'], 'required'],
            [['harga_pokok', 'harga_jual'], 'integer'],
            [['nama'], 'string', 'max' => 255],
            [['kategori', 'status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produk' => 'Produk',
            'nama' => 'Nama',
            'kategori' => 'Kategori',
            'harga_pokok' => 'Harga Pokok',
            'harga_jual' => 'Harga Jual',
            'status' => 'Status',
        ];
    }
}
