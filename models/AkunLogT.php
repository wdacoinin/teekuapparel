<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "akun_log".
 *
 * @property int $akun_log
 * @property string $inorout
 * @property int $idref
 * @property int $akun
 * @property int $jml
 * @property string $tgl
 * @property int $user
 * @property int $id_img
 *
 * @property AkunT $akun0
 */
class AkunLogT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akun_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inorout', 'idref', 'akun', 'jml', 'user'], 'required'],
            [['idref', 'akun', 'jml', 'user'], 'integer'],
            [['tgl', 'id_img'], 'safe'],
            [['inorout'], 'string', 'max' => 50],
            [['akun'], 'exist', 'skipOnError' => true, 'targetClass' => AkunT::className(), 'targetAttribute' => ['akun' => 'akun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akun_log' => 'Akun Log',
            'inorout' => 'Tipe (Dp / Bayar Lunas (set: Penjualan))',
            'idref' => 'Idref',
            'akun' => 'Akun',
            'jml' => 'Jml',
            'tgl' => 'Tgl.Pembayaran',
            'user' => 'User',
            'id_img' => 'Id Img',
        ];
    }

    /**
     * Gets query for [[Akun0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAkun0()
    {
        return $this->hasOne(AkunT::className(), ['akun' => 'akun']);
    }
}
