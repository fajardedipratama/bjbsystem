<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_pelamar_akses".
 *
 * @property int $id
 * @property int $karyawan
 * @property string $akses
 */
class PelamarAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_pelamar_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['karyawan', 'akses'], 'required'],
            [['karyawan'], 'integer'],
            [['akses'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'karyawan' => 'User',
            'akses' => 'Akses',
        ];
    }
    public function getEmployee()
    {
        return $this->hasOne(Karyawan::className(), ['id' => 'karyawan']);
    }
}
