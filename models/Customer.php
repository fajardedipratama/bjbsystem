<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_customer".
 *
 * @property int $id
 * @property string $perusahaan
 * @property string $lokasi
 * @property string $alamat_lengkap
 * @property string $pic
 * @property string $telfon
 * @property string $email
 * @property string $catatan
 * @property int|null $sales
 * @property string|null $expired
 * @property string|null $expired_pusat
 * @property string|null $expired_pending
 * @property string $long_expired
 * @property int|null $created_by
 * @property string|null $created_time
 * @property string $verified
 * @property string $entrusted
 */
class Customer extends \yii\db\ActiveRecord
{
    public $target, $dari_tgl, $ke_tgl;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perusahaan', 'lokasi', 'pic','alamat_lengkap'], 'required'],
            [['expired','expired_pusat','expired_pending','created_time','$dari_tgl','$ke_tgl'], 'safe'],
            [['perusahaan','lokasi','pic','telfon','verified','long_expired','entrusted'], 'string', 'max' => 100],
            [['alamat_lengkap', 'catatan'], 'string', 'max' => 1000],
            [['sales','created_by','target'], 'integer'],
            [['email'], 'email', 'message'=>'Penulisan alamat email tidak valid, pastikan ada @ dan diakhiri dengan domain'],
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
            'lokasi' => 'Kab/Kota',
            'alamat_lengkap' => 'Alamat',
            'pic' => 'PIC',
            'telfon' => 'Telfon',
            'email' => 'Email',
            'catatan' => 'Catatan',
            'sales' => 'Sales',
            'expired' => 'Expired',
            'expired_pusat' => 'Expired Pusat',
            'expired_pending' => 'Expired Pending',
            'long_expired' => 'Perpanjang ?',
            'created_by' => 'Add By',
            'created_time' => 'Created',
            'verified' => 'Verif.',
            'target' => 'Target',
            'entrusted'=>'Pihak Eksternal',
            'dari_tgl'=>'Dari Tanggal',
            'ke_tgl'=>'Ke Tanggal',
        ];
    }
    
    public function beforeSave($options = array()) {
        $this->perusahaan = strtoupper($this->perusahaan);
        if($this->isNewRecord){
            $this->created_by = Yii::$app->user->identity->profilname;
            $this->created_time = date('Y-m-d H:i:s');
        }
        return true;
    }
    public function beforeDelete($options = array()) {
        
        Yii::$app->db->createCommand()->delete('id_dailyreport',['perusahaan'=>$this->id])->execute();
        Yii::$app->db->createCommand()->delete('id_offer',['perusahaan'=>$this->id])->execute();
        Yii::$app->db->createCommand()->delete('id_purchase_order',['perusahaan'=>$this->id])->execute();

        return true;
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'lokasi']);
    }
    public function getKaryawan()
    {
        return $this->hasOne(Karyawan::className(), ['id' => 'sales']);
    }
    public function getCreatedby()
    {
        return $this->hasOne(Karyawan::className(), ['id' => 'created_by']);
    }
}
