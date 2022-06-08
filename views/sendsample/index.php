<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SendsampleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kirim Dok/Sampel';

?>
<div class="send-sample-index">

    <div class="row">
        <div class="col-sm-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-4">
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah Data', ['create'], ['class' => 'btn btn-success']) ?>
        <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
            <?= Html::a('<i class="fa fa-fw fa-print"></i> Print Disetujui', ['printall'], ['class' => 'btn btn-danger']) ?>
        <?php endif ?>
        </div>
    </div>
    <div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute'=>'perusahaan',
                'value'=>'customer.perusahaan',
                'headerOptions'=>['style'=>'width:30%'],
                'filter'=>\kartik\select2\Select2::widget([
                    'model'=>$searchModel,'attribute'=>'perusahaan','data'=>$customer,
                    'options'=>['placeholder'=>'Perusahaan'],'pluginOptions'=>['allowClear'=>true]
                ])
            ],
            [
                'attribute'=>'sales',
                'value'=>'karyawan.nama_pendek',
                'headerOptions'=>['style'=>'width:15%'],
                'filter'=>\kartik\select2\Select2::widget([
                    'model'=>$searchModel,'attribute'=>'sales','data'=>$sales,
                    'options'=>['placeholder'=>'Sales'],'pluginOptions'=>['allowClear'=>true]
                ]),
                'visible' => Yii::$app->user->identity->type != 'Marketing'
            ],
            'jumlah',
            [
              'attribute'=>'tgl_kirim',
              'value' => function($data){
                return $data->tgl_kirim;
              },
              'headerOptions'=>['style'=>'width:15%'],
              'format' => ['date','dd-MM-Y'],
              'filter'=> DatePicker::widget([
                'model'=>$searchModel,'attribute'=>'tgl_kirim','clientOptions'=>[
                  'autoclose'=>true, 'format' => 'dd-mm-yyyy','orientation'=>'bottom'
                ],
              ])
            ],
            [
               'attribute'=>'status',
               'headerOptions'=>['style'=>'width:13%'],
               'filter'=> ['Pending'=>'Pending','Disetujui'=>'Disetujui','Ditolak'=>'Ditolak','Terkirim'=>'Terkirim']
            ],
            [
                'header'=>'Aksi','class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'visible' => Yii::$app->user->identity->type == 'Marketing' || Yii::$app->user->identity->type == 'Manajemen',
            ],
            [
                'header'=>'Aksi','class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {delete}',
                'visible' => Yii::$app->user->identity->type == 'Administrator',
            ],
        ],
    ]); ?>
    </div></div></div>

</div>
