<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Karyawan;
/* @var $this yii\web\View */
/* @var $model app\models\PelamarAkses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pelamar-akses-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="box box-success"><div class="box-body"><div class="row">
    <div class="col-sm-3">
	    <?= $form->field($model, 'karyawan')->dropDownList(
            ArrayHelper::map(Karyawan::find()->where(['status_aktif'=>'Aktif'])->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                }
        ),['prompt'=>'--Karyawan--']); ?>
	</div>
	<div class="col-sm-3">
	    <?= $form->field($model, 'akses')->dropDownList(['HRD'=>'HRD','Pimpinan'=>'Pimpinan'],['prompt'=>'--Akses--']) ?>
	</div>
	</div></div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
