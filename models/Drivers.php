<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_drivers".
 *
 * @property int $id
 * @property string $driver
 * @property string $no_hp
 */
class Drivers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_drivers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver', 'no_hp'], 'required'],
            [['driver', 'no_hp'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'driver' => 'Driver',
            'no_hp' => 'No HP',
        ];
    }
}
