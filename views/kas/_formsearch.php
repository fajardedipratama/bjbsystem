<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\KasDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kas-detail-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($newModel, 'tgl_kas')->widget(DatePicker::className(),[
            'clientOptions'=>[
                'autoclose'=>true,
                'format'=>'dd-mm-yyyy',
                'orientation'=>'bottom',
            ]
        ])?>
    
        <?= Html::submitButton('Print', ['name'=>'print','class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>

</div>
