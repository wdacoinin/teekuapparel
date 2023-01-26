<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_pemb".
 *
 * @property int $id_img
 * @property int $pembelian
 * @property string $Nama_Foto
 * @property string $type
 * @property int $size
 * @property string $url
 *
 * @property Pembelian $pembelian0
 */
class DocPembT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_pemb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian', 'Nama_Foto', 'type', 'size', 'url'], 'required'],
            [['pembelian', 'size'], 'integer'],
            [['Nama_Foto', 'url'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['pembelian'], 'exist', 'skipOnError' => true, 'targetClass' => Pembelian::className(), 'targetAttribute' => ['pembelian' => 'pembelian']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_img' => 'Id Img',
            'pembelian' => 'Pembelian',
            'Nama_Foto' => 'Nama  Foto',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Pembelian0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembelian0()
    {
        return $this->hasOne(Pembelian::className(), ['pembelian' => 'pembelian']);
    }
}
