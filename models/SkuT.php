<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sku".
 *
 * @property int $sku
 * @property int $user
 * @property string $sku_kode
 * @property string $sku_date_dreate
 * @property string|null $nama_foto
 * @property string|null $type
 * @property int|null $size
 * @property int|null $co
 * @property string $mo
 * @property string|null $url
 *
 * @property PenjualanProduk $penjualanProduk
 * @property BackendUser $user0
 */
class SkuT extends \yii\db\ActiveRecord
{
    public $co;
    public $mo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sku';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'sku_kode', 'sku_date_dreate'], 'required'],
            [['user', 'size', 'co'], 'integer'],
            [['sku_date_dreate', 'mo'], 'safe'],
            [['sku_kode'], 'string', 'max' => 20],
            [['nama_foto', 'type', 'url'], 'string', 'max' => 255],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => BackendUser::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sku' => 'Sku',
            'user' => 'User',
            'sku_kode' => 'Sku Kode',
            'sku_date_dreate' => 'Sku Date Dreate',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
            'co' => 'Qty',
            'mo' => 'Tgl',
        ];
    }

    /**
     * Gets query for [[PenjualanProduk]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProduk()
    {
        return $this->hasOne(PenjualanProduk::className(), ['sku' => 'sku']);
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
