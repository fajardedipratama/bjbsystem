<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_broker".
 *
 * @property int $id
 * @property string $nama
 * @property string $no_hp
 */
class Broker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_broker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama', 'no_hp'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'no_hp' => 'No.HP',
        ];
    }
}
