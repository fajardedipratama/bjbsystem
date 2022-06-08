<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SendSample */

$this->title = 'Detail Kirim Dok/Sampel';

\yii\web\YiiAsset::register($this);
?>
<div class="send-sample-view">

    <div class="row">
        <div class="col-sm-7">
          <h1><?= $this->title ?></h1>
        </div>
        <div class="col-sm-5">
          <p>
        <?php if(Yii::$app->user->identity->type != 'Marketing'): ?>
         <?php if($model->status == 'Pending'): ?>
            <?= Html::a('<i class="fa fa-fw fa-check-square-o"></i> Setuju', ['accsend', 'id' => $model->id], ['class' => 'btn btn-success','data' => ['confirm' => 'Setuju Kirim Sampel ?','method' => 'post']]) ?>
            <?= Html::a('<i class="fa fa-fw fa-remove"></i> Tolak', ['dontsend', 'id' => $model->id], ['class' => 'btn btn-danger','data' => ['confirm' => 'Tolak Kirim Sampel ?','method' => 'post']]) ?>
         <?php elseif($model->status == 'Disetujui' && Yii::$app->user->identity->type == 'Administrator'): ?>
            <div class="btn-group">
                <button type="button" class="btn btn-success"><i class="fa fa-fw fa-truck"></i> Kirim</button>
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <?= Html::a('<i class="fa fa-fw fa-check-square-o"></i> Terkirim', ['sendsuccess', 'id' => $model->id], ['data' => ['confirm' => 'Barang Terkirim ?','method' => 'post']]) ?>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-fw fa-times"></i> Batal Kirim', ['sendfailed', 'id' => $model->id], ['data' => ['confirm' => 'Barang Batal Kirim ?','method' => 'post']]) ?>
                    </li>
                </ul>
            </div>
            <?= Html::a('<i class="fa fa-fw fa-pencil"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
         <?php endif; ?>
         <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
            <?= Html::a('<i class="fa fa-fw fa-print"></i> Print', ['print', 'id' => $model->id], ['class' => 'btn btn-primary','target'=>'_blank']) ?>
         <?php endif; ?>
        <?php endif ?>
        <?php if($model->status == 'Pending' && Yii::$app->user->identity->type != 'Manajemen'): ?>
            <?= Html::a('<i class="fa fa-fw fa-pencil"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('<i class="fa fa-fw fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => ['confirm' => 'Hapus data ini ?','method' => 'post',],
            ]) ?>
        <?php endif ?>
          </p> 
        </div>
    </div>
    <div class="box"><div class="box-body"><div class="table-responsive">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'perusahaan',
                'format' => 'raw',
                'value'=>function($data){
                    if(Yii::$app->user->identity->type == 'Marketing'){
                        return Html::a($data->customer->perusahaan, ['selfcustomer/view', 'id' => $data->perusahaan]);
                    }else{
                        return Html::a($data->customer->perusahaan, ['customer/view', 'id' => $data->perusahaan]);
                    }
                },
            ],
            [
                'attribute'=>'sales',
                'value'=>($model->karyawan)?$model->karyawan->nama:'-',
            ],
            'penerima',
            'alamat',
            'tgl_kirim',
            'jumlah',
            'catatan',
            'status',
            'created_time',
        ],
    ]) ?>
    </div></div></div>
</div>
