<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_offer_extra".
 *
 * @property int $id
 * @property int $offer_id
 * @property string $top
 * @property int $harga
 * @property string $pajak
 */
class OfferExtra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_offer_extra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['offer_id', 'top', 'harga', 'pajak'], 'required'],
            [['offer_id', 'harga'], 'integer'],
            [['top', 'pajak'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offer_id' => 'Offer ID',
            'top' => 'TOP',
            'harga' => 'Harga',
            'pajak' => 'Pajak',
        ];
    }
}
