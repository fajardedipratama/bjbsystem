<?php

namespace app\models\search;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SendSample;

/**
 * SendsampleSearch represents the model behind the search form of `app\models\SendSample`.
 */
class SendsampleSearch extends SendSample
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perusahaan', 'sales', 'jumlah'], 'integer'],
            [['penerima', 'alamat', 'tgl_kirim', 'catatan', 'status', 'created_time'], 'safe'],
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
            $query = SendSample::find()->where(['sales'=>Yii::$app->user->identity->profilname]);
        }else{
            $query = SendSample::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['id'=>SORT_DESC]]
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
            'perusahaan' => $this->perusahaan,
            'sales' => $this->sales,
            'jumlah' => $this->jumlah,
        ]);
        if(!empty($this->tgl_kirim)){    
            $query->andFilterWhere([
                'tgl_kirim' => Yii::$app->formatter->asDate($this->tgl_kirim,'yyyy-MM-dd'),
            ]);
        }
        if(!empty($this->created_time)){    
            $query->andFilterWhere([
                'created_time' => Yii::$app->formatter->asDate($this->created_time,'yyyy-MM-dd'),
            ]);
        }

        $query->andFilterWhere(['like', 'penerima', $this->penerima])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
