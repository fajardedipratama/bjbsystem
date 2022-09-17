<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Jobtitle;
use app\models\PelamarAkses;

$hrd = PelamarAkses::find()->where(['akses'=>'HRD'])->one();

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PelamarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pelamar';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-sm-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-2">
        <?php if(Yii::$app->user->identity->profilname == $hrd->karyawan): ?>
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah Data', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        </div>
    </div>

<div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama',
            'no_hp',
            'alamat',
            'gender',
            [
                'attribute' => 'posisi',
                'value' => 'jobtitle.posisi'
            ],
            [
                'attribute'=>'status',
                'filter'=> ['Belum diproses'=>'Belum diproses','Interview HRD'=>'Interview HRD','Interview Pimpinan'=>'Interview Pimpinan','Diterima'=>'Diterima','Ditolak'=>'Ditolak'],
            ],
            [
                'header'=>'Aksi','class' => 'yii\grid\ActionColumn',
                'template'=>'{view}'
            ],
        ],
    ]); ?>
</div></div></div>


</div>
