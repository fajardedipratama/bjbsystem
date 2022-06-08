<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\SendsampleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="send-sample-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'perusahaan') ?>

    <?= $form->field($model, 'sales') ?>

    <?= $form->field($model, 'penerima') ?>

    <?= $form->field($model, 'alamat') ?>

    <?php // echo $form->field($model, 'tgl_kirim') ?>

    <?php // echo $form->field($model, 'jumlah') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
