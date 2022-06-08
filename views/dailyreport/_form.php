<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Dailyreport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dailyreport-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="box box-success"><div class="box-body">
    <div class="row">
     <div class="col-sm-4">
        <?= $form->field($model, 'perusahaan')->textInput() ?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'keterangan')->dropDownList(
              ['Penawaran'=>'Penawaran','Belum ada kebutuhan'=>'Belum ada kebutuhan','Tidak terhubung'=>'Tidak terhubung','Tidak pakai solar'=>'Tidak pakai solar','Kebutuhan <5KL'=>'Kebutuhan <5KL','Kontrak vendor lain'=>'Kontrak vendor lain'],
              ['prompt'=>'--keterangan--']); ?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'volume')->textInput(['type' => 'number','min'=>5,'max'=>1000]) ?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'jarak_ambil')->dropDownList(['Tiap <1bulan sekali'=>'Tiap <1bulan sekali','Tiap 1bulan sekali'=>'Tiap 1bulan sekali','Tiap >1bulan sekali'=>'Tiap >1bulan sekali'],['prompt'=>'--Jarak Kebutuhan--']) ?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'catatan')->textInput(['maxlength' => true]) ?>
     </div>
     <div class="col-sm-4">
        <?php 
            if(!$model->isNewRecord || $model->isNewRecord){
                if($model->pengingat!=null){
                    $model->pengingat=date('d-m-Y',strtotime($model->pengingat));
                }
            }
        ?>
        <?= $form->field($model, 'pengingat')->widget(DatePicker::className(),[
            'clientOptions'=>[
                'autoclose'=>true,
                'format'=>'dd-mm-yyyy',
                'orientation'=>'bottom',
            ]
        ])?>
     </div>
    </div>
</div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
