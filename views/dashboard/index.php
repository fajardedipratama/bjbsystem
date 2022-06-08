<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Customer;
use app\models\Offer;
use app\models\PurchaseOrder;
use dosamigos\chartjs\ChartJs;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$all_customer = Customer::find()->count();
$active_customer = Customer::find()->where(['>=','expired',date('Y-m-d')])->count();
$offer = Offer::find()->where(['status'=>'Terkirim'])->count();
$all_po = PurchaseOrder::find()->where(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');

$this->title = 'Dashboard';
?>
<div class="dashboard-index">

    <h2><?= Html::encode($this->title) ?></h2>

<section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-institution"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Perusahaan</span><span class="info-box-number"><?= $all_customer ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-check-square-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Perusahaan Aktif</span>
              <span class="info-box-number"><?= $active_customer ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-paste"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Penawaran Terkirim</span>
              <span class="info-box-number"><?= $offer ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-truck"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Purchase Order</span>
              <span class="info-box-number"><?= Yii::$app->formatter->asDecimal(($all_po/1000),0) ?> KL</span>
            </div>
          </div>
        </div>
      </div>

<?php if(Yii::$app->user->identity->type != 'Administrator'): ?>
  <div class="box bg-green"><div class="box-body">
      <h4 style="text-align:center;font-weight: bold;" class="text-white">
        <br><br>
        <i style="font-size:24px">2022<br> WANI !!!</i>
      </h4><br>
      <h5 style="text-align:center;font-weight: bold;" class="text-white"><i>- NaVi Team -</i></h5>
  </div></div>
<?php else: ?>
  <div class="box box-success"><div class="box-body">
  <table class="table table-hover table-bordered">
    <tr>
      <th>Perusahaan</th>
      <th>Estimasi Pengambilan</th>
      <th>Sales</th>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </table>
  </div></div>
<?php endif ?>

  <div class="box box-success"><div class="box-body">
    <?php 
      $jan = PurchaseOrder::find()->where(['between','tgl_kirim','2021-12-28','2022-01-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $feb = PurchaseOrder::find()->where(['between','tgl_kirim','2022-01-28','2022-02-25'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $mar = PurchaseOrder::find()->where(['between','tgl_kirim','2022-02-26','2022-03-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $apr = PurchaseOrder::find()->where(['between','tgl_kirim','2022-03-28','2022-04-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $may = PurchaseOrder::find()->where(['between','tgl_kirim','2022-04-28','2022-05-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $jun = PurchaseOrder::find()->where(['between','tgl_kirim','2022-05-28','2022-06-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $jul = PurchaseOrder::find()->where(['between','tgl_kirim','2022-06-28','2022-07-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $aug = PurchaseOrder::find()->where(['between','tgl_kirim','2022-07-28','2022-08-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $sep = PurchaseOrder::find()->where(['between','tgl_kirim','2022-08-28','2022-09-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $oct = PurchaseOrder::find()->where(['between','tgl_kirim','2022-09-28','2022-10-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $nov = PurchaseOrder::find()->where(['between','tgl_kirim','2022-10-28','2022-11-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
      $dec = PurchaseOrder::find()->where(['between','tgl_kirim','2022-11-28','2022-12-27'])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->sum('volume');
    ?>
    <?= ChartJs::widget([
        'type' => 'line',
        'options' => [
            'height' => 130,
            'width' => 400
        ],
        'data' => [
            'labels' => ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec"],
            'datasets' => [
                [
                    'label' => "Purchase Order",
                    'backgroundColor' => "rgba(73, 173, 79, 0.2)",
                    'borderColor' => "rgb(73, 173, 79)",
                    'pointBackgroundColor' => "rgb(73, 173, 79)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'data' => [$jan/1000,$feb/1000,$mar/1000,$apr/1000,$may/1000,$jun/1000,$jul/1000,$aug/1000,$sep/1000,$oct/1000,$nov/1000,$dec/1000]
                ],
            ]
        ]
    ]);
    ?>
  </div></div>

</section>

</div>
