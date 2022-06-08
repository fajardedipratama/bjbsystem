<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Karyawan';

?>
<div class="karyawan-index">

    <div class="row">
        <div class="col-sm-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-4">
        <?php if(Yii::$app->user->identity->type == 'Administrator'): ?>
            <?= Html::a('<i class="fa fa-fw fa-file-excel-o"></i>', ['export-excel2'], ['class'=>'btn btn-success']); ?>
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah Data', ['create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
            <?= Html::a('<i class="fa fa-fw fa-users"></i> Ex-Karyawan', ['exdata'], ['class' => 'btn btn-danger']) ?>
        </div>
    </div>

<div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'badge',
            'nama',
            [
                'attribute' => 'tanggal_lahir',
                'value' => function($model){
                    return date('d/m/Y',strtotime($model->tanggal_lahir));
                }
            ],
            'no_hp',
            [
                'attribute' => 'posisi',
                'value' => 'jobtitle.posisi'
            ],
            [
                'header'=>'Aksi','class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {resign}',
                'buttons'=> [
                    'resign'=>function($url,$model)
                    {
                    return Html::a
                     (
                        '<span class="glyphicon glyphicon-minus-sign"></span>',
                        ["resign",'id'=>$model->id],['title' => Yii::t('app', 'Nonaktifkan')]
                     );
                    },
                ],
                'visibleButtons' => [
                    'update' => function ($model) {
                        return Yii::$app->user->identity->type == 'Administrator';
                    },
                    'resign' => function ($model) {
                        return Yii::$app->user->identity->type == 'Administrator';
                    },
                ]
            ],
        ],
    ]); ?>
</div></div></div>

</div>
