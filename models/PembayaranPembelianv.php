<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembayaran_pembelianv".
 *
 * @property int $akun_log
 * @property string|null $akun_nama
 * @property int $idref
 * @property string $inorout
 * @property string|null $faktur
 * @property int $jml
 * @property string $tgl
 * @property int $user
 * @property int|null $id_img
 * @property string|null $url
 * @property string|null $Nama_Foto
 * @property string|null $admin
 */
class PembayaranPembelianv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembayaran_pembelianv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akun_log', 'idref', 'jml', 'user', 'id_img'], 'integer'],
            [['akun_nama'], 'string'],
            [['idref', 'inorout', 'jml', 'user'], 'required'],
            [['tgl'], 'safe'],
            [['inorout'], 'string', 'max' => 50],
            [['faktur', 'url', 'Nama_Foto'], 'string', 'max' => 255],
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
            'akun_nama' => 'Akun Nama',
            'idref' => 'Idref',
            'inorout' => 'Inorout',
            'faktur' => 'Faktur',
            'jml' => 'Jml',
            'tgl' => 'Tgl',
            'user' => 'User',
            'id_img' => 'Id Img',
            'url' => 'Url',
            'Nama_Foto' => 'Nama  Foto',
            'admin' => 'Admin',
        ];
    }
}
