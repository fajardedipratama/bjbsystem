<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_pelamar_jadwal".
 *
 * @property int $id
 * @property int $id_pelamar
 * @property string $tanggal
 * @property string $jenis
 * @property string $kehadiran
 */
class PelamarJadwal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_pelamar_jadwal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'jenis'], 'required'],
            [['id_pelamar'], 'integer'],
            [['tanggal'], 'safe'],
            [['jenis', 'kehadiran'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pelamar' => 'Pelamar',
            'tanggal' => 'Tanggal',
            'jenis' => 'Jenis',
            'kehadiran' => 'Kehadiran',
        ];
    }
    public function getPelamar()
    {
        return $this->hasOne(Pelamar::className(), ['id' => 'id_pelamar']);
    }
}
