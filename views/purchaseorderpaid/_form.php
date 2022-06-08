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
<div class="box box-success"><div class="box-body"><div class="row">
	<div class="col-sm-4">
		<?php 
            if(!$model->isNewRecord || $model->isNewRecord){
                if($model->paid_date!=null){
                    $model->paid_date=date('d-m-Y',strtotime($model->paid_date));
                }
            }
        ?>
        <?= $form->field($model, 'paid_date')->widget(DatePicker::className(),[
            'clientOptions'=>['autoclose'=>true,'format'=>'dd-mm-yyyy','orientation'=>'bottom']
        ])?>
	</div>
    <div class="col-sm-4">
    	<?= $form->field($model, 'amount')->textInput(['type'=>'number']) ?>
	</div>
    <div class="col-sm-4">
        <?= $form->field($model, 'bank')->dropDownList(['Mandiri 1430014465569 (PT Berdikari Jaya Bersama)'=>'Mandiri 1430014465569 (PT Berdikari Jaya Bersama)','BCA 0393039300 (PT Berdikari Jaya Bersama)'=>'BCA 0393039300 (PT Berdikari Jaya Bersama)','BCA 0566515151 (Godwin)'=>'BCA 0566515151 (Godwin)']) ?>
    </div>
    <div class="col-sm-4">
    	<?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
	</div>
</div></div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
