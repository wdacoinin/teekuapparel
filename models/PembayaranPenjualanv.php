<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembayaran_penjualanv".
 *
 * @property int $akun_log
 * @property int $idref
 * @property string $inorout
 * @property string|null $faktur
 * @property int $jml
 * @property string $tgl
 * @property int $user
 * @property string|null $url
 * @property string|null $Nama_Foto
 * @property string|null $admin
 */
class PembayaranPenjualanv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembayaran_penjualanv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akun_log', 'idref', 'jml', 'user', 'id_img'], 'integer'],
            [['idref', 'inorout', 'jml', 'user'], 'required'],
            [['tgl'], 'safe'],
            [['inorout'], 'string', 'max' => 50],
            [['faktur', 'url', 'Nama_Foto', 'akun_nama'], 'string', 'max' => 255],
            [['admin'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akun_log' => 'Akun Log',
            'akun_nama' => 'Rekening',
            'idref' => 'Idref',
            'inorout' => 'Inorout',
            'faktur' => 'Faktur',
            'jml' => 'Jml.Pembayaran',
            'tgl' => 'Tgl',
            'user' => 'User',
            'url' => 'Url',
            'id_img' => 'Img id',
            'Nama_Foto' => 'Nama  Foto',
            'admin' => 'Admin',
        ];
    }
}
