<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_purchase_order_paid".
 *
 * @property int $id
 * @property int $purchase_order_id
 * @property string $paid_date
 * @property int $amount
 * @property string $bank
 * @property string $note
 */
class PurchaseOrderPaid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_purchase_order_paid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchase_order_id', 'paid_date', 'amount'], 'required'],
            [['purchase_order_id', 'amount'], 'integer'],
            [['paid_date'], 'safe'],
            [['note'], 'string', 'max' => 100],
            [['bank'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_id' => 'ID PO',
            'paid_date' => 'Tanggal Bayar',
            'amount' => 'Jumlah',
            'bank' => 'Bank',
            'note' => 'Catatan',
        ];
    }
}
