<?php
use app\models\AttendanceData;
use app\models\Holiday;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Karyawan */


$this->title = 'Detail '.$model->nama;

\yii\web\YiiAsset::register($this);
?>
<div class="karyawan-view">

    <div class="row">
        <div class="col-sm-9">
          <h1>Detail <strong><i>#<?= $model->nama_pendek ?></i></strong></h1>
        </div>
        <div class="col-sm-3">
          <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
          <p>
            <?= Html::a('<i class="fa fa-fw fa-th-list"></i> Data', ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-fw fa-pencil"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
          </p>
          <?php endif ?>  
        </div>
    </div>

    <section class="content">
    <div class="row">

        <div class="col-md-4">
          <div class="box box-success">
            <div class="box-body box-profile">
              <?php if(!$model->foto_karyawan): ?>
                <img class="profile-user-img img-responsive" src="photos/user-profile-default.png ?>" alt="User profile picture">
              <?php else: ?>
              <img class="profile-user-img img-responsive" src="photos/employee/<?= $model->foto_karyawan ?>" alt="User profile picture">
              <?php endif; ?>

              <h3 class="profile-username text-center"><?= $model->nama; ?></h3>
              <h5 class="text-muted text-center">NIP : <?= $model->badge; ?></h5>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Jenis Kelamin</b> <font class="pull-right"><?= $model->gender ?></font>
                </li>
                <li class="list-group-item">
                  <b>Agama</b> <font class="pull-right"><?= $model->agama ?></font>
                </li>
                <li class="list-group-item">
                  <b>Kelahiran</b> <font class="pull-right"><?= $model->tempat_lahir.', '?>
                  <?php if($model->tanggal_lahir!=null): ?>
                    <?= date('d/m/Y',strtotime($model->tanggal_lahir)) ?>
                  <?php endif; ?>
                  </font>
                </li>
                <li class="list-group-item">
                  <b>No.Telp</b> <font class="pull-right"><?= $model->no_hp ?></font>
                </li>
                <li class="list-group-item">
                  <b>Alamat Rumah</b><br><font><?= $model->alamat_rumah ?></font>
                </li>
              </ul>

            </div>
          </div>
        </div>

  <div class="col-md-8">
      <div class="nav-tabs-custom tab-success">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#detail" data-toggle="tab">Detail</a></li>
            <!-- <li><a href="#absensi" data-toggle="tab">Absensi</a></li> -->
        </ul>

        <div class="tab-content">
          <div class="active tab-pane" id="detail">
            <ul class="list-group">
              <li class="list-group-item">
                <b>Status</b> <font class="pull-right"><?= $model->status_aktif ?></font>
              </li>
              <li class="list-group-item">
                <b>Posisi</b> <font class="pull-right"><?= $model->jobtitle->posisi ?></font>
              </li>
              <li class="list-group-item">
                <b>Departemen</b> <font class="pull-right"><?= $model->departement->departemen ?></font>
              </li>
              <li class="list-group-item">
                <b>Tanggal Masuk</b> <font class="pull-right">
                  <?php if($model->tanggal_masuk!=null): ?>
                    <?= date('d/m/Y',strtotime($model->tanggal_masuk)) ?>
                  <?php endif; ?>
                </font>
              </li>
            </ul>
            <ul class="list-group">
              <li class="list-group-item">
                <b>Pendidikan</b> <font class="pull-right"><?= $model->pendidikan ?></font>
              </li>
              <li class="list-group-item">
                <b>Status Nikah</b> <font class="pull-right"><?= $model->status_kawin ?></font>
              </li>
            </ul>
            <ul class="list-group">
              <li class="list-group-item">
                <b>No. KTP</b> <font class="pull-right"><?= $model->no_ktp ?></font>
              </li>
              <li class="list-group-item">
                <b>Alamat KTP</b> <font class="pull-right"><?= $model->alamat_ktp ?></font>
              </li>
            </ul>
            <ul class="list-group">
              <li class="list-group-item">
                <b>Rekening</b> <font class="pull-right"><?= $model->no_rekening.' ('.$model->bank.'. '.$model->nama_rekening.')' ?></font>
              </li>
            </ul>
          </div>

          <!-- <div class="tab-pane" id="absensi">
            <div class="table-responsive"><table class="table table-bordered">
              <tr>
                <th width="20%">Tanggal</th>
                <th width="20%">Absensi</th>
                <th width="60%">Catatan</th>
              </tr>
          php 
            $begin = date('Y-m-d',strtotime($period->awal_cutoff));
            $end = date('Y-m-d',strtotime($period->akhir_cutoff));
            while (strtotime($begin) <= strtotime($end)) : 
          ?>
              <tr>
                <td>php echo date('d/m/Y',strtotime($begin)) ?></td>
          php 
            $absen=AttendanceData::find()->where(['karyawan_id'=>$model->id])->andWhere(['work_date'=>$begin])->one();
            $holiday=Holiday::find()->where(['tanggal'=>$begin])->one();
          ?>
                <td style="background-color:
                  php 
                    if(date('l',strtotime($begin)) == 'Sunday'){
                        echo 'red';
                    }elseif ($holiday) {
                        echo 'red';
                    } 
                  ?>;">
                  php if($absen): ?>
                    php echo date('H:i',strtotime($absen->real_in)).' - '.date('H:i',strtotime($absen->real_out)) ?>
                  php endif; ?>
                </td>
              </tr>
          php
            $begin = date ("Y-m-d", strtotime("+1 days", strtotime($begin))); 
            endwhile; 
          ?>
            </table></div>
          </div> -->

        </div>
      </div>
  </div>

    </div>
    </section>

</div>
