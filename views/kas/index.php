<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\KasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kas';
?>
<div class="kas-index">
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
            [
                'attribute'=>'bulan',
                'value'=>function($data){
                    return date('F', mktime(0, 0, 0, $data->bulan));
                }
            ],
            'tahun',
            [
                'attribute'=>'saldo',
                'value'=>function($data){
                    return Yii::$app->formatter->asCurrency($data->saldo);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Detail',
                'template'=>'{view} {update}',
            ],
        ],
    ]); ?>
</div></div></div>

</div>
