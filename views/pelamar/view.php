<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Pelamar;

/* @var $this yii\web\View */
/* @var $model app\models\Pelamar */

$this->title = $model->nama;
\yii\web\YiiAsset::register($this);
?>
<div class="pelamar-view">

    

    <div class="row">
        <div class="col-sm-10">
        <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-2">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>        
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>    
        </div>
    </div>


    <section class="content"><div class="nav-tabs-custom tab-success">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#detail" data-toggle="tab">Data Diri</a></li>
            <li><a href="#jadwal" data-toggle="tab">Jadwal Interview & Hasil</a></li>
            
        </ul>

    <div class="tab-content">
        <div class="active tab-pane" id="detail">
            <div class="table-responsive">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama',
            'email',
            'no_hp',
            'alamat',
            'gender',
            'agama',
            ['attribute'=>'tempat_lahir','value'=>$model->tempat_lahir.','.date('d/m/Y',strtotime($model->tanggal_lahir))],
            'pendidikan',
            'status_nikah',
            ['attribute'=>'posisi','value'=>$model->jobtitle->posisi],
            'status',
        ],
    ]) ?>
            </div>
        </div>

        <div class="tab-pane" id="jadwal">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Jadwal Interview</th>
                        <th>Hasil Interview</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    </div>    
    </section>



</div>
