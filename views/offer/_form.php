<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\OfferNumber;
/* @var $this yii\web\View */
/* @var $model app\models\Offer */
/* @var $form yii\widgets\ActiveForm */

$setting = OfferNumber::find()->where(['id'=>1])->one();

?>

<div class="offer-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="box box-success"><div class="box-body">
    <div class="row">
    <?= $form->field($model, 'sales')->hiddenInput(['value'=>$customer->sales,'readonly'=>true])->label(false) ?>
    <?= $form->field($model, 'perusahaan')->hiddenInput(['value'=>$customer->id,'readonly'=>true])->label(false) ?>
     <div class="col-sm-4">
        <?= $form->field($model, 'pic')->textInput(['maxlength' => true,'value'=>$customer->pic,]) ?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'top')->dropDownList(['Cash On Delivery'=>'Cash On Delivery','Cash Before Delivery'=>'Cash Before Delivery','Tempo 7 Hari'=>'Tempo 7 Hari','Tempo 14 Hari'=>'Tempo 14 Hari','Tempo 21 Hari'=>'Tempo 21 Hari','Tempo 30 Hari'=>'Tempo 30 Hari']) ?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'pajak')->dropDownList(['PPN'=>'PPN','Non PPN'=>'Non PPN']) ?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'harga')->textInput(['type'=>'number','min'=>$setting->min_price,'max'=>$setting->max_price]) ?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'catatan')->textInput(['maxlength' => true]) ?>
     </div>
    </div>
    <div class="row">
     <div class="col-sm-4">
        <label>Kirim Ke WhatsApp ?</label>
        <?= $form->field($model, 'send_wa')->checkBox(['label'=>false,'selected' => $model->send_wa]) ?>
     </div>
     <div class="col-sm-4">
        <label>Tampil Harga PPN & PPH22 ?</label>
        <?= $form->field($model, 'show_tax')->checkBox(['label'=>false,'selected' => $model->show_tax]) ?>
     </div>
    </div>
</div></div>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Batal', ['selfcustomer/view','id'=>$customer->id], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
