<?php
use app\models\PelamarAkses;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$check = PelamarAkses::find()->count();
$hrd = PelamarAkses::find()->where(['akses'=>'HRD'])->one();

$this->title = 'Setting Akses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pelamar-akses-index">

    <div class="row">
        <div class="col-sm-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-2">
        <?php if(Yii::$app->user->identity->profilname == $hrd->karyawan && $check < 2): ?>
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah Data', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        </div>
    </div>

<div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'karyawan',
                'value' => 'employee.nama'
            ],
            'akses',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'template' => '{delete}',
                'visible' => Yii::$app->user->identity->profilname == $hrd->karyawan,
            ],
        ],
    ]); ?>
</div></div></div>

</div>
