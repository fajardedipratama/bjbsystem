<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_send_sample".
 *
 * @property int $id
 * @property int|null $perusahaan
 * @property int|null $sales
 * @property string $penerima
 * @property string $alamat
 * @property string|null $tgl_kirim
 * @property int|null $jumlah
 * @property string $catatan
 * @property string $status
 * @property string|null $created_time
 * @property int|null $acc_by
 */
class SendSample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_send_sample';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perusahaan', 'sales', 'jumlah', 'acc_by'], 'integer'],
            [['perusahaan','penerima', 'alamat'], 'required'],
            [['tgl_kirim', 'created_time'], 'safe'],
            [['penerima', 'status'], 'string', 'max' => 100],
            [['alamat', 'catatan'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perusahaan' => 'Perusahaan',
            'sales' => 'Sales',
            'penerima' => 'Penerima',
            'alamat' => 'Alamat',
            'tgl_kirim' => 'Tanggal Kirim',
            'jumlah' => 'Jumlah (ml)',
            'catatan' => 'Catatan',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'acc_by' => 'Disetujui Oleh',
        ];
    }
    public function beforeSave($options = array()) {
        $this->penerima=ucwords(strtolower($this->penerima));
        $this->alamat=ucwords(strtolower($this->alamat));
        return true;
    }
    public function getKaryawan()
    {
        return $this->hasOne(Karyawan::className(), ['id' => 'sales']);
    }
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'perusahaan']);
    }
}
