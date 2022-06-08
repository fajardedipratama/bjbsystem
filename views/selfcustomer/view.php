<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Dailyreport;
use app\models\Offer;
use app\models\Karyawan;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->perusahaan;

$progress = Dailyreport::find()->where(['perusahaan'=>$model->id])->orderBy(['waktu'=>SORT_DESC])->limit(15)->all();
$offers = Offer::find()->where(['perusahaan'=>$model->id])->orderBy(['id'=>SORT_DESC])->limit(15)->all();

$akhir_tenggang = date('Y-m-d', strtotime('+3 days', strtotime($model->expired_pusat)));
$awal_tenggang = date('Y-m-d', strtotime('+1 days', strtotime($model->expired_pusat)));

\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">
    <div class="row">
        <div class="col-sm-9">
            <h2>
              <?php if($model->verified === 'yes'): ?>
                <i class="fa fa-fw fa-check-circle" title="Terverifikasi"></i>
              <?php elseif($model->verified === 'no'): ?>
                <i class="fa fa-fw fa-times-circle" title="Ditolak Pusat"></i>
              <?php elseif($model->verified === 'black'): ?>
                <i class="fa fa-fw fa-ban" title="Blacklist"></i>
              <?php else: ?>
                <i class="fa fa-fw fa-hourglass-2"></i>
              <?php endif; ?>
              <b><?= Html::encode($this->title) ?></b>
            </h2>
          <?php if(strtotime($model->expired) >= strtotime(date('Y-m-d'))): ?>
            <h5><?= $model->city->kota ?> - Exp.<?= date('d/m/Y',strtotime($model->expired))?></h5>
          <?php else: ?>
            <h5><?= $model->city->kota ?> - Exp. - </h5>
          <?php endif; ?>
          Exp Pusat : <?php if($model->expired_pusat!=NULL){
            echo date('d-m-Y', strtotime($model->expired_pusat));
          } ?>, Pending Pusat : <?php if($model->expired_pending!=NULL && $model->expired_pending>=date('Y-m-d')){
            echo date('d-m-Y', strtotime($model->expired_pending));
          } ?>  
        </div>
        <div class="col-sm-3">
            <p>

              <?php if(strtotime($model->expired) >= strtotime(date('Y-m-d')) || $model->expired == NULL): ?>
                <?= Html::a('<i class="fa fa-fw fa-pencil"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
              <?php endif; ?>

              <?php if($model->verified !== 'no' && $model->verified !== 'black' && !$model->entrusted): ?>
                <?php if($model->expired >= date('Y-m-d') || $model->expired == NULL): ?>
                  <?php if(date('Y-m-d') < $awal_tenggang || date('Y-m-d') > $akhir_tenggang || $model->expired_pusat == NULL): ?>
                    <?php if(date('Y-m-d') > $model->expired_pending || $model->expired_pending == NULL): ?>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#daily-report"><i class="fa fa-fw fa-plus-square"></i> Progress</button>
                    <?php endif ?>
                  <?php elseif(date('Y-m-d') >= $awal_tenggang && date('Y-m-d') <= $akhir_tenggang): ?>
                     <button class="btn btn-danger disabled"><i class="fa fa-fw fa-plus-square"></i> Progress</button>
                  <?php endif; ?>
                <?php endif; ?>
              <?php else: ?>
                <button class="btn btn-danger disabled"><i class="fa fa-fw fa-plus-square"></i> Progress</button>
              <?php endif; ?>

            </p>
        </div>
    </div>

    <section class="content">
      <div class="nav-tabs-custom tab-success">
        <ul class="nav nav-tabs">
          <li><a href="#info" data-toggle="tab">Info</a></li>
          <li class="active"><a href="#progress" data-toggle="tab">Progress</a></li>
          <li><a href="#offers" data-toggle="tab">Penawaran</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane" id="info">
                <div class="table-responsive">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'perusahaan',
                        [
                          'attribute'=>'lokasi',
                          'value'=>function($data){
                            return $data->city->kota;
                          },
                        ],
                        'alamat_lengkap',
                        'pic',
                        'telfon',
                        'email:email',
                        'catatan',
                        [
                          'attribute'=>'sales',
                          'value'=>($model->karyawan)?$model->karyawan->nama:'-',
                        ]
                    ],
                ]) ?>
                </div>
            </div>
            <div class="active tab-pane" id="progress">
              <small style="color: red">*Perubahan data progress harap lapor ke IT</small>
              <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Waktu</th>
                  <th>Sales</th>
                  <th>Keterangan</th>
                  <th>Catatan</th>
                  <th>Hub.Balik</th>
                  <th>By</th>
                </tr>
            <?php foreach($progress as $daily): ?>
            <?php $sales=Karyawan::find()->where(['id'=>$daily['sales']])->one(); ?>
                <tr>
                  <td><?= date("d/m/y H:i",strtotime($daily['waktu'])); ?></td>
                  <td><?= $sales['nama_pendek']; ?></td>
                  <td><?= $daily['keterangan']; ?></td>
                  <td><?= $daily['catatan']; ?></td>
                  <td>
                    <?php if($daily['pengingat']!=NULL): ?>
                      <?= date("d/m/Y",strtotime($daily['pengingat'])); ?>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($daily['con_used']==='Telfon Kantor'): ?>
                      <i class="fa fa-fw fa-phone" title="Telfon Kantor"></i>
                    <?php elseif($daily['con_used']==='Telfon Pribadi'): ?>
                      <i class="fa fa-fw fa-whatsapp" title="Telfon Pribadi"></i> 
                    <?php endif; ?>
                  </td>
                </tr>
            <?php endforeach ?>
               </table>
               </div>
            </div>
            <div class="tab-pane" id="offers">
              <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Waktu</th>
                  <th>No.Surat</th>
                  <th>PIC</th>
                  <th>TOP</th>
                  <th>Harga</th>
                  <th>Sales</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
            <?php foreach($offers as $tawar): ?>
            <?php $sales=Karyawan::find()->where(['id'=>$tawar['sales']])->one(); ?>
                <tr>
                  <td><?= date("d/m/Y",strtotime($tawar['tanggal'])); ?></td>
                  <td><?= $tawar['no_surat']; ?></td>
                  <td><?= $tawar['pic']; ?></td>
                  <td><?= $tawar['top']; ?></td>
                  <td><?= $tawar['harga']; ?></td>
                  <td><?= $sales['nama_pendek']; ?></td>
                  <td><?= $tawar['status']; ?></td>
                  <td>
                    <a href="index.php?r=offer/view&id=<?= $tawar['id'] ?>" target="_blank"><i class="fa fa-fw fa-eye"></i></a>
                  </td>
                </tr>

            <?php endforeach ?>
               </table>
               </div>
            </div>

        </div>
      </div>
    </section>

    <div class="modal fade" id="daily-report"><div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Progress Perusahaan</b></h4>          
            </div>
            <div class="modal-body">
              <?= $this->render('_formprogress', ['model' => $model,'modelprogress' => $modelprogress]) ?>
            </div>
        </div>
    </div></div>

</div>
