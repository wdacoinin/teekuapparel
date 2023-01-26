<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beban_list".
 *
 * @property int $beban_list
 * @property int $beban_owner
 * @property int $akun
 * @property int $beban
 * @property int $jumlah
 * @property string $detail
 * @property string $tgl
 * @property string|null $nama_foto
 * @property string|null $type
 * @property string|null $url
 * @property string|null $size
 *
 * @property Akun $akun0
 * @property Beban $beban0
 */
class BebanListT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beban_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['beban_owner', 'akun', 'beban', 'jumlah', 'size'], 'integer'],
            [['akun', 'beban', 'jumlah', 'detail', 'tgl'], 'required'],
            [['detail'], 'string'],
            [['tgl'], 'safe'],
            [['nama_foto', 'type', 'url'], 'string', 'max' => 255],
            [['akun'], 'exist', 'skipOnError' => true, 'targetClass' => Akun::className(), 'targetAttribute' => ['akun' => 'akun']],
            [['beban'], 'exist', 'skipOnError' => true, 'targetClass' => Beban::className(), 'targetAttribute' => ['beban' => 'beban']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'beban_list' => 'Beban List',
            'beban_owner' => 'Beban Owner',
            'akun' => 'Akun',
            'beban' => 'Beban',
            'jumlah' => 'Jumlah',
            'detail' => 'Detail',
            'tgl' => 'Tgl',
            'nama_foto' => 'Nama Foto',
            'type' => 'Type',
            'url' => 'Url',
            'size' => 'Size',
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
     * Gets query for [[Beban0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeban0()
    {
        return $this->hasOne(Beban::className(), ['beban' => 'beban']);
    }
}
