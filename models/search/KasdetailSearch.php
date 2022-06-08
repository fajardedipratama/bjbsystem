<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KasDetail;

/**
 * KasdetailSearch represents the model behind the search form of `app\models\KasDetail`.
 */
class KasdetailSearch extends KasDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kas_id', 'nominal', 'titip', 'saldo_akhir'], 'integer'],
            [['tgl_kas', 'deskripsi', 'jenis'], 'safe'],
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
        $query = KasDetail::find();

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
            'kas_id' => $this->kas_id,
            'tgl_kas' => $this->tgl_kas,
            'nominal' => $this->nominal,
            'titip' => $this->titip,
            'saldo_akhir' => $this->saldo_akhir,
        ]);

        $query->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'jenis', $this->jenis]);

        return $dataProvider;
    }
}
