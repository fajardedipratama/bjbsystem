<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KasDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kas-detail-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($newModel, 'deskripsi')->textarea(['style' => 'resize:none','rows' => 3]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($newModel, 'jenis')->dropDownList(['Masuk'=>'Masuk','Keluar'=>'Keluar'],['prompt'=>'--Jenis--']) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($newModel, 'nominal')->textInput(['type'=>'number']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($newModel, 'titip')->checkBox(['selected' => $newModel->titip]) ?>
    </div>
</div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['name'=>'simpan','class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
