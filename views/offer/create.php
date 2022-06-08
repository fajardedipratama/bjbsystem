<?php

use yii\helpers\Html;
use app\models\City;
/* @var $this yii\web\View */
/* @var $model app\models\Offer */
$city = City::find()->where(['id'=>$customer->lokasi])->one();
$this->title = 'Penawaran';

?>
<div class="offer-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <h4><?= $customer->perusahaan.' - '.$city['kota'] ?></h4>

    <?= $this->render('_form', [
        'model' => $model,'customer' => $customer
    ]) ?>

</div>
