<?php

namespace app\models\search;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Offer;

/**
 * OfferSearch represents the model behind the search form of `app\models\Offer`.
 */
class OfferprosesSearch extends Offer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'no_surat', 'perusahaan', 'harga', 'sales'], 'integer'],
            [['tanggal','waktu', 'pic', 'top', 'pajak', 'catatan', 'status'], 'safe'],
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
        if(Yii::$app->user->identity->type == 'Marketing'){
            $query = Offer::find()->where(['status'=>'Proses'])->andWhere(['sales'=>Yii::$app->user->identity->profilname]);
        }else{
            $query = Offer::find()->where(['status'=>'Proses']);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array('pageSize'=>30),
            'sort'=>['defaultOrder'=>['no_surat'=>SORT_ASC]]
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
            'waktu' => $this->waktu,
            'no_surat' => $this->no_surat,
            'perusahaan' => $this->perusahaan,
            'harga' => $this->harga,
            'sales' => $this->sales,
        ]);
        if(!empty($this->tanggal)){    
            $query->andFilterWhere([
                'tanggal' => Yii::$app->formatter->asDate($this->tanggal,'yyyy-MM-dd'),
            ]);
        }

        $query->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'top', $this->top])
            ->andFilterWhere(['like', 'pajak', $this->pajak])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
