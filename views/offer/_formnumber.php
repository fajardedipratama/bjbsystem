<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OfferNumber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offer-number-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    	<div class="col-sm-4">
    		<?= $form->field($modelnumber, 'nomor')->textInput(['type'=>'number','min'=>0]) ?>
    	</div>
    	<div class="col-sm-4">
    		<?= $form->field($modelnumber, 'inisial')->textInput(['maxlength' => true]) ?>	
    	</div>
        <div class="col-sm-4">
            <?= $form->field($modelnumber, 'periode')->textInput(['maxlength' => true]) ?>  
        </div>
        <div class="col-sm-4">
            <?= $form->field($modelnumber, 'min_price')->textInput(['type'=>'number','min'=>0]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($modelnumber, 'max_price')->textInput(['type'=>'number','min'=>0]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
