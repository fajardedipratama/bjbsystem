<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Karyawan */

$this->title = 'Ubah '.$model->nama;
?>
<div class="karyawan-update">

    <h1>Ubah <strong><i>#<?= $model->nama ?></i></strong></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
