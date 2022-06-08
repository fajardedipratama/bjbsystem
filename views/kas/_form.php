<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kas-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="box box-success"><div class="box-body">
<div class="row">
    <div class="col-sm-4">
        <?= $form->field($model, 'bulan')->textInput(['type'=>'number','min'=>1,'max'=>12]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'tahun')->textInput(['type'=>'number']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'saldo')->textInput(['type'=>'number']) ?>
    </div>
</div>
</div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
