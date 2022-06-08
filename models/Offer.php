<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_offer".
 *
 * @property int $id
 * @property string $tanggal
 * @property string $waktu
 * @property int|null $no_surat
 * @property int $perusahaan
 * @property string $pic
 * @property string $top
 * @property string $pajak
 * @property int|null $harga
 * @property string $catatan
 * @property int $sales
 * @property string $status
 * @property string $is_new
 * @property int|null $send_wa
 * @property int|null $show_tax
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_offer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perusahaan', 'pic', 'top', 'pajak', 'harga'], 'required'],
            [['tanggal','waktu'], 'safe'],
            [['no_surat', 'perusahaan', 'harga','sales','send_wa', 'show_tax'], 'integer'],
            [['pic', 'top', 'pajak', 'status','is_new'], 'string', 'max' => 100],
            [['catatan'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanggal' => 'Tanggal',
            'waktu' => 'Jam',
            'no_surat' => 'No.Surat',
            'perusahaan' => 'Perusahaan',
            'pic' => 'PIC',
            'top' => 'TOP',
            'pajak' => 'Pajak',
            'harga' => 'Harga',
            'catatan' => 'Catatan',
            'sales' => 'Sales',
            'status' => 'Status',
            'is_new' => 'Penawaran Baru ?',
            'send_wa' => 'Kirim WhatsApp ?',
            'show_tax' => 'Tampil Harga PPN & PPH22 ?',
        ];
    }

    public function beforeSave($options = array()) {
        $this->pic=ucwords(strtolower($this->pic));
        if($this->isNewRecord){
            $this->status='Pending';
            $this->tanggal=date('Y-m-d');
            $this->waktu=date('H:i:s');
        }
        
        return true;
    }
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'perusahaan']);
    }
    public function getKaryawan()
    {
        return $this->hasOne(Karyawan::className(), ['id' => 'sales']);
    }
}
