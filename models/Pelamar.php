<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_pelamar".
 *
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property string $no_hp
 * @property string $alamat
 * @property string $gender
 * @property string $agama
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $pendidikan
 * @property string $status_nikah
 * @property int $posisi
 * @property string $status
 */
class Pelamar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_pelamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'email', 'no_hp', 'alamat', 'gender', 'agama', 'tanggal_lahir', 'pendidikan', 'posisi' ], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['posisi'], 'integer'],
            [['nama', 'email', 'no_hp', 'alamat', 'gender', 'agama', 'tempat_lahir', 'pendidikan', 'status_nikah', 'status'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'email' => 'Email',
            'no_hp' => 'No Hp',
            'alamat' => 'Alamat',
            'gender' => 'Jenis Kelamin',
            'agama' => 'Agama',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'pendidikan' => 'Pendidikan',
            'status_nikah' => 'Status Nikah',
            'posisi' => 'Posisi',
            'status' => 'Status',
        ];
    }
    public function getJobtitle()
    {
        return $this->hasOne(Jobtitle::className(), ['id' => 'posisi']);
    }
}
