<?php
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DailyreportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aktivitas Sales';

?>
<div class="dailyreport-index">

    <div class="row">
        <div class="col-sm-9">
            <h1><?= Html::encode($this->title) ?></h1>
            <h5><i>Tanggal : <?= date('d-m-Y',strtotime($_GET['waktu'])); ?></i></h5>
        </div>
        <div class="col-sm-3">
        <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
            <?= Html::a('<i class="fa fa-fw fa-file-excel-o"></i> Export', ['export-excel2','waktu'=>$_GET['waktu']], ['class'=>'btn btn-success']); ?>
        <?php endif ?> 
            <button class="btn btn-primary" data-toggle="modal" data-target="#searchglobal"><i class="fa fa-fw fa-search"></i> Cari</button>
            <?= Html::a('<i class="fa fa-fw fa-calendar"></i> Today', ['index','waktu'=>date('Y-m-d')], ['class'=>'btn btn-warning']); ?>
        </div>
    </div>


<div class="box"><div class="box-body"><div class="table-responsive">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'sales',
                'value' => 'karyawan.nama_pendek',
                'filter'=>\kartik\select2\Select2::widget([
                    'model'=>$searchModel,'attribute'=>'sales','data'=>$sales,
                    'options'=>['placeholder'=>'Sales'],'pluginOptions'=>['allowClear'=>true]
                ]),
                'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
            ],
            [
                'attribute'=>'waktu',
                'headerOptions'=>['style'=>'width:12%'],
                'format' => ['date','dd-MM-Y H:i'],
            ],
            [
              'attribute'=>'perusahaan',
              'format'=>'raw',
              'value'=>function($data){
                return '<a href="index.php?r=customer/view&id='.$data->customer->id.'" target="_blank">'.$data->customer->perusahaan.'</a>';
              },
              'headerOptions'=>['style'=>'width:25%'],
            ],
            [
                'attribute'=>'pengingat',
                'format' => ['date','dd-MM-Y'],
            ],
            'keterangan',
            'catatan',
            'con_used',
            [
                'class' => 'yii\grid\ActionColumn','header'=>'Aksi',
                'template' => '{update} {delete}',
                'visible' => Yii::$app->user->identity->type == 'Administrator'
            ],
        ],
    ]); ?>
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
