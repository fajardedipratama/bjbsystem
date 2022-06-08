<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Customer;
use app\models\Karyawan;
$this->title = 'Gabung Customer';
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <h4><?= $model->perusahaan.' - '.$model->karyawan->nama_pendek ?></h4>
    <?php $form = ActiveForm::begin(); ?>
<div class="box box-success"><div class="box-body">
    <div class="row">
     <div class="col-sm-5">
        <?= $form->field($model, 'target')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Customer::find()->where(['!=','id',$model->id])->orderBy(['perusahaan'=>SORT_ASC])->all(),'id',
                function($model){
                    
                    if($model['sales']){
                        $sales = Karyawan::find()->where(['id'=>$model['sales']])->one();
                        if($model->verified == 'yes'){
                            return '(OK) '.$model['perusahaan'].'-'.$sales['nama_pendek'];
                        }else{
                            return $model['perusahaan'].'-'.$sales['nama_pendek'];
                        }
                        
                    }
                    
                }
            ),
            'options'=>['placeholder'=>"Perusahaan"],'pluginOptions'=>['allowClear'=>true],
        ]) ?>
     </div>
    </div>
     <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
     </div>
</div></div>
    <?php ActiveForm::end(); ?>
 
</div>
