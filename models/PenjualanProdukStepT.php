<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan_produk_step".
 *
 * @property int $penjualan_produk_step
 * @property int $penjualan_produk
 * @property int $jml
 * @property int $divisi
 * @property string $start
 * @property string $end
 * @property int $user
 *
 * @property PenjualanProduk $penjualanProduk
 * @property BackendUser $user0
 */
class PenjualanProdukStepT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan_produk_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'divisi', 'start', 'user'], 'required'],
            [['penjualan_produk', 'jml', 'divisi', 'user'], 'integer'],
            [['start', 'end'], 'safe'],
            [['penjualan_produk'], 'exist', 'skipOnError' => true, 'targetClass' => PenjualanProduk::className(), 'targetAttribute' => ['penjualan_produk' => 'penjualan_produk']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => BackendUser::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualan_produk_step' => 'Penjualan Produk Step',
            'penjualan_produk' => 'Penjualan Produk',
            'penjualan_produk.produk' => 'Produk',
            'jml' => 'Jml',
            'divisi' => 'Divisi',
            'start' => 'Masuk',
            'end' => 'Selesai',
            'user' => 'User',
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
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(BackendUser::className(), ['id' => 'user']);
    }
}