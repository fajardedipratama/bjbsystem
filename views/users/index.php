<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Karyawan;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';

?>
<div class="users-index">
    <div class="row">
        <div class="col-sm-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-2">
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah Data', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'profilname',
                'value' => function($data){
                    $karyawan = Karyawan::find()->where(['id'=>$data->profilname])->one();
                    return '('.$karyawan['badge'].') '.$karyawan['nama'];
                }
            ],
            'username',
            'last_login',
            'type',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Aksi',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    </div></div></div>

</div>
