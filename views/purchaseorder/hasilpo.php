<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\PurchaseOrder;
use app\models\Karyawan;

if($_GET['range']=='all'){
    $company = PurchaseOrder::find()->select(['perusahaan'])->where(['status'=>['Terkirim','Terbayar-Selesai']])->distinct()->count();
    $kirim = PurchaseOrder::find()->where(['status'=>['Terkirim','Terbayar-Selesai']]);
    $proses = PurchaseOrder::find()->where(['status'=>'Disetujui'])->sum('volume');
    $pending = PurchaseOrder::find()->where(['status'=>'Pending'])->sum('volume');
    $terbayar = PurchaseOrder::find()->where(['status'=>'Terbayar-Selesai'])->sum('volume');
    $po_cod = PurchaseOrder::find()->where(['status'=>['Disetujui','Terkirim','Terbayar-Selesai']])->andWhere(['termin'=>['Cash On Delivery','Cash Before Delivery']])->sum('volume');
}else{
    $data = explode("x", $_GET['range']);
    $set_awal = $data[0];
    $set_akhir = $data[1];

    $company = PurchaseOrder::find()->select(['perusahaan'])->where(['status'=>['Terkirim','Terbayar-Selesai']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->distinct()->count();
    $kirim=PurchaseOrder::find()->where(['status'=>['Terkirim','Terbayar-Selesai']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir]);
    $proses = PurchaseOrder::find()->where(['status'=>'Disetujui'])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->sum('volume');
    $pending = PurchaseOrder::find()->where(['status'=>'Pending'])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->sum('volume');
    $terbayar = PurchaseOrder::find()->where(['status'=>'Terbayar-Selesai'])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->sum('volume');
    $po_cod = PurchaseOrder::find()->where(['status'=>['Disetujui','Terkirim','Terbayar-Selesai']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->andWhere(['termin'=>['Cash On Delivery','Cash Before Delivery']])->sum('volume');
    $po_eksternal = PurchaseOrder::find()->where(['status'=>['Terkirim','Terbayar-Selesai']])->andWhere(['eksternal'=>'yes'])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir]);
}

$karyawan=Karyawan::find()->where(['posisi'=>6])->orderBy(['status_aktif'=>SORT_ASC])->all();

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
$this->title = 'Hasil PO';
\yii\web\YiiAsset::register($this);
?>
<div class="purchase-order-view">
<div class="row">
  <div class="col-sm-10">
    <h1><?= Html::a('<i class="glyphicon glyphicon-chevron-left"></i>', ['index'], ['class' => 'btn btn-success']) ?> <?= Html::encode($this->title) ?></h1>
  <?php if($_GET['range']!='all'): ?>
      <h5><i><?= $set_awal.' / '.$set_akhir ?></i></h5>
  <?php endif; ?>
  </div>
  <div class="col-sm-2">
    <?= Html::a('<i class="glyphicon glyphicon-refresh"></i>', ['hasilpo','range'=>'all'], ['class' => 'btn btn-warning']) ?>
    <button class="btn btn-success" data-toggle="modal" data-target="#search-po"><i class="fa fa-fw fa-search"></i> Cari</button>
  </div>
</div>

<div class="box"><div class="box-body"><div class="table-responsive">
    <table class="table table-bordered">
      <tr>
        <th>PO Terkirim</th>
        <td><?= $kirim->count() ?>x PO dari <?= $company ?> Perusahaan, total <?= $kirim->sum('volume')/1000 ?> KL </td>
     	</tr>
      <tr>
        <th>PO Belum Terkirim</th>
        <td><?= $proses/1000 ?> KL</td>
      </tr>
      <tr>
        <th>PO Pending</th>
        <td><?= $pending/1000 ?> KL</td>
      </tr>
      <tr>
        <th>PO Terbayar</th>
        <td><?= $terbayar/1000 ?> KL</td>
      </tr>
      <tr>
        <th>PO COD/CBD</th>
        <td><?= $po_cod/1000 ?> KL</td>
      </tr>
    </table>
</div></div></div>

<div class="box"><div class="box-body"><div class="table-responsive">
  <?php if($_GET['range']!='all'): ?>
     <?= Html::a('<i class="fa fa-fw fa-file-excel-o"></i> Export Rincian', ['export-excel2','range'=>$_GET['range']], ['class'=>'btn btn-success']); ?>
  <?php endif ?>
    <table class="table table-bordered">
      <tr>
        <th>Sales</th><th>PO Terkirim</th><th>PO Belum Terkirim</th><th>PO Pending</th><th>PO Gagal</th>
      </tr>
    <?php foreach($karyawan as $sales): ?>

      <?php if($_GET['range']=='all'): ?>
        <?php $po_terkirim = PurchaseOrder::find()->where(['status'=>['Terkirim','Terbayar-Selesai']])->andWhere(['sales'=>$sales['id']]); ?>
        <?php $po_belumkirim = PurchaseOrder::find()->where(['status'=>'Disetujui'])->andWhere(['sales'=>$sales['id']])->sum('volume'); ?>
        <?php $po_pending = PurchaseOrder::find()->where(['status'=>'Pending'])->andWhere(['sales'=>$sales['id']])->sum('volume'); ?>
        <?php $po_ditolak = PurchaseOrder::find()->where(['status'=>'Ditolak'])->orWhere(['status'=>'Batal Kirim'])->andWhere(['sales'=>$sales['id']])->sum('volume'); ?>
        <?php $company = PurchaseOrder::find()->select(['perusahaan'])->where(['status'=>'Terkirim'])->orWhere(['status'=>'Terbayar-Selesai'])->andWhere(['sales'=>$sales['id']])->distinct()->count(); ?>
        <?php $po_eksternal = PurchaseOrder::find()->where(['status'=>['Terkirim','Terbayar-Selesai']])->andWhere(['eksternal'=>'yes'])->andWhere(['sales'=>$sales['id']]); ?>
      <?php else: ?>
        <?php $po_terkirim = PurchaseOrder::find()->where(['status'=>['Terkirim','Terbayar-Selesai']])->andWhere(['sales'=>$sales['id']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir]); ?>
        <?php $po_belumkirim = PurchaseOrder::find()->where(['status'=>'Disetujui'])->andWhere(['sales'=>$sales['id']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->sum('volume'); ?>
        <?php $po_pending = PurchaseOrder::find()->where(['status'=>'Pending'])->andWhere(['sales'=>$sales['id']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->sum('volume'); ?>
        <?php $po_ditolak = PurchaseOrder::find()->where(['status'=>'Ditolak'])->orWhere(['status'=>'Batal Kirim'])->andWhere(['sales'=>$sales['id']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->sum('volume'); ?>
        <?php $company = PurchaseOrder::find()->select(['perusahaan'])->where(['status'=>'Terkirim'])->orWhere(['status'=>'Terbayar-Selesai'])->andWhere(['sales'=>$sales['id']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir])->distinct()->count(); ?>
         <?php $po_eksternal = PurchaseOrder::find()->where(['status'=>['Terkirim','Terbayar-Selesai']])->andWhere(['eksternal'=>'yes'])->andWhere(['sales'=>$sales['id']])->andWhere(['between','tgl_kirim',$set_awal,$set_akhir]); ?>
      <?php endif; ?>

      <tr>
        <td>
          <?php if($sales['status_aktif']=='Aktif'){
            echo $sales['nama_pendek']; 
          }else{
            echo '<font style="color:red">'.$sales['nama_pendek'].'</font>';
          }
          ?>
        </td>
        <td>
          <?= $po_terkirim->count().'x PO dari '.$company.' Perusahaan, Total '.($po_terkirim->sum('volume')/1000).' KL'.' (bantuan '.($po_eksternal->sum('volume')/1000).' KL)'; ?>
        </td>
        <td><?= ($po_belumkirim/1000).' KL'; ?></td>
        <td><?= ($po_pending/1000).' KL'; ?></td>
        <td><?= ($po_ditolak/1000).' KL'; ?></td>
      </tr>
    <?php endforeach; ?>
    </table>
</div></div></div>

    <div class="modal fade" id="search-po"><div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Pencarian</b></h4>          
            </div>
            <div class="modal-body">
              <?= $this->render('_formhasilpo', ['model'=>$model]) ?>
            </div>
        </div>
    </div></div>

</div>
