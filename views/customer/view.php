<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Dailyreport;
use app\models\Offer;
use app\models\Karyawan;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->perusahaan;

$progress = Dailyreport::find()->where(['perusahaan'=>$model->id])->orderBy(['waktu'=>SORT_DESC])->limit(15)->all();

$count_offer = Offer::find()->where(['perusahaan'=>$model->id])->count();
$offers = Offer::find()->where(['perusahaan'=>$model->id])->orderBy(['id'=>SORT_DESC])->limit(15)->all();
$first_offer = Offer::find()->where(['perusahaan'=>$model->id])->orderBy(['id'=>SORT_ASC])->one();

$akhir_tenggang = date('Y-m-d', strtotime('+3 days', strtotime($model->expired_pusat)));
$awal_tenggang = date('Y-m-d', strtotime('+1 days', strtotime($model->expired_pusat)));

\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">
    <div class="row">
        <div class="col-sm-7">
            <h2>
              <?php if($model->verified === 'yes'): ?>
                <?php if(!$model->entrusted): ?>
                    <i class="fa fa-fw fa-check-circle" title="Terverifikasi"></i>
                <?php else: ?>
                    <i class="fa fa-fw fa-check-circle" title="Terverifikasi"></i><i class="fa fa-fw  fa-user-secret" title="Titipan"></i>
                <?php endif; ?>
              <?php elseif($model->verified === 'no'): ?>
                <?php if(!$model->entrusted): ?>
                    <i class="fa fa-fw fa-times-circle" title="Ditolak Pusat"></i>
                <?php else: ?>
                    <i class="fa fa-fw fa-times-circle" title="Ditolak Pusat"></i><i class="fa fa-fw  fa-user-secret" title="Titipan"></i>
                <?php endif; ?>
              <?php elseif($model->verified === 'black'): ?>
                <?php if(!$model->entrusted): ?>
                    <i class="fa fa-fw fa-ban" title="Blacklist"></i>
                <?php else: ?>
                    <i class="fa fa-fw fa-ban" title="Blacklist"></i><i class="fa fa-fw  fa-user-secret" title="Titipan"></i>
                <?php endif; ?>
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
        <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
        <div class="col-sm-5">
            <p>
                <?= Html::a('<i class="fa fa-fw fa-pencil"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-success','title'=>'Update']) ?>
                <?= Html::a('<i class="fa fa-fw fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger','title'=>'Delete',
                    'data' => [
                        'confirm' => 'Hapus data ini ?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('<i class="fa fa-fw fa-refresh"></i> Gabung', ['merge', 'id' => $model->id], ['class' => 'btn btn-primary','target'=>'_blank','title'=>'Gabung']) ?>
            <?php if($model->long_expired != 'yes'): ?>
                <button class="btn btn-warning" title="Perpanjang" data-toggle="modal" data-target="#extra-expired"><i class="fa fa-fw fa-plus"></i> Expired</button>
            <?php endif ?>
            </p>
        </div>
        <?php endif ?>
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
                'long_expired',
                [
                  'attribute'=>'sales',
                  'value'=>($model->karyawan)?$model->karyawan->nama:'-',
                ],
                [
                  'attribute'=>'created_by',
                  'value'=>($model->karyawan)?$model->createdby->nama:'-',
                ],
                [
                    'attribute'=>'created_time',
                    'value'=>date('d-M-Y H:i',strtotime($model->created_time)),
                ]
            ],
        ]) ?>
        </div>
    </div>
    <div class="active tab-pane" id="progress">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
            <tr>
                <th>Waktu</th>
                <th>Sales</th>
                <th>Keterangan</th>
                <th>Catatan</th>
                <th>Hub.Balik</th>
                <th>By</th>
                <th>Del.</th>
            </tr>
        <?php foreach($progress as $daily): ?>
        <?php $sales=Karyawan::find()->where(['id'=>$daily['sales']])->one(); ?>
            <tr>
                <td><?= date("d/m/Y",strtotime($daily['waktu'])); ?></td>
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
                    <?php elseif($daily['con_used']==='WA Pribadi'): ?>
                      <i class="fa fa-fw fa-whatsapp" title="Telfon Pribadi"></i> 
                    <?php endif; ?>
                </td>
                <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
                <td>
                    <?= Html::a('<i class="fa fa-fw fa-trash"></i>', ['/dailyreport/delete2', 'id' => $daily->id], [
                        'data' => [
                            'confirm' => 'Hapus data ini ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
                <?php endif ?>
            </tr>
        <?php endforeach ?>
            </table>
        </div>
    </div>
    <div class="tab-pane" id="offers">
        <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
        <?php if($count_offer > 0): ?>
            <p style="font-style: italic;">Penawaran Pertama : <?= date("d/m/Y",strtotime($first_offer['tanggal'])).' - No.'.$first_offer['no_surat'] ?></p>
        <?php endif; ?>
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

    <div class="modal fade" id="extra-expired"><div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Perpanjang Expired</b></h4>          
            </div>
            <div class="modal-body">
            <?php $form = ActiveForm::begin(); ?>
                <?php 
                    if(!$model->isNewRecord || $model->isNewRecord){
                        if($model->expired!=null){
                            $model->expired=date('d-m-Y',strtotime($model->expired));
                        }
                    }
                ?>
                <?= $form->field($model, 'expired')->widget(DatePicker::className(),[
                    'clientOptions'=>[
                        'autoclose'=>true,
                        'format'=>'dd-mm-yyyy',
                        'orientation'=>'bottom',
                    ]
                ])?>
                <div class="form-group">
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div></div>

</div>
