<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dailyreport */

$this->title = 'Update Daily Report #' . $model->id;
?>
<div class="dailyreport-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h5><?= $model->customer->perusahaan.'-'.$model->karyawan->nama_pendek.' ('.$model->waktu.')'?></h5>

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
