<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pelamar;

/**
 * PelamarSearch represents the model behind the search form of `app\models\Pelamar`.
 */
class PelamarSearch extends Pelamar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'posisi'], 'integer'],
            [['nama', 'email', 'no_hp', 'alamat', 'gender', 'agama', 'tempat_lahir', 'tanggal_lahir', 'pendidikan', 'status_nikah', 'status'], 'safe'],
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
        $query = Pelamar::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'posisi' => $this->posisi,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'agama', $this->agama])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
            ->andFilterWhere(['like', 'pendidikan', $this->pendidikan])
            ->andFilterWhere(['like', 'status_nikah', $this->status_nikah])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
