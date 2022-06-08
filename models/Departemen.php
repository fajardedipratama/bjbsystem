<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_departemen".
 *
 * @property int $id
 * @property string $departemen
 */
class Departemen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_departemen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departemen'], 'required'],
            [['departemen'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departemen' => 'Departemen',
        ];
    }
}
