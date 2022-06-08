<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_dashboard".
 *
 * @property int $id
 * @property int|null $user
 */
class Dashboard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_dashboard';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
        ];
    }
}
