<?php

namespace app\models\search;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * ExpiredSearch represents the model behind the search form of `app\models\Customer`.
 */
class ExpiredSearch extends Customer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sales', 'created_by'], 'integer'],
            [['perusahaan', 'lokasi', 'alamat_lengkap', 'pic', 'telfon', 'email', 'catatan', 'expired', 'long_expired', 'created_time', 'verified'], 'safe'],
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
            $query = Customer::find()->where(['<','expired',date('Y-m-d')])->andWhere(['sales'=>Yii::$app->user->identity->profilname]);
        }else{
            $query = Customer::find()->where(['<','expired',date('Y-m-d')]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array('pageSize'=>20),
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
            'sales' => $this->sales,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
        ]);

        if(!empty($this->expired)){    
            $query->andFilterWhere([
                'expired' => Yii::$app->formatter->asDate($this->expired,'yyyy-MM-dd'),
            ]);
        }

        $query->andFilterWhere(['like', 'perusahaan', $this->perusahaan])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'alamat_lengkap', $this->alamat_lengkap])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'telfon', $this->telfon])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'long_expired', $this->long_expired])
            ->andFilterWhere(['like', 'verified', $this->verified]);

        return $dataProvider;
    }
}
