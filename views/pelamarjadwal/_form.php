<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\PelamarJadwal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pelamar-jadwal-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-success"><div class="box-body">
    <div class="row">
    <div class="col-sm-3">
        <?php 
                if(!$model->isNewRecord || $model->isNewRecord){
                    if($model->tanggal!=null){
                        $model->tanggal=date('d-m-Y',strtotime($model->tanggal));
                    }
                }
            ?> 
    	<?= $form->field($model, 'tanggal')->widget(DatePicker::className(),[
                'clientOptions'=>[
                'autoclose'=>true,
                'format'=>'dd-mm-yyyy',
                'orientation'=>'bottom',
                ]
            ])?>
    </div>

    <div class="col-sm-3">
    	<?= $form->field($model, 'jenis')->dropDownList(['Interview HRD'=>'Interview HRD','Interview Pimpinan'=>'Interview Pimpinan'],['prompt'=>'--Jenis--']) ?>	
    </div>
    
</div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>

</div>
