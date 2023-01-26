<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan_step".
 *
 * @property int $penjualan_step
 * @property int $penjualan
 * @property int $jml
 * @property int $divisi
 * @property string|null $start
 * @property string|null $end
 * @property int|null $user
 *
 * @property Divisi $divisi0
 * @property Penjualan $penjualan0
 */
class PenjualanStepT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'divisi'], 'required'],
            [['penjualan', 'jml', 'divisi', 'user'], 'integer'],
            [['start', 'end'], 'safe'],
            [['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
            [['divisi'], 'exist', 'skipOnError' => true, 'targetClass' => Divisi::className(), 'targetAttribute' => ['divisi' => 'divisi']],
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
            'jml' => 'Jml',
            'divisi' => 'Divisi',
            'start' => 'Start',
            'end' => 'End',
            'user' => 'User',
        ];
    }

    /**
     * Gets query for [[Divisi0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDivisi0()
    {
        return $this->hasOne(Divisi::className(), ['divisi' => 'divisi']);
    }

    /**
     * Gets query for [[Penjualan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualan0()
    {
        return $this->hasOne(Penjualan::className(), ['penjualan' => 'penjualan']);
    }
}
