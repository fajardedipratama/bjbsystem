<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "id_city".
 *
 * @property int $id
 * @property string $kota
 * @property string $provinsi
 * @property int $oat
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'id_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kota', 'provinsi', 'oat'], 'required'],
            [['oat'], 'integer'],
            [['kota', 'provinsi'], 'string', 'max' => 100],
            [['kota'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kota' => 'Kota',
            'provinsi' => 'Provinsi',
            'oat' => 'OAT',
        ];
    }
    public function beforeSave($options = array()) {
        $this->kota = strtoupper($this->kota);

        return true;
    }
    public function beforeDelete($options = array()) {
        $result=Customer::find()->where(['lokasi'=>$this->id])->count();
        if($result==0){
            return true;
        }else{
            return Yii::$app->session->setFlash('danger', 'Data Tidak Dapat Dihapus !!!');
        }
    }
}
