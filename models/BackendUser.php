<?php

namespace app\models;

use Yii;
use yii\base\Security;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property string $nama
 * @property string|null $phone
 * @property int $divisi
 * @property string $create_date
 *
 * @property Divisi $divisi0
 * @property PenjualanProdukStep[] $penjualanProdukSteps
 * @property Penjualan[] $penjualans
 */
class BackendUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'nama', 'divisi'], 'required'],
            [['id', 'divisi'], 'integer'],
            [['create_date'], 'safe'],
            [['username', 'password', 'authKey', 'accessToken'], 'string', 'max' => 255],
            [['nama'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 14],
            [['divisi'], 'exist', 'skipOnError' => true, 'targetClass' => Divisi::className(), 'targetAttribute' => ['divisi' => 'divisi']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'nama' => 'Nama',
            'phone' => 'Phone',
            'divisi' => 'Divisi',
            'create_date' => 'Create Date',
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
     * Gets query for [[PenjualanProdukSteps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanProdukSteps()
    {
        return $this->hasMany(PenjualanProdukStep::className(), ['user' => 'id']);
    }

    /**
     * Gets query for [[Penjualans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualans()
    {
        return $this->hasMany(Penjualan::className(), ['user' => 'id']);
    }
    

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return $this->password === sha1($password);
        $hash = $this->password;
        
        if (Yii::$app->getSecurity()->validatePassword($password, $hash)) {
            // password is good
            return $this->password;
        }

        //Yii::$app->session->setFlash('success', $this->password . ' '. $hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
}
