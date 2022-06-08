<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Drivers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="drivers-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-success"><div class="box-body"><div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'driver')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>
        </div>
    </div></div></div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
