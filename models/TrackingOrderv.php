<?php

namespace app\models;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * This is the model class for table "tracking_orderv".
 *
 * @property int $faktur
 * @property int $penjualan_produk
 * @property int|null $penjualan_produk_step
 * @property int|null $jml
 * @property string|null $label
 * @property string|null $start
 * @property string|null $end
 * @property int|null $divisi
 * @property int|null $user
 * @property string|null $nama_divisi
 * @property string|null $nama_user
 */

 
class TrackingOrderv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tracking_orderv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'penjualan_produk_step', 'jml', 'divisi', 'user'], 'integer'],
            [['label','faktur'], 'string'],
            [['start', 'end'], 'safe'],
            [['nama_divisi'], 'string', 'max' => 255],
            [['nama_user'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'faktur' => 'Faktur',
            'penjualan_produk' => 'Penjualan Produk',
            'penjualan_produk_step' => 'Penjualan Produk Step',
            'jml' => 'Jml',
            'label' => 'Label',
            'start' => 'Start',
            'end' => 'End',
            'divisi' => 'Divisi',
            'user' => 'User',
            'nama_divisi' => 'Nama Divisi',
            'nama_user' => 'Nama User',
        ];
    }

}
