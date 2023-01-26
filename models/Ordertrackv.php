<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordertrackv".
 *
 * @property int|null $penjualan_step
 * @property int $penjualan
 * @property string|null $faktur
 * @property int $jml
 * @property int|null $divisi
 */
class Ordertrackv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordertrackv';
    }
    
    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["penjualan"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_step', 'penjualan', 'jml', 'divisi'], 'integer'],
            [['penjualan'], 'required'],
            [['faktur'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualan_step' => 'Penjualan Step',
            'penjualan' => 'Penjualan',
            'faktur' => 'Faktur',
            'jml' => 'Jml',
            'divisi' => 'Divisi',
        ];
    }
}
