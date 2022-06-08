<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Drivers;
/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'driver_id')->dropDownList(
        ArrayHelper::map(Drivers::find()->orderBy(['driver'=>SORT_ASC])->all(),'id',
            function($model){
                return $model['driver'];
            }
        )); ?>

    <div class="form-group">
        <?= Html::submitButton('Terkirim', ['name'=>'po_send','class' => 'btn btn-success','data' => ['confirm' => 'PO Terkirim ?','method' => 'post']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
