<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrderFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-file-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-success"><div class="box-body">
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'penerima')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'berkas')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?php 
                if(!$model->isNewRecord || $model->isNewRecord){
                    if($model->tgl_kirim!=null){
                        $model->tgl_kirim=date('d-m-Y',strtotime($model->tgl_kirim));
                    }
                }
            ?>
            <?= $form->field($model, 'tgl_kirim')->widget(DatePicker::className(),[
                'clientOptions'=>[
                    'autoclose'=>true,
                    'format'=>'dd-mm-yyyy',
                    'orientation'=>'bottom',
                ]
            ])?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'kirim_by')->dropDownList(['Direct'=>'Direct','Ekspedisi'=>'Ekspedisi','Email/WA'=>'Email/WA']) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    </div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
