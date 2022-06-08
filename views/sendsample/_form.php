<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Customer;
use app\models\Karyawan;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\SendSample */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="send-sample-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if(Yii::$app->user->identity->type == 'Marketing'): ?>
        <?= $form->field($model, 'sales')->hiddenInput(['value'=>Yii::$app->user->identity->profilname,'readonly'=>true])->label(false) ?>
    <?php endif ?>
    <div class="box box-success"><div class="box-body">
    <div class="row">
        <div class="col-sm-4">
    <?php if(Yii::$app->user->identity->type == 'Marketing'): ?>
            <?= $form->field($model, 'perusahaan')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Customer::find()->where(['sales'=>Yii::$app->user->identity->profilname])->andWhere(['>=','expired',date('Y-m-d')])->orderBy(['perusahaan'=>SORT_ASC])->all(),'id',
                function($model){
                    return $model['perusahaan'];
                }
            ),
            'options'=>['placeholder'=>"Perusahaan"],'pluginOptions'=>['allowClear'=>true]
            ]) ?>
    <?php else: ?>
            <?= $form->field($model, 'perusahaan')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Customer::find()->orderBy(['perusahaan'=>SORT_ASC])->all(),'id',
                function($model){
                    if($model->verified == 'yes'){
                        return '(OK) '.$model['perusahaan'];
                    }else{
                        return $model['perusahaan'];
                    }
                }
            ),
            'options'=>['placeholder'=>"Perusahaan"],'pluginOptions'=>['allowClear'=>true]
            ]) ?>
    <?php endif; ?> 
        </div>
    <?php if(Yii::$app->user->identity->type != 'Marketing'): ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'sales')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Karyawan::find()->where(['status_aktif'=>'Aktif'])->orderBy(['nama'=>SORT_ASC])->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                }
            ),
            'options'=>['placeholder'=>"Sales"],'pluginOptions'=>['allowClear'=>true]
            ]) ?>
        </div>
    <?php endif ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'jumlah')->textInput(['type'=>'number']) ?>
            <p class="help-block">1 botol : 125 ml</p>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'penerima')->textInput(['maxlength' => true]) ?>
            <p class="help-block">Bapak Tama (082xxxxxxx)</p>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
        </div>
    <?php if(!$model->isNewRecord && Yii::$app->user->identity->type != 'Marketing' && $model->status == 'Terkirim'): ?>
        <div class="col-sm-4">
            <?php 
                if(!$model->isNewRecord || $model->isNewRecord){
                    if($model->tgl_kirim!=null){
                        $model->tgl_kirim=date('d-m-Y',strtotime($model->tgl_kirim));
                    }
                }
            ?>
            <?= $form->field($model, 'tgl_kirim')->widget(DatePicker::className(),[
            'clientOptions'=>['autoclose'=>true,'format'=>'dd-mm-yyyy','orientation'=>'bottom']
            ])?>
        </div>
    <?php endif ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'catatan')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
    <?php if(!$model->isNewRecord && Yii::$app->user->identity->type != 'Marketing' && $model->status != 'Pending'): ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'status')->dropDownList(['Pending'=>'Pending','Ditolak'=>'Ditolak','Disetujui'=>'Disetujui','Terkirim'=>'Terkirim']) ?>
        </div>
    <?php endif ?>
    </div>
    </div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
