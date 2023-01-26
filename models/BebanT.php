<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beban".
 *
 * @property int $beban
 * @property string $nama
 */
class BebanT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beban';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'beban' => 'Beban',
            'nama' => 'Nama',
        ];
    }
}
