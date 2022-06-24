<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Jobtitle;

/* @var $this yii\web\View */
/* @var $model app\models\Pelamar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pelamar-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-success"><div class="box-body">
    <div class="row">
    <div class="col-sm-3">
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-3">
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-3">
    <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-3">
    <?= $form->field($model, 'alamat')->textarea(['style' => 'resize:none','rows' => 3]) ?>
    </div>

    <div class="col-sm-3">
    <?= $form->field($model, 'gender')->dropDownList(['Laki-Laki'=>'Laki-Laki','Perempuan'=>'Perempuan'],['prompt'=>'--Jenis Kelamin--']) ?>
    </div>

    <div class="col-sm-3">
    <?= $form->field($model, 'agama')->dropDownList(['Islam'=>'Islam','Kristen'=>'Kristen','Buddha'=>'Buddha','Hindu'=>'Hindu','Konghucu'=>'Konghucu'],['prompt'=>'--Pilih Agama--']) ?>
    </div>

    <div class="col-sm-3">
    <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-3">
    <?php 
                if(!$model->isNewRecord || $model->isNewRecord){
                    if($model->tanggal_lahir!=null){
                        $model->tanggal_lahir=date('d-m-Y',strtotime($model->tanggal_lahir));
                    }
                }
            ?>
    <?= $form->field($model, 'tanggal_lahir')->widget(DatePicker::className(),[
                'clientOptions'=>[
                'autoclose'=>true,
                'format'=>'dd-mm-yyyy',
                'orientation'=>'bottom',
                ]
            ])?>
    </div>

    <div class="col-sm-3">
    <?= $form->field($model, 'pendidikan')->dropDownList(['SMA/Sederajat'=>'SMA/Sederajat','D1/D2/D3'=>'D1/D2/D3','D4/S1'=>'D4/S1','S2'=>'S2','S3'=>'S3'],['prompt'=>'--Pendidikan Terakhir--']) ?>
    </div>

    <div class="col-sm-3">
    <?= $form->field($model, 'status_nikah')->dropDownList(['Belum Menikah'=>'Belum Menikah','Menikah'=>'Menikah','Cerai'=>'Cerai'],['prompt'=>'--Status Nikah--']) ?>
    </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'posisi')->dropDownList(
                ArrayHelper::map(Jobtitle::find()->all(),'id',
                    function($model){
                        return $model['posisi'];
                    }
            ),['prompt'=>'--Jabatan--']); ?>
        </div>
</div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
