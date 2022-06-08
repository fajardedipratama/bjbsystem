<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseReview */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'perusahaan_id')->hiddenInput(['value'=>$customer->id,'readonly'=>true])->label(false) ?>
<div class="box box-success"><div class="box-body">
    <div class="row">
    <div class="col-sm-4">
        <?= $form->field($model, 'jarak_ambil')->textInput(['type'=>'number'])->hint("interval turunnya PO") ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'catatan_kirim')->textarea(['style' => 'resize:none','rows' => 3]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'catatan_berkas')->textarea(['style' => 'resize:none','rows' => 3]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'catatan_bayar')->textarea(['style' => 'resize:none','rows' => 3]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'catatan_lain')->textarea(['style' => 'resize:none','rows' => 3]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'kendala')->textarea(['style' => 'resize:none','rows' => 3]) ?>
    </div>
    </div>
</div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
