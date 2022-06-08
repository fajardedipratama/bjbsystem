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
        <?= $form->field($model, 'keterangan')->dropDownList(
              ['Penawaran'=>'Penawaran','Belum ada kebutuhan'=>'Belum ada kebutuhan','Tidak terhubung ke PIC'=>'Tidak terhubung ke PIC','Menunggu Keputusan'=>'Menunggu Keputusan','Tidak pakai solar'=>'Tidak pakai solar','Kebutuhan minim'=>'Kebutuhan minim','Kontrak vendor lain'=>'Kontrak vendor lain','Kalah harga'=>'Kalah harga','Pakai minyak jenis lain'=>'Pakai minyak jenis lain'],
              ['prompt'=>'--keterangan--']); ?>
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
     <div class="col-sm-4">
     <?= $form->field($model, 'con_used')->dropDownList(['Telfon Kantor'=>'Telfon Kantor','Telfon Pribadi'=>'Telfon Pribadi']) ?>
     </div>
    </div>
</div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
