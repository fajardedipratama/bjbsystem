<?php
use app\models\City;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Offer */
$city = City::find()->where(['id'=>$model->customer->lokasi])->one();

$this->title = 'Penawaran #'.$model->no_surat;
?>
<div class="offer-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h5><?= $model->customer->perusahaan.' - '.$city['kota'] ?></h5>

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
