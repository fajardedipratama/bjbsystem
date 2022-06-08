<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Customer;
use app\models\Karyawan;
use dosamigos\datepicker\DatePicker;
$this->title = 'Pindah Expired';
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
<div class="box box-success"><div class="box-body">
    <div class="row">
     <div class="col-sm-4">
        <?= $form->field($model, 'target')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Karyawan::find()->where(['posisi'=>'6'])->orderBy(['nama'=>SORT_ASC])->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                }
            ),
            'options'=>['placeholder'=>"Target"],'pluginOptions'=>['allowClear'=>true]
        ]) ?>
        <small>*Jika target = semua, kosongi field ini</small>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'dari_tgl')->widget(DatePicker::className(),[
            'clientOptions'=>[
                'autoclose'=>true,
                'format'=>'dd-mm-yyyy',
                'orientation'=>'bottom',
            ]
        ])?>
     </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'ke_tgl')->widget(DatePicker::className(),[
            'clientOptions'=>[
                'autoclose'=>true,
                'format'=>'dd-mm-yyyy',
                'orientation'=>'bottom',
            ]
        ])?>
     </div>
    </div>
     <div class="form-group">
        <?= Html::submitButton('Pindah', ['class' => 'btn btn-success']) ?>
     </div>
</div></div>
    <?php ActiveForm::end(); ?>
 
</div>
