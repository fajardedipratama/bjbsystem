<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_purchase_review".
 *
 * @property int $id
 * @property int|null $perusahaan_id
 * @property int|null $jarak_ambil
 * @property string $catatan_kirim
 * @property string $catatan_berkas
 * @property string $catatan_bayar
 * @property string $catatan_lain
 * @property string $kendala
 * @property int|null $review_by
 */
class PurchaseReview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_purchase_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perusahaan_id', 'jarak_ambil', 'review_by'], 'integer'],
            [['jarak_ambil', 'catatan_kirim', 'catatan_berkas', 'catatan_bayar', 'catatan_lain', 'kendala'], 'required'],
            [['catatan_kirim', 'catatan_berkas', 'catatan_bayar', 'catatan_lain', 'kendala'], 'string', 'max' => 2000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perusahaan_id' => 'Perusahaan',
            'jarak_ambil' => 'Jarak Ambil (hari)',
            'catatan_kirim' => 'Catatan Kirim',
            'catatan_berkas' => 'Catatan Berkas',
            'catatan_bayar' => 'Catatan Bayar',
            'catatan_lain' => 'Catatan Lain',
            'kendala' => 'Kendala',
            'review_by' => 'Review By',
        ];
    }
    public function beforeSave($options = array()) {
        $this->review_by = Yii::$app->user->identity->profilname;
        return true;
    }
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'perusahaan_id']);
    }
    public function getKaryawan()
    {
        return $this->hasOne(Karyawan::className(), ['id' => 'review_by']);
    }
}
