<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_offer_permit".
 *
 * @property int $id
 * @property int $id_customer
 */
class OfferPermit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_offer_permit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_customer'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_customer' => 'Id Customer',
        ];
    }
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'id_customer']);
    }
}
