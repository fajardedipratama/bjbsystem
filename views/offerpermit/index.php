<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OfferpermitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Offer Permits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offer-permit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Offer Permit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_customer',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
