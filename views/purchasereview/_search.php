<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\PurchasereviewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-review-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'perusahaan_id') ?>

    <?= $form->field($model, 'last_purchase_id') ?>

    <?= $form->field($model, 'sales_id') ?>

    <?= $form->field($model, 'waktu_ambil') ?>

    <?php // echo $form->field($model, 'jarak_ambil') ?>

    <?php // echo $form->field($model, 'catatan_kirim') ?>

    <?php // echo $form->field($model, 'catatan_berkas') ?>

    <?php // echo $form->field($model, 'catatan_bayar') ?>

    <?php // echo $form->field($model, 'catatan_lain') ?>

    <?php // echo $form->field($model, 'kendala') ?>

    <?php // echo $form->field($model, 'review_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
