<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "akun_saldo".
 *
 * @property int $akun_saldo
 * @property int $akun
 * @property string $inorout
 * @property string $ket
 * @property int $jml
 * @property string $date
 *
 * @property Akun $akun0
 */
class AkunSaldoT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akun_saldo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akun', 'inorout', 'ket', 'jml', 'date'], 'required'],
            [['akun', 'jml'], 'integer'],
            [['ket'], 'string'],
            [['date'], 'safe'],
            [['inorout'], 'string', 'max' => 50],
            [['akun'], 'exist', 'skipOnError' => true, 'targetClass' => Akun::className(), 'targetAttribute' => ['akun' => 'akun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akun_saldo' => 'Akun Saldo',
            'akun' => 'Akun',
            'inorout' => 'Inorout',
            'ket' => 'Ket',
            'jml' => 'Jml',
            'date' => 'Date',
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
}
