<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\OfferSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'waktu') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'perusahaan') ?>

    <?= $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'top') ?>

    <?php // echo $form->field($model, 'pajak') ?>

    <?php // echo $form->field($model, 'harga') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'sales') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'expired') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
