<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bahan_baku".
 *
 * @property int $bahan_baku
 * @property string|null $nama
 * @property int|null $panjang_bahan
 * @property string $satuan
 * @property int $harga
 * @property string|null $kode
 * @property string $timestamp
 *
 * @property BahanBakuSo[] $bahanBakuSos
 */
class BahanBakuT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bahan_baku';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['panjang_bahan', 'harga'], 'integer'],
            [['nama', 'satuan', 'harga'], 'required'],
            [['timestamp'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['satuan'], 'string', 'max' => 50],
            [['kode'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bahan_baku' => 'Bahan Baku',
            'nama' => 'Nama',
            'panjang_bahan' => 'Panjang Bahan',
            'satuan' => 'Satuan',
            'harga' => 'Harga',
            'kode' => 'Kode',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[BahanBakuSos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBahanBakuSos()
    {
        return $this->hasMany(BahanBakuSo::className(), ['bahan_baku' => 'bahan_baku']);
    }
}
