<?php
use app\models\Offer;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Karyawan;
/* @var $this yii\web\View */
/* @var $model app\models\Karyawan */

$this->title = 'Statistik Harian';
\yii\web\YiiAsset::register($this);

$query = Karyawan::find()->where(['posisi'=>6,'status_aktif'=>'Aktif'])->orderBy(['nama_pendek'=>SORT_ASC])->all();

?>
<div class="karyawan-view">

    <div class="row">
        <div class="col-sm-8">
            <h1><?= Html::encode($this->title) ?></h1>
            <h5><i>Tanggal : <?= date('d-m-Y',strtotime($_GET['time'])); ?></i></h5>
        </div>
        <div class="col-sm-4">
            <?= Html::a('<i class="fa fa-fw fa-calendar"></i> Statistik Total', ['index'], ['class' => 'btn btn-success']) ?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#searchglobal"><i class="fa fa-fw fa-search"></i> Cari</button>
            <?= Html::a('<i class="fa fa-fw fa-calendar"></i> Today', ['today','time'=>date('Y-m-d')], ['class'=>'btn btn-warning']); ?>
        </div>
    </div>

    <br>
    <div class="box"><div class="box-body"><div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Penawaran Baru</th>
            <th>Penawaran Follow Up</th>
            <th>Penawaran Gagal</th>
            <th>Total Terkirim</th>
        </tr>
    <?php foreach($query as $print): ?>
    <?php 
    	$new = Offer::find()->where(['tanggal'=>$_GET['time'],'status'=>'Terkirim'])->andWhere(['like','is_new','yes'])->andWhere(['sales'=>$print['id']])->count(); 
    	$fup = Offer::find()->where(['tanggal'=>$_GET['time'],'status'=>'Terkirim'])->andWhere(['like','is_new','no'])->andWhere(['sales'=>$print['id']])->count();
    	$fail = Offer::find()->where(['tanggal'=>$_GET['time'],'status'=>'Gagal Kirim'])->andWhere(['sales'=>$print['id']])->count(); 
    ?>
        <tr>
            <td><?= $print['nama_pendek']; ?></td>
            <td><?= $new; ?></td>
            <td><?= $fup ?></td>
            <td><?= $fail ?></td>
            <td><?= $new+$fup ?></td>
        </tr>
    <?php endforeach ?>
    </table>
    </div></div></div>

<!-- modal -->
    <div class="modal fade" id="searchglobal">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><b>Pencarian Tanggal</b></h4>          
        </div>
        <div class="modal-body">
            <?= $this->render('_searchform', ['model' => $model]) ?>
        </div>
    </div>
    </div>
    </div>
<!-- modal -->

</div>