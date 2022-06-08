<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use app\models\Dailyreport;
use app\models\PurchaseOrder;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Perusahaan';

?>
<div class="customer-index">

    <div class="row">
        <div class="col-sm-9">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-3">
        <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah Data', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-fw fa-warning"></i> Expired', ['/expired'], ['class' => 'btn btn-danger']) ?>
        <?php else: ?>
            <?= Html::a('<i class="glyphicon glyphicon-refresh"></i>', ['index'], ['class' => 'btn btn-warning pull-right']) ?>
        <?php endif; ?>
        </div>
    </div>

<div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'verified',
                'headerOptions'=>['style'=>'width:6%'],
                'format'=>'raw',
                'value'=>function($model){
                    $query = PurchaseOrder::find()->where(['perusahaan'=>$model->id])->andWhere(['status'=>['Terkirim','Terbayar-Selesai']])->count();
                    if($query>0){
                        if($model->verified == 'yes'){
                            return '<i class="fa fa-fw fa-check" title="Disetujui"></i> <i class="fa fa-fw fa-lock" title="PO"></i>';
                        }elseif($model->verified == 'no'){
                            return '<i class="fa fa-fw fa-remove" title="Ditolak"></i> <i class="fa fa-fw fa-lock" title="PO"></i>';
                        }elseif($model->verified == 'black'){
                            return '<i class="fa fa-fw fa-ban" title="Blacklist"></i> <i class="fa fa-fw fa-lock" title="PO"></i>';
                        }
                    }else{
                        if($model->verified == 'yes'){
                            return '<i class="fa fa-fw fa-check" title="Disetujui"></i>';
                        }elseif($model->verified == 'no'){
                            return '<i class="fa fa-fw fa-remove" title="Ditolak"></i>';
                        }elseif($model->verified == 'black'){
                            return '<i class="fa fa-fw fa-ban" title="Blacklist"></i>';
                        }
                    }
                },
                'filter'=> ['yes'=>'yes','no'=>'no','black'=>'black']
            ],
            'perusahaan',
            [
                'attribute' => 'lokasi',
                'value' => 'city.kota',
                'filter'=>\kartik\select2\Select2::widget([
                    'model'=>$searchModel,'attribute'=>'lokasi','data'=>$kota,
                    'options'=>['placeholder'=>'Lokasi'],'pluginOptions'=>['allowClear'=>true]
                ])
            ],
            [
                'attribute' => 'sales',
                'value' => function($model){
                    if(Yii::$app->user->identity->type != 'Marketing'){
                        if ($model->sales) {
                            return $model->karyawan->nama_pendek;
                        }else{
                            return " ";
                        }
                    }else{
                        if ($model->sales) {
                            if($model->sales == 2){
                                return " ";
                            }else{
                                return $model->karyawan->nama_pendek;
                            }
                        }else{
                            return " ";
                        }
                    }
                },
                'filter'=>\kartik\select2\Select2::widget([
                    'model'=>$searchModel,'attribute'=>'sales','data'=>$sales,
                    'options'=>['placeholder'=>'Sales'],'pluginOptions'=>['allowClear'=>true]
                ])
            ],
            [
                'header'=>'Status Terakhir',
                'value'=>function($model){
                    if($model->verified != 'no'){
                        $query = Dailyreport::find()->where(['perusahaan'=>$model->id])->orderBy(['waktu'=>SORT_DESC])->one();
                      if($query){
                        if(Yii::$app->user->identity->type != 'Marketing'){
                            return $query['keterangan'].'-'.date('d/m/y',strtotime($query['waktu']));
                        }else{
                            return $query['keterangan'];
                        }
                      }
                    }else{
                        return $model->catatan;
                    }
                }
            ],
            [
              'header'=>'Expired',
              'value' => 'expired',
              'headerOptions'=>['style'=>'width:10%'],
              'format' => ['date', 'dd-MM-Y'],
              'filter'=> DatePicker::widget([
                'model'=>$searchModel,'attribute'=>'expired','clientOptions'=>[
                  'autoclose'=>true, 'format' => 'dd-mm-yyyy','orientation'=>'bottom'
                ],
              ]),
              'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
            ],
            [
                'class' => 'yii\grid\ActionColumn','header'=>'Aksi',
                'template' => '{view} {update} {assign}',
                'buttons'=>
                [
                    'assign'=>function($url,$model)
                    {
                    return Html::a
                     (
                        '<span class="glyphicon glyphicon-share"></span>',
                        ["customer/share",'id'=>$model->id],
                        ['title' => Yii::t('app', 'Sebarkan')],
                     );
                    },

                ],
                'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen',
                'visibleButtons' => [
                    'update' => function ($model) {
                        return Yii::$app->user->identity->type == 'Administrator';
                    },
                    'assign' => function ($model) {
                        return Yii::$app->user->identity->type == 'Administrator';
                    },
                ]
            ],
        ],
    ]); ?>
</div></div></div>

</div>
