<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_karyawan".
 *
 * @property int $id
 * @property int $badge
 * @property string $nama
 * @property string $nama_pendek
 * @property string $gender
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $agama
 * @property string $no_hp
 * @property string $no_ktp
 * @property string $alamat_ktp
 * @property string $alamat_rumah
 * @property string $pendidikan
 * @property string $status_kawin
 * @property string $tanggal_masuk
 * @property int $posisi
 * @property int|null $departemen
 * @property string $bank
 * @property string $no_rekening
 * @property string $nama_rekening
 * @property string $tipe_gaji
 * @property string $foto_karyawan
 * @property string $status_aktif
 * @property string $alasan_resign
 * @property string|null $tgl_resign
 */
class Karyawan extends \yii\db\ActiveRecord
{
    public $tanggal,$waktu;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_karyawan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['badge', 'nama', 'nama_pendek', 'gender', 'tempat_lahir', 'tanggal_lahir', 'no_hp', 'alamat_rumah','tanggal_masuk', 'posisi', 'departemen'], 'required'],
            [['tanggal_lahir', 'tanggal_masuk','tanggal','waktu','tgl_resign'], 'safe'],
            [['badge', 'posisi', 'departemen'], 'integer'],
            [['nama','nama_pendek', 'gender', 'tempat_lahir', 'agama', 'no_hp', 'no_ktp', 'pendidikan', 'status_kawin', 'bank','no_rekening',  'nama_rekening', 'status_aktif', 'tipe_gaji'], 'string', 'max' => 100],
            [['alamat_ktp', 'alamat_rumah','alasan_resign'], 'string', 'max' => 1000],
            [['foto_karyawan'], 'file', 'extensions' => 'png, jpg, jpeg','mimeTypes'=>'image/jpeg,image/png', 'maxSize'=>1048576,'skipOnEmpty'=>true],
            [['badge'], 'unique'],
            [['no_ktp'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'badge' => 'NIP',
            'nama' => 'Nama Lengkap',
            'nama_pendek' => 'Nama Panggilan',
            'gender' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'agama' => 'Agama',
            'no_hp' => 'No.HP',
            'no_ktp' => 'No.KTP',
            'alamat_ktp' => 'Alamat KTP',
            'alamat_rumah' => 'Alamat Tempat Tinggal',
            'pendidikan' => 'Pendidikan',
            'status_kawin' => 'Status Nikah',
            'tanggal_masuk' => 'Tanggal Masuk',
            'posisi' => 'Jabatan',
            'departemen' => 'Departemen',
            'bank' => 'Bank',
            'no_rekening' => 'No. Rekening',
            'nama_rekening' => 'Nama Rekening',
            'tipe_gaji' => 'Tipe Gaji',
            'foto_karyawan' => 'Foto Karyawan',
            'status_aktif' => 'Status Karyawan',
            'waktu' => 'waktu',
            'alasan_resign'=>'Alasan',
            'tgl_resign'=>'Tanggal Keluar',
        ];
    }
    public function getJobtitle()
    {
        return $this->hasOne(Jobtitle::className(), ['id' => 'posisi']);
    }
    public function getDepartement()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen']);
    }
}
