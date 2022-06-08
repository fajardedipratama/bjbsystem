<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_jobtitle".
 *
 * @property int $id
 * @property string $posisi
 */
class Jobtitle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_jobtitle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['posisi'], 'required'],
            [['posisi'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'posisi' => 'Jabatan',
        ];
    }
}
