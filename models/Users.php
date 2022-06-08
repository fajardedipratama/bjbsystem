<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "id_user".
 *
 * @property int $id
 * @property string $profilname
 * @property string $username
 * @property string $password
 * @property string $last_login
 * @property string $authKey
 * @property string $accessToken
 * @property string $type
 * @property string $blocked
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profilname', 'username', 'type'], 'required'],
            ['password', 'required', 'on' => 'create'],
            [['last_login'], 'safe'],
            [['profilname', 'username', 'password', 'authKey', 'accessToken', 'type', 'blocked'], 'string', 'max' => 100],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profilname' => 'Karyawan',
            'username' => 'Username',
            'password' => 'Password',
            'last_login' => 'Login Terakhir',
            'authKey' => 'AuthKey',
            'accessToken' => 'AccessToken',
            'type' => 'Tipe',
            'blocked' => 'Blocked',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($options = array()) {

        //authkey accesstoken and hash password
        $authKey = md5($this->username);
        $accessToken = md5($this->username);

        if(empty($_POST['Users']['password']))
        {
            $pass = $_POST['oldps'];
        }
        else
        {
            $pass = Yii::$app->security->generatePasswordHash($this->password);
        }
        
        $this->password = $pass;
        $this->authKey = $authKey;
        $this->accessToken = $accessToken;

        return true;
    }
}
