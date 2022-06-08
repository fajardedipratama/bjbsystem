<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\KaryawanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="karyawan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'badge') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'tempat_lahir') ?>

    <?php // echo $form->field($model, 'tanggal_lahir') ?>

    <?php // echo $form->field($model, 'no_hp') ?>

    <?php // echo $form->field($model, 'no_ktp') ?>

    <?php // echo $form->field($model, 'alamat_ktp') ?>

    <?php // echo $form->field($model, 'alamat_rumah') ?>

    <?php // echo $form->field($model, 'pendidikan') ?>

    <?php // echo $form->field($model, 'status_kawin') ?>

    <?php // echo $form->field($model, 'tanggal_masuk') ?>

    <?php // echo $form->field($model, 'posisi') ?>

    <?php // echo $form->field($model, 'departemen') ?>

    <?php // echo $form->field($model, 'bank') ?>

    <?php // echo $form->field($model, 'no_rekening') ?>

    <?php // echo $form->field($model, 'nama_rekening') ?>

    <?php // echo $form->field($model, 'foto_karyawan') ?>

    <?php // echo $form->field($model, 'status_aktif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
