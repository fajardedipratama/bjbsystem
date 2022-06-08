<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Karyawan;

/**
 * KaryawanSearch represents the model behind the search form of `app\models\Karyawan`.
 */
class KaryawanSearch extends Karyawan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'posisi', 'departemen'], 'integer'],
            [['badge', 'nama', 'gender', 'tempat_lahir', 'tanggal_lahir', 'no_hp', 'no_ktp', 'alamat_ktp', 'alamat_rumah', 'pendidikan', 'status_kawin', 'tanggal_masuk', 'bank', 'no_rekening', 'nama_rekening', 'foto_karyawan', 'status_aktif'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Karyawan::find()->where(['status_aktif'=>'Aktif']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array('pageSize'=>20),
            'sort'=>['defaultOrder'=>['badge'=>SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal_lahir' => $this->tanggal_lahir,
            'tanggal_masuk' => $this->tanggal_masuk,
            'posisi' => $this->posisi,
            'departemen' => $this->departemen,
        ]);

        $query->andFilterWhere(['like', 'badge', $this->badge])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'no_ktp', $this->no_ktp])
            ->andFilterWhere(['like', 'alamat_ktp', $this->alamat_ktp])
            ->andFilterWhere(['like', 'alamat_rumah', $this->alamat_rumah])
            ->andFilterWhere(['like', 'pendidikan', $this->pendidikan])
            ->andFilterWhere(['like', 'status_kawin', $this->status_kawin])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'no_rekening', $this->no_rekening])
            ->andFilterWhere(['like', 'nama_rekening', $this->nama_rekening])
            ->andFilterWhere(['like', 'foto_karyawan', $this->foto_karyawan])
            ->andFilterWhere(['like', 'status_aktif', $this->status_aktif]);

        return $dataProvider;
    }
}
