<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembelian".
 *
 * @property int $pembelian
 * @property string $pembelian_tgl
 * @property int $supplier
 * @property string $pembelian_status
 * @property int $us
 * @property string|null $faktur
 * @property string|null $pembelian_tempo
 * @property string $no_sj
 * @property string $keterangan
 * @property int $pembelian_diskon
 * @property int $akun
 *
 * @property Akun $akun0
 * @property DocPemb[] $docPembs
 * @property PembelianBahan[] $pembelianBahans
 * @property Supplier $supplier0
 * @property BackendUser $us0
 */
class PembelianT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian_tgl', 'supplier', 'pembelian_status', 'us'], 'required'],
            [['pembelian_tgl', 'pembelian_tempo'], 'safe'],
            [['supplier', 'us', 'pembelian_diskon', 'akun'], 'integer'],
            [['keterangan'], 'string'],
            [['pembelian_status'], 'string', 'max' => 20],
            [['faktur', 'no_sj'], 'string', 'max' => 255],
            [['supplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier' => 'supplier']],
            [['us'], 'exist', 'skipOnError' => true, 'targetClass' => BackendUser::className(), 'targetAttribute' => ['us' => 'id']],
            [['akun'], 'exist', 'skipOnError' => true, 'targetClass' => Akun::className(), 'targetAttribute' => ['akun' => 'akun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pembelian' => 'Pembelian',
            'pembelian_tgl' => 'Pembelian Tgl',
            'supplier' => 'Supplier',
            'pembelian_status' => 'Pembelian Status',
            'us' => 'Us',
            'faktur' => 'Faktur',
            'pembelian_tempo' => 'Pembelian Tempo',
            'no_sj' => 'No Sj / No.Nota Supplier',
            'keterangan' => 'Keterangan',
            'pembelian_diskon' => 'Pembelian Diskon',
            'akun' => 'Akun',
        ];
    }

    /**
     * Gets query for [[Akun0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAkun0()
    {
        return $this->hasOne(Akun::className(), ['akun' => 'akun']);
    }

    /**
     * Gets query for [[DocPembs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocPembs()
    {
        return $this->hasMany(DocPemb::className(), ['pembelian' => 'pembelian']);
    }

    /**
     * Gets query for [[PembelianBahans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembelianBahans()
    {
        return $this->hasMany(PembelianBahan::className(), ['pembelian' => 'pembelian']);
    }

    /**
     * Gets query for [[Supplier0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier0()
    {
        return $this->hasOne(Supplier::className(), ['supplier' => 'supplier']);
    }

    /**
     * Gets query for [[Us0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs0()
    {
        return $this->hasOne(BackendUser::className(), ['id' => 'us']);
    }
}
