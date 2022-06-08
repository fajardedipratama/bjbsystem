<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\DailyreportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dailyreport-search">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'waktu')->widget(DatePicker::className(),[
        'clientOptions'=>[
        'autoclose'=>true,
        'format'=>'dd-mm-yyyy',
        'orientation'=>'bottom',
        ]
    ])?>
    <div class="form-group">
        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
