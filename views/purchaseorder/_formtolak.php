<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'alasan_tolak')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Tolak', ['name'=>'tolak','class' => 'btn btn-danger','data' => ['confirm' => 'Tolak PO ?','method' => 'post']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
