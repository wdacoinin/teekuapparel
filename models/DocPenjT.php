<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_penj".
 *
 * @property int $id_img
 * @property int $penjualan
 * @property string $Nama_Foto
 * @property string $type
 * @property int $size
 * @property string $url
 * @property int $is_nota
 *
 * @property Penjualan $penjualan0
 */
class DocPenjT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_penj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'Nama_Foto', 'type', 'size', 'url'], 'required'],
            [['penjualan', 'size', 'is_nota'], 'integer'],
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
            'is_nota' => 'Is Nota',
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
