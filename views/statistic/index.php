<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Karyawan;
use app\models\Offer;
use app\models\Customer;
use app\models\PurchaseOrder;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OfferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Statistik Total';


?>
<div class="offer-index">
    <div class="row">
        <div class="col-sm-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-2">
            <?= Html::a('<i class="fa fa-fw fa-calendar"></i> Statistik Harian', ['today','time'=>date('Y-m-d')], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'header'=>'Nama Sales',
                'value'=>'nama_pendek',
            ],
            [
                'header'=>'Perusahaan Aktif',
                'value'=>function($data){
                    $query = Customer::find()->where(['sales'=>$data['id']])->andWhere(['>=','expired',date('Y-m-d')])->andWhere(['verified'=>'yes'])->count();
                    return $query;
                }
            ],
            [
                'header'=>'Total Penawaran',
                'value'=>function($data){
                    $offer = Offer::find()->where(['sales'=>$data['id']])->count();
                    return $offer;
                }
            ],
            [
                'header'=>'Penawaran Terkirim',
                'value'=>function($data){
                    $success = Offer::find()->where(['sales'=>$data['id']])->andWhere(['status'=>'Terkirim'])->count();
                    return $success;
                }
            ],
            [
                'header'=>'Penawaran Gagal',
                'value'=>function($data){
                    $failed = Offer::find()->where(['sales'=>$data['id']])->andWhere(['status'=>'Gagal Kirim'])->count();
                    return $failed;
                }
            ],
        ],
    ]); ?>
</div></div></div>

</div>
