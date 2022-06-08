<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_testing".
 *
 * @property int $id
 * @property string $data_a
 * @property string $data_b
 */
class Testing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_testing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_a', 'data_b'], 'required'],
            [['data_a', 'data_b'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_a' => 'Data A',
            'data_b' => 'Data B',
        ];
    }
}
