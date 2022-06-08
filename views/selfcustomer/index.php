<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use app\models\Dailyreport;
use app\models\PurchaseOrder;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SelfCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Sales';

?>
<div class="selfcustomer-index">

    <div class="row">
        <div class="col-sm-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-4">
            <?= Html::a('<i class="glyphicon glyphicon-refresh"></i>', ['index'], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah Data', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-fw fa-warning"></i> Expired', ['/expired'], ['class' => 'btn btn-danger']) ?>
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
                    $query = PurchaseOrder::find()->where(['perusahaan'=>$model->id])->andWhere(['!=','status','Ditolak'])->andWhere(['!=','status','Pending'])->count();
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
                'header'=>'Status Terakhir',
                'value'=>function($model){
                    $query = Dailyreport::find()->where(['perusahaan'=>$model->id])->orderBy(['waktu'=>SORT_DESC])->one();
                    if($query){
                        return $query['keterangan'].'-'.date('d/m/y',strtotime($query['waktu']));
                    }
                }
            ],
            [
              'header'=>'Expired',
              'value' => 'expired',
              'headerOptions'=>['style'=>'width:15%'],
              'format' => ['date', 'dd-MM-Y'],
              'filter'=> DatePicker::widget([
                'model'=>$searchModel,'attribute'=>'expired','clientOptions'=>[
                  'autoclose'=>true, 'format' => 'dd-mm-yyyy','orientation'=>'bottom'
                ],
              ])
            ],
            [
                'class' => 'yii\grid\ActionColumn','header'=>'Aksi',
                'template' => '{view}'
            ],
        ],
    ]); ?>
</div></div></div>

</div>
