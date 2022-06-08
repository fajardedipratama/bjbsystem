<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_kas_detail".
 *
 * @property int $id
 * @property int $kas_id
 * @property string|null $tgl_kas
 * @property string $deskripsi
 * @property string $jenis
 * @property int|null $nominal
 * @property int|null $titip
 * @property int $saldo_akhir
 */
class KasDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_kas_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kas_id', 'nominal', 'titip', 'saldo_akhir'], 'integer'],
            [['tgl_kas'], 'safe'],
            [['deskripsi'], 'string', 'max' => 1000],
            [['jenis'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kas_id' => 'Kas ID',
            'tgl_kas' => 'Tanggal',
            'deskripsi' => 'Deskripsi',
            'jenis' => 'Jenis',
            'nominal' => 'Nominal',
            'titip' => 'Titip',
            'saldo_akhir' => 'Saldo',
        ];
    }
}
