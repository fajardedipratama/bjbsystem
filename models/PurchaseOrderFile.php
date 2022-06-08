<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_purchase_order_file".
 *
 * @property int $id
 * @property int $purchase_order_id
 * @property string $penerima
 * @property string $alamat
 * @property string $berkas
 * @property string $kirim_by
 * @property string|null $tgl_kirim
 */
class PurchaseOrderFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_purchase_order_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchase_order_id', 'penerima', 'alamat','berkas'], 'required'],
            [['purchase_order_id'], 'integer'],
            [['tgl_kirim'], 'safe'],
            [['penerima','berkas','kirim_by'], 'string', 'max' => 100],
            [['alamat'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_id' => 'Purchase Order ID',
            'penerima' => 'Penerima',
            'alamat' => 'Alamat',
            'berkas' => 'Berkas',
            'tgl_kirim' => 'Dikirim',
            'kirim_by' => 'Via',
        ];
    }
}
