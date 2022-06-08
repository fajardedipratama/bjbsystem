<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\PurchaseorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'perusahaan') ?>

    <?= $form->field($model, 'sales') ?>

    <?= $form->field($model, 'no_po') ?>

    <?= $form->field($model, 'tgl_po') ?>

    <?php // echo $form->field($model, 'tgl_kirim') ?>

    <?php // echo $form->field($model, 'alamat') ?>

    <?php // echo $form->field($model, 'alamat_kirim') ?>

    <?php // echo $form->field($model, 'purchasing') ?>

    <?php // echo $form->field($model, 'no_purchasing') ?>

    <?php // echo $form->field($model, 'keuangan') ?>

    <?php // echo $form->field($model, 'no_keuangan') ?>

    <?php // echo $form->field($model, 'volume') ?>

    <?php // echo $form->field($model, 'termin') ?>

    <?php // echo $form->field($model, 'harga') ?>

    <?php // echo $form->field($model, 'cashback') ?>

    <?php // echo $form->field($model, 'pajak') ?>

    <?php // echo $form->field($model, 'pembayaran') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'alasan_tolak') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
