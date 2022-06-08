<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use app\models\Dailyreport;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ExpiredSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Expired';
?>
<div class="customer-index">

    <div class="row">
        <div class="col-sm-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-4">
        <?php if(Yii::$app->user->identity->type == 'Marketing'): ?>
            <?= Html::a('<i class="fa fa-fw fa-chevron-left"></i> Kembali', ['selfcustomer/index'], ['class' => 'btn btn-success']) ?>
        <?php else: ?>
            <?= Html::a('<i class="fa fa-fw fa-institution"></i> Data Perusahaan', ['customer/index'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-fw fa-exchange"></i> Pindah Expired', ['expired/move'], ['class' => 'btn btn-danger']) ?>
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
                    if($model->verified == 'yes'){
                        return '<i class="fa fa-fw fa-check" title="Disetujui"></i>';
                    }elseif($model->verified == 'no'){
                        return '<i class="fa fa-fw fa-remove" title="Ditolak"></i>';
                    }
                },
                'filter'=> ['yes'=>'yes','no'=>'no']
            ],
            [
                'attribute'=>'perusahaan',
                'format'=>'raw',
                'value'=>function($model){
                    if($model->long_expired == 'yes'){
                        return $model->perusahaan.' <i class="fa fa-fw fa-warning" title="Pernah Diperpanjang"></i>';
                    }else{
                        return $model->perusahaan;
                    }
                }
            ],
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
                    if($model->verified != 'no'){
                        $query = Dailyreport::find()->where(['perusahaan'=>$model->id])->orderBy(['waktu'=>SORT_DESC])->one();
                        if($query){
                            return $query['keterangan'];
                        }
                    }else{
                        return $model->catatan;
                    }
                }
            ],
            [
                'attribute' => 'sales',
                'value' => 'karyawan.nama_pendek',
                'filter'=>\kartik\select2\Select2::widget([
                    'model'=>$searchModel,'attribute'=>'sales','data'=>$sales,
                    'options'=>['placeholder'=>'Sales'],'pluginOptions'=>['allowClear'=>true]
                ]),
                'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen',
            ],
            [
              'header'=>'Expired',
              'value' => 'expired',
              'headerOptions'=>['style'=>'width:13%'],
              'format' => ['date', 'dd-MM-Y'],
              'filter'=> DatePicker::widget([
                'model'=>$searchModel,'attribute'=>'expired','clientOptions'=>[
                  'autoclose'=>true, 'format' => 'dd-mm-yyyy','orientation'=>'bottom'
                ],
              ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn','header'=>'Aksi',
                'template' => '{view} {assign}',
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
                    'view'=>function($url,$model)
                    {
                    return Html::a
                     (
                        '<span class="glyphicon glyphicon-eye-open"></span>',
                        ["customer/view",'id'=>$model->id],
                        ['title' => Yii::t('app', 'View')],
                     );
                    },
                ],
                'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen',
            ],
            // [
            //     'class' => 'yii\grid\ActionColumn','header'=>'Detail',
            //     'template' => '{view}',
            //     'buttons'=>
            //     [
            //         'view'=>function($url,$model)
            //         {
            //             if(strtotime('+14 days', strtotime($model->expired)) <= strtotime(date('Y-m-d'))){
            //                 return Html::a
            //                 (
            //                     '<span class="glyphicon glyphicon-eye-open"></span>',
            //                     ["selfcustomer/view",'id'=>$model->id],['title' => Yii::t('app', 'View')],
            //                 );
            //             }
            //         },
            //     ],
            //     'visible' => Yii::$app->user->identity->type == 'Marketing',
            // ],
        ],
    ]); ?>
</div></div></div>

</div>
