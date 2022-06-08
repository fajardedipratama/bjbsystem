<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrderPaid */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-paid-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <?= $form->field($modelpaid, 'purchase_order_id')->hiddenInput(['value'=>$model->id,'readonly'=>true])->label(false); ?>
	<div class="col-sm-4">
		<?php 
            if(!$modelpaid->isNewRecord || $modelpaid->isNewRecord){
                if($modelpaid->paid_date!=null){
                    $modelpaid->paid_date=date('d-m-Y',strtotime($modelpaid->paid_date));
                }
            }
        ?>
        <?= $form->field($modelpaid, 'paid_date')->widget(DatePicker::className(),[
            'clientOptions'=>['autoclose'=>true,'format'=>'dd-mm-yyyy','orientation'=>'bottom']
        ])?>
	</div>
    <div class="col-sm-4">
    	<?= $form->field($modelpaid, 'amount')->textInput(['type'=>'number']) ?>
	</div>
    <div class="col-sm-4">
        <?= $form->field($modelpaid, 'bank')->dropDownList(['Mandiri 1430014465569 (PT Berdikari Jaya Bersama)'=>'Mandiri 1430014465569 (PT Berdikari Jaya Bersama)','BCA 0393039300 (PT Berdikari Jaya Bersama)'=>'BCA 0393039300 (PT Berdikari Jaya Bersama)','BCA 0566515151 (Godwin)'=>'BCA 0566515151 (Godwin)','Tunai'=>'Tunai']) ?>
    </div>
    <div class="col-sm-4">
    	<?= $form->field($modelpaid, 'note')->textInput(['maxlength' => true]) ?>
	</div>
</div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
