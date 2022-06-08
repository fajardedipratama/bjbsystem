<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_offer_number".
 *
 * @property int $id
 * @property int|null $nomor
 * @property string $inisial
 * @property string $periode
 * @property int|null $min_price
 * @property int|null $max_price

 */
class OfferNumber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_offer_number';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor','min_price','max_price'], 'integer'],
            [['inisial','periode'], 'required'],
            [['inisial','periode'], 'string', 'max' => 100],
            [['nomor'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomor' => 'Nomor',
            'inisial' => 'Inisial',
            'periode' => 'Periode',
            'min_price' => 'Harga Minimal',
            'max_price' => 'Harga Maksimal',
        ];
    }
}
