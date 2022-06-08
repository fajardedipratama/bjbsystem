<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'set_awal')->widget(DatePicker::className(),[
            'clientOptions'=>['autoclose'=>true,'format'=>'dd-mm-yyyy','orientation'=>'bottom']
            ])?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'set_akhir')->widget(DatePicker::className(),[
            'clientOptions'=>['autoclose'=>true,'format'=>'dd-mm-yyyy','orientation'=>'bottom']
            ])?>
        </div>
    </div>
    <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

</div>
