<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Calculator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calculator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'komponen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'persentase')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
