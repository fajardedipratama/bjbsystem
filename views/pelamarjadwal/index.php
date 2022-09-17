<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Pelamar;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PelamarjadwalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jadwal Pelamar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pelamar-jadwal-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id_pelamar',
                'value' => 'pelamar.nama',
                'filter'=>\kartik\select2\Select2::widget([
                    'model'=>$searchModel,'attribute'=>'id_pelamar','data'=>$pelamar,
                    'options'=>['placeholder'=>'Nama Pelamar'],'pluginOptions'=>['allowClear'=>true]
                ]),
            ],
            [
              'attribute'=>'tanggal',
              'value' => function($data){
                return $data->tanggal;
              },
              'headerOptions'=>['style'=>'width:20%'],
              'format' => ['date','dd-MM-Y'],
              'filter'=> DatePicker::widget([
                'model'=>$searchModel,'attribute'=>'tanggal','clientOptions'=>[
                  'autoclose'=>true, 'format' => 'dd-mm-yyyy','orientation'=>'bottom'
                ],
              ])
            ],
            'jenis',
            [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Kehadiran',
            'template' => '{hadir}',
            'buttons' =>
            [
                'hadir'=>function($url,$model)
                {
                    if($model->kehadiran == NULL){
                        return Html::a('Hadir',['pelamar/ulasan','id'=>$model->id_pelamar,'interview'=>$model->id], ['class'=>'btn btn-xs btn-primary']);
                    }else{
                        return Html::a('Sudah Hadir', ['pelamar/ulasan','id'=>$model->id_pelamar], ['class'=>'btn btn-xs btn-success disabled']);
                    }
                },
            ]
            ],

            [
                'header'=>'Aksi','class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
            ],
        ],
    ]); ?>
</div></div></div>


</div>
