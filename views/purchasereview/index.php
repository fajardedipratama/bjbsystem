<?php
use app\models\PurchaseOrder;
use app\models\PurchaseReview;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PurchasereviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Review PO';
?>
<div class="purchase-review-index">

    <h1>
        <?= Html::a('<i class="glyphicon glyphicon-chevron-left"></i>', ['/purchaseorder'], ['class' => 'btn btn-success']) ?>
        <?= Html::encode($this->title) ?>
    </h1>

<div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'perusahaan',
            [
                'header'=>'Estimasi PO',
                'value'=>function($model){
                    $review = PurchaseReview::find()->where(['perusahaan_id'=>$model->id])->one();
                    if($review){
                        $purchase = PurchaseOrder::find()->where(['perusahaan'=>$model->id])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->orderBy(['tgl_kirim'=>SORT_DESC])->one();
                        return date('d/m/Y', strtotime('+'.$review->jarak_ambil.' days', strtotime($purchase->tgl_kirim)));
                    }
                }
            ],
            [
                'attribute'=>'sales',
                'value'=>function($data){
                    if($data->sales === 2){
                        return '-';
                    }else{
                        return $data->karyawan->nama_pendek;
                    }
                }
            ],
            [
                'header'=>'Aksi','class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
            ],
        ],
    ]); ?>
</div></div></div>

</div>
