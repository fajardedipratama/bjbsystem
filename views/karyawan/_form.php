<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Karyawan;
use app\models\Jobtitle;
use app\models\Departemen;
/* @var $this yii\web\View */
/* @var $model app\models\Karyawan */
/* @var $form yii\widgets\ActiveForm */

$nip_max = Karyawan::find()->max('badge');

?>

<div class="karyawan-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="box box-success"><div class="box-body">
    <div class="row">
        <div class="col-sm-3">
        <?php if($model->isNewRecord): ?>
            <?= $form->field($model, 'badge')->textInput(['maxlength' => true,'value'=>$nip_max+1]) ?>
        <?php else: ?>
            <?= $form->field($model, 'badge')->textInput(['maxlength' => true]) ?>
        <?php endif; ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'nama_pendek')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'gender')->dropDownList(['Laki-Laki'=>'Laki-Laki','Perempuan'=>'Perempuan'],['prompt'=>'--Jenis Kelamin--']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'agama')->dropDownList([
                'Islam'=>'Islam','Kristen'=>'Kristen','Buddha'=>'Buddha','Hindu'=>'Hindu','Konghucu'=>'Konghucu'],['prompt'=>'--Pilih Agama--']) ?>
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
            <?= $form->field($model, 'no_hp')->textInput(['type'=>'number','maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'pendidikan')->dropDownList(['SMA/Sederajat'=>'SMA/Sederajat','D1/D2/D3'=>'D1/D2/D3','D4/S1'=>'D4/S1','S2'=>'S2','S3'=>'S3'],['prompt'=>'--Pendidikan Terakhir--']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status_kawin')->dropDownList(['Belum Menikah'=>'Belum Menikah','Menikah'=>'Menikah','Cerai'=>'Cerai'],['prompt'=>'--Status Nikah--']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'no_ktp')->textInput(['type'=>'number','maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'alamat_ktp')->textarea(['style' => 'resize:none','rows' => 3]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'alamat_rumah')->textarea(['style' => 'resize:none','rows' => 3]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'posisi')->dropDownList(
                ArrayHelper::map(Jobtitle::find()->all(),'id',
                    function($model){
                        return $model['posisi'];
                    }
            ),['prompt'=>'--Jabatan--']); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'departemen')->dropDownList(
                ArrayHelper::map(Departemen::find()->all(),'id',
                    function($model){
                        return $model['departemen'];
                    }
            ),['prompt'=>'--Departemen--']); ?>
        </div>
         <div class="col-sm-3">
            <?php 
                if(!$model->isNewRecord || $model->isNewRecord){
                    if($model->tanggal_masuk!=null){
                        $model->tanggal_masuk=date('d-m-Y',strtotime($model->tanggal_masuk));
                    }
                }
            ?>
            <?= $form->field($model, 'tanggal_masuk')->widget(DatePicker::className(),[
                'clientOptions'=>[
                    'autoclose'=>true,
                    'format'=>'dd-mm-yyyy',
                    'orientation'=>'bottom',
                ]
            ])?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'foto_karyawan')->fileInput(); ?>
            <?php if(!$model->isNewRecord): ?>
                <small>*Jika tidak ada perubahan foto, kosongi field ini</small>
            <?php endif; ?>
            <p class="help-block">Format: JPG/JPEG/PNG max. 1 MB</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'bank')->textInput(['readonly'=>true,'value'=>'BCA']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'no_rekening')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'nama_rekening')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
<?php if($model->status_aktif == 'Tidak Aktif'): ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'alasan_resign')->textarea(['style' => 'resize:none','rows' => 3]) ?>
        </div>
        <div class="col-sm-3">
            <?php 
                if(!$model->isNewRecord || $model->isNewRecord){
                    if($model->tgl_resign!=null){
                        $model->tgl_resign=date('d-m-Y',strtotime($model->tgl_resign));
                    }
                }
            ?>
            <?= $form->field($model, 'tgl_resign')->widget(DatePicker::className(),[
                'clientOptions'=>[
                    'autoclose'=>true,
                    'format'=>'dd-mm-yyyy',
                    'orientation'=>'bottom',
                ]
            ])?>
        </div>
    </div>
<?php endif; ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
