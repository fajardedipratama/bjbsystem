<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_kas".
 *
 * @property int $id
 * @property int|null $bulan
 * @property int|null $tahun
 * @property int|null $saldo
 */
class Kas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_kas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bulan', 'tahun', 'saldo'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'saldo' => 'Saldo Akhir',
        ];
    }
}
