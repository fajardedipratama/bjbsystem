<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OfferExtra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offer-extra-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($modelextra, 'offer_id')->hiddenInput(['value'=>$model->id])->label(false) ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($modelextra, 'top')->dropDownList(['Cash On Delivery'=>'Cash On Delivery','Cash Before Delivery'=>'Cash Before Delivery','Tempo 7 Hari'=>'Tempo 7 Hari','Tempo 14 Hari'=>'Tempo 14 Hari','Tempo 21 Hari'=>'Tempo 21 Hari','Tempo 30 Hari'=>'Tempo 30 Hari']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($modelextra, 'harga')->textInput(['type'=>'number','min'=>1000,'max'=>50000]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($modelextra, 'pajak')->dropDownList(['PPN'=>'PPN','Non PPN'=>'Non PPN']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
