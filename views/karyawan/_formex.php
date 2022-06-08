<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use dosamigos\datepicker\DatePicker;
use app\models\Karyawan;

$this->title = 'Ex-Karyawan';

/* @var $this yii\web\View */
/* @var $model app\models\Karyawan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exkaryawan-form">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-success"><div class="box-body">
    <div class="row">
    	<div class="col-sm-4">
    		<?= $form->field($model, 'nama_karyawan')->textInput(['value'=>$model->nama,'readonly'=>true]) ?>
    	</div>
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
	</div></div>

    <div class="form-group">
        <?= Html::submitButton('Simpan', [
        	'class' => 'btn btn-success',
        	'data' => ['confirm' => 'Apakah anda yakin ingin menonaktifkan karyawan ini ?'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
