<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rev".
 *
 * @property int $rev
 * @property int $penjualan
 * @property int $user
 * @property string $note
 * @property string $timestamp
 * @property int $rev_st
 *
 * @property Penjualan $penjualan0
 * @property BackendUser $user0
 */
class RevT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rev';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan', 'user', 'note'], 'required'],
            [['penjualan', 'user', 'rev_st'], 'integer'],
            [['note'], 'string'],
            [['timestamp'], 'safe'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => BackendUser::className(), 'targetAttribute' => ['user' => 'id']],
            [['penjualan'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan' => 'penjualan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rev' => 'Rev',
            'penjualan' => 'Penjualan',
            'user' => 'User',
            'note' => 'Note',
            'timestamp' => 'Timestamp',
            'rev_st' => 'Rev St',
        ];
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

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(BackendUser::className(), ['id' => 'user']);
    }
}
