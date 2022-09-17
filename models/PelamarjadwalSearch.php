<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PelamarJadwal;

/**
 * PelamarjadwalSearch represents the model behind the search form of `app\models\PelamarJadwal`.
 */
class PelamarjadwalSearch extends PelamarJadwal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_pelamar'], 'integer'],
            [['tanggal', 'jenis', 'kehadiran'], 'safe'],
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
        $query = PelamarJadwal::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['tanggal'=>SORT_DESC]]
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
            'id_pelamar' => $this->id_pelamar,
        ]);
        if(!empty($this->tanggal)){    
            $query->andFilterWhere([
                'tanggal' => Yii::$app->formatter->asDate($this->tanggal,'yyyy-MM-dd'),
            ]);
        }

        $query->andFilterWhere(['like', 'jenis', $this->jenis])
            ->andFilterWhere(['like', 'kehadiran', $this->kehadiran]);

        return $dataProvider;
    }
}
