<?php

namespace app\models\search;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PurchaseOrder;

/**
 * PurchaseorderSearch represents the model behind the search form of `app\models\PurchaseOrder`.
 */
class PurchaseorderSearch extends PurchaseOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perusahaan', 'sales','volume', 'harga', 'cashback', 'bilyet_giro','kota_kirim'], 'integer'],
            [['no_po', 'broker','tgl_po', 'tgl_kirim', 'alamat', 'alamat_kirim', 'purchasing', 'no_purchasing', 'keuangan', 'no_keuangan', 'termin', 'pajak', 'pembayaran','status', 'catatan', 'alasan_tolak','jatuh_tempo','tgl_lunas'], 'safe'],
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
            $query = PurchaseOrder::find()->where(['sales'=>Yii::$app->user->identity->profilname])->andWhere(['eksternal'=>NULL]);
        }else{
            $query = PurchaseOrder::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array('pageSize'=>30),
            'sort'=>['defaultOrder'=>['tgl_kirim'=>SORT_DESC]]
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
            'volume' => $this->volume,
            'harga' => $this->harga,
            'cashback' => $this->cashback,
            'bilyet_giro' => $this->bilyet_giro,
            'kota_kirim' => $this->kota_kirim,
        ]);
        if(!empty($this->tgl_po)){    
            $query->andFilterWhere([
                'tgl_po' => Yii::$app->formatter->asDate($this->tgl_po,'yyyy-MM-dd'),
            ]);
        }
        if(!empty($this->tgl_kirim)){    
            $query->andFilterWhere([
                'tgl_kirim' => Yii::$app->formatter->asDate($this->tgl_kirim,'yyyy-MM-dd'),
            ]);
        }
        if(!empty($this->jatuh_tempo)){    
            $query->andFilterWhere([
                'jatuh_tempo' => Yii::$app->formatter->asDate($this->jatuh_tempo,'yyyy-MM-dd'),
            ]);
        }

        $query->andFilterWhere(['like', 'no_po', $this->no_po])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'alamat_kirim', $this->alamat_kirim])
            ->andFilterWhere(['like', 'purchasing', $this->purchasing])
            ->andFilterWhere(['like', 'no_purchasing', $this->no_purchasing])
            ->andFilterWhere(['like', 'keuangan', $this->keuangan])
            ->andFilterWhere(['like', 'no_keuangan', $this->no_keuangan])
            ->andFilterWhere(['like', 'termin', $this->termin])
            ->andFilterWhere(['like', 'pajak', $this->pajak])
            ->andFilterWhere(['like', 'pembayaran', $this->pembayaran])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'alasan_tolak', $this->alasan_tolak]);

        return $dataProvider;
    }
}
