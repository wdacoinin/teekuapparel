<?php

namespace app\models;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * This is the model class for table "timeline_v".
 *
 * @property string $faktur
 * @property int $penjualan_produk
 * @property int|null $penjualan_produk_step
 * @property string|null $start
 * @property string|null $end
 * @property int|null $divisi
 * @property int|null $user
 * @property string|null $nama_divisi
 * @property string|null $nama_user
 */

 
class Timelinev extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeline_v';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_produk', 'penjualan_produk_step', 'divisi', 'user'], 'integer'],
            [['faktur'],'string'],
            [['start', 'end'], 'safe'],
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
            'start' => 'Start',
            'end' => 'End',
            'divisi' => 'Divisi',
            'user' => 'User',
            'nama_divisi' => 'Nama Divisi',
            'nama_user' => 'Nama User',
        ];
    }

}
