<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "skuv".
 *
 * @property int $sku
 * @property int $user
 * @property string $sku_kode
 * @property string $sku_date_dreate
 * @property string|null $nama_foto
 * @property string|null $type
 * @property int|null $size
 * @property string|null $url
 * @property int|null $co
 */
class Skuv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skuv';
    }
    
    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["sku"];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sku', 'user', 'size', 'co'], 'integer'],
            [['user', 'sku_kode', 'sku_date_dreate'], 'required'],
            [['sku_date_dreate'], 'safe'],
            [['sku_kode'], 'string', 'max' => 20],
            [['nama_foto', 'type', 'url'], 'string', 'max' => 255],
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
            'co' => 'Co',
        ];
    }
}
