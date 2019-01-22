<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "task_monitoring.user".
 *
 * @property int $id
 * @property string $nik
 * @property string $role
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_monitoring.user';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nik', 'password'], 'required'],
            [['nik'], 'number'],
            [['password','role'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nik' => 'Nik',
            'role' => 'Role',
            'password' => 'Password',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $result = static::findOne(['accessToken'=>$token]);
        return new static($result);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['username'], $username) === 0) {
        //         return new static($user);
        //     }
        // }
        $result = self::find()->where(['nik'=>$username])->one();

        return new static($result);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        // return $this->authkey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authkey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
