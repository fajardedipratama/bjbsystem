<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\KasdetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kas-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kas_id') ?>

    <?= $form->field($model, 'akun_id') ?>

    <?= $form->field($model, 'tgl_kas') ?>

    <?= $form->field($model, 'deskripsi') ?>

    <?php // echo $form->field($model, 'jenis') ?>

    <?php // echo $form->field($model, 'nominal') ?>

    <?php // echo $form->field($model, 'titip?') ?>

    <?php // echo $form->field($model, 'saldo_akhir') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
