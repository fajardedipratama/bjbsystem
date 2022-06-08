<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\KasdetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kas Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kas-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kas Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kas_id',
            'akun_id',
            'tgl_kas',
            'deskripsi',
            //'jenis',
            //'nominal',
            //'titip?',
            //'saldo_akhir',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
