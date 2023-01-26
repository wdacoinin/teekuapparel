<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bahan_baku_so".
 *
 * @property int $bahan_baku_so
 * @property int $bahan_baku
 * @property int $pembelian_bahan
 * @property int $jml
 * @property float $berat
 * @property string $date
 * @property int $us
 *
 * @property BahanBaku $bahanBaku
 * @property PembelianBahan $pembelianBahan
 */
class BahanBakuSoT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bahan_baku_so';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahan_baku', 'pembelian_bahan', 'jml', 'berat', 'date', 'us'], 'required'],
            [['bahan_baku', 'pembelian_bahan', 'jml', 'us'], 'integer'],
            [['berat'], 'number'],
            [['date'], 'safe'],
            [['bahan_baku'], 'exist', 'skipOnError' => true, 'targetClass' => BahanBaku::className(), 'targetAttribute' => ['bahan_baku' => 'bahan_baku']],
            [['pembelian_bahan'], 'exist', 'skipOnError' => true, 'targetClass' => PembelianBahan::className(), 'targetAttribute' => ['pembelian_bahan' => 'pembelian_bahan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bahan_baku_so' => 'Bahan Baku So',
            'bahan_baku' => 'Bahan Baku',
            'pembelian_bahan' => 'Pembelian Bahan',
            'jml' => 'Jml',
            'berat' => 'Berat',
            'date' => 'Date',
            'us' => 'Us',
        ];
    }

    /**
     * Gets query for [[BahanBaku]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBahanBaku()
    {
        return $this->hasOne(BahanBaku::className(), ['bahan_baku' => 'bahan_baku']);
    }

    /**
     * Gets query for [[PembelianBahan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembelianBahan()
    {
        return $this->hasOne(PembelianBahan::className(), ['pembelian_bahan' => 'pembelian_bahan']);
    }
}
