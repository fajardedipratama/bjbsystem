<?php

namespace app\models;
use Yii;
use app\models\Users;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $profilname;
    public $username;
    public $password;
    public $last_login;
    public $authKey;
    public $accessToken;
    public $type;
    public $blocked;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'cbhdbcjskdbcjskxmskmkasacssc',
            'password' => 'cbhdbcjskdbcjskxmskmkasacssc',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'cbhdbcjskdbcjskxmskmkasacssc',
            'password' => 'cbhdbcjskdbcjskxmskmkasacssc',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $user = Users::findOne($id);
        if($user){
            return new static($user);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
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

        $user = Users::find()->where(['username'=>$username])->one();
        if($user){
            return new static($user);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password,$this->password);
    }
}
