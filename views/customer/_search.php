<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'perusahaan') ?>

    <?= $form->field($model, 'lokasi') ?>

    <?= $form->field($model, 'alamat_lengkap') ?>

    <?= $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'telfon') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
