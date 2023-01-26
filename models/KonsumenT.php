<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konsumen".
 *
 * @property int $konsumen
 * @property string $konsumen_nama
 * @property string|null $alamat
 * @property int $limits
 */
class KonsumenT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konsumen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['konsumen_nama', 'limits'], 'required'],
            [['alamat'], 'string'],
            [['limits'], 'integer'],
            [['konsumen_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'konsumen' => 'Konsumen',
            'konsumen_nama' => 'Konsumen Nama',
            'alamat' => 'Alamat',
            'limits' => 'Limits',
        ];
    }
}
