<?php
use app\models\City;
use app\models\Offer;
use app\models\OfferPermit;
use app\models\Karyawan;
use app\models\Customer;
use app\models\OfferNumber;
use app\models\PurchaseOrder;
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OfferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penawaran';

?>
<div class="offer-index">

    <div class="row">
        <div class="col-sm-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-4">
        <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah Data', ['createadmin'], ['class' => 'btn btn-success']) ?>
            <button class="btn btn-warning" data-toggle="modal" data-target="#offer-number"><i class="fa fa-fw fa-sort-numeric-asc"></i> No.Surat</button>
            <?= Html::a('<i class="fa fa-fw fa-file-excel-o"></i> Ekspor', ['export-excel'], ['class' => 'btn btn-danger']) ?>
        <?php endif; ?>
        </div>
    </div>

  <div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'attribute'=>'tanggal',
              'value' => function($data){
                return $data->tanggal.' '.$data->waktu;
              },
              'headerOptions'=>['style'=>'width:15%'],
              'format' => ['date','dd-MM-Y H:i'],
              'filter'=> DatePicker::widget([
                'model'=>$searchModel,'attribute'=>'tanggal','clientOptions'=>[
                  'autoclose'=>true, 'format' => 'dd-mm-yyyy','orientation'=>'bottom'
                ],
              ])
            ],
            [
              'attribute'=>'perusahaan',
              'format'=>'raw',
              'value'=>function($data){
                if($data->customer->verified == 'yes'){
                  if ($data->customer->expired >= date('Y-m-d') || $data->customer->expired == NULL) {
                    $po = PurchaseOrder::find()->where(['perusahaan'=>$data->customer->id])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->orderBy(['id'=>SORT_DESC])->one();
                    if($po){
                      return $data->customer->perusahaan.'<i class="fa fa-fw fa-check"></i><i class="fa fa-fw fa-truck" title="'.$po->tgl_kirim.'"></i> ';
                    }else{
                      return $data->customer->perusahaan.'<i class="fa fa-fw fa-check"></i>';
                    }
                  }elseif($data->customer->expired < date('Y-m-d')){
                    return $data->customer->perusahaan.'<i class="fa fa-fw fa-clock-o"></i>';
                  }
                }elseif($data->customer->verified == NULL){
                  return $data->customer->perusahaan.'<i class="fa fa-fw fa-hourglass-2"></i>';
                }
              },
              'filter'=>\kartik\select2\Select2::widget([
                'model'=>$searchModel,'attribute'=>'perusahaan','data'=>$customer,
                'options'=>['placeholder'=>'Perusahaan'],'pluginOptions'=>['allowClear'=>true]
              ])
            ],
            [
              'header'=>'Lokasi',
              'value'=>function($data){
                $query = City::find()->where(['id'=>$data->customer->lokasi])->one();
                return $query['kota'];
              },
              'visible' => Yii::$app->user->identity->type != 'Administrator'
            ],
            [
              'attribute'=>'sales',
              'value' => 'karyawan.nama_pendek',
              'filter'=>\kartik\select2\Select2::widget([
                'model'=>$searchModel,'attribute'=>'sales','data'=>$sales,
                'options'=>['placeholder'=>'Sales'],'pluginOptions'=>['allowClear'=>true]
              ]),
              'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
            ],
            [
              'header'=>'Expired Pusat',
              'value'=>function($data){
                if($data->customer->expired_pusat != NULL){
                  return date('d/m/Y',strtotime($data->customer->expired_pusat));
                }
              },
              'visible' => Yii::$app->user->identity->type == 'Administrator'
            ],
            [
              'header'=>'Last',
              'value'=>function($data){
                $query = Offer::find()->where(['perusahaan'=>$data->perusahaan])->orderBy(['id'=>SORT_DESC])->offset(1)->one();
                if($query){
                  return date('d/m/Y',strtotime($query['tanggal']));
                }
              },
              'visible' => Yii::$app->user->identity->type == 'Administrator'
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'header'=>'Pengajuan',
              'template'=> '{permit}',
              'buttons'=>
              [
                'permit'=>function($url,$model){
                  $result = OfferPermit::find()->where(['id_customer'=>$model->perusahaan])->one();
                  if($result){
                    return Html::a('Batal', ['cancelpermit','id'=>$model->perusahaan], ['class' => 'btn btn-xs btn-danger']);
                  }else{
                    $cust = Customer::find()->where(['id'=>$model->perusahaan])->one();
                    $akhir_tenggang = date('Y-m-d', strtotime('+3 days', strtotime($cust->expired_pusat)));
                    $awal_tenggang = date('Y-m-d', strtotime('+1 days', strtotime($cust->expired_pusat)));

                    if($cust['expired_pusat'] >= date('Y-m-d')){
                      return Html::a('Ajukan', ['permit','id'=>$model->perusahaan], ['class' => 'btn btn-xs btn-default disabled']);
                    }elseif(date('Y-m-d') >= $awal_tenggang && date('Y-m-d') <= $akhir_tenggang){
                      return Html::a('Pending', ['permit','id'=>$model->perusahaan], ['class' => 'btn btn-xs btn-danger disabled']);
                    }elseif(date('Y-m-d') < $cust->expired_pending){
                      return Html::a('Pending', ['permit','id'=>$model->perusahaan], ['class' => 'btn btn-xs btn-danger disabled']);
                    }else{
                      return Html::a('Ajukan', ['permit','id'=>$model->perusahaan], ['class' => 'btn btn-xs btn-success']);
                    }
                    
                  }
                }
              ],
              'visible' => Yii::$app->user->identity->type == 'Administrator',
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=>['style'=>'width:10%'],
              'header'=>'Verif.',
              'template' => '{accept} {decline} {pending} {duplicate}',
              'buttons'=>
              [
                    'accept'=>function($url,$model)
                    {
                    return Html::a
                     (
                        '<span class="glyphicon glyphicon-ok"></span>',
                        ["offer/accept",'id'=>$model->id],
                        ['title' => Yii::t('app', 'Accept')],
                     );
                    },
                    'decline'=>function($url,$model)
                    {
                    return Html::a
                     (
                        '<span class="glyphicon glyphicon-remove"></span>',
                        ["offer/decline",'id'=>$model->id],
                        [
                          'title' => Yii::t('app', 'Decline'),
                          'data' => ['confirm' => 'Perusahaan ditolak ?','method' => 'post',]
                        ],
                     );
                    },
                    'pending'=>function($url,$model)
                    {
                    return Html::a
                     (
                        '<span class="glyphicon glyphicon-alert"></span>',
                        ["offer/pending",'id'=>$model->id],
                        [
                          'title' => Yii::t('app', 'Pending'),
                          'data' => ['confirm' => 'Pending 1 minggu ?','method' => 'post',]
                        ],
                     );
                    },
                ],
                'visible' => Yii::$app->user->identity->type == 'Administrator'
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'header' => 'Aksi',
              'headerOptions'=>['style'=>'width:8%'],
              'template' => '{view} {duplicate}',
              'buttons' => [
                'view'=>function($url,$model)
                {
                  return Html::a
                    (
                      '<i class="fa fa-fw fa-eye"></i>',
                      ["offer/view",'id'=>$model->id],
                      ['title' => Yii::t('app', 'View'),'target'=>'_blank'],
                    );
                },
                'duplicate'=>function($url,$model)
                {
                  return Html::a
                     (
                        '<span class="glyphicon glyphicon-minus-sign"></span>',
                        ["offer/duplicate",'id'=>$model->id],
                        [
                          'title' => Yii::t('app', 'Duplicate Data!'),
                          'data' => ['confirm' => 'Perusahaan terdeteksi duplikat ?','method' => 'post',],
                        ],
                     );
                },
              ],
              'visibleButtons' => [
                    'duplicate' => function ($model) {
                        return Yii::$app->user->identity->type == 'Administrator';
                    },
              ]
            ],
        ],
    ]); ?>
  </div></div></div>

  <div class="modal fade" id="offer-number"><div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>No.Surat Penawaran</b></h4>          
            </div>
            <div class="modal-body">
              <?= $this->render('_formnumber', ['modelnumber' => $modelnumber]) ?>
            </div>
        </div>
    </div></div>

</div>
