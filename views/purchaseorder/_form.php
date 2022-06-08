<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Customer;
use app\models\Karyawan;
use app\models\City;
use app\models\Broker;
use app\models\Drivers;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if(Yii::$app->user->identity->type == 'Marketing'): ?>
        <?= $form->field($model, 'sales')->hiddenInput(['value'=>Yii::$app->user->identity->profilname,'readonly'=>true])->label(false) ?>
    <?php endif ?>
    <div class="box box-success"><div class="box-body">
<div class="row">
    <div class="col-sm-4">
      <?php if(Yii::$app->user->identity->type == 'Marketing'): ?>
        <?= $form->field($model, 'perusahaan')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Customer::find()->where(['sales'=>Yii::$app->user->identity->profilname])->andWhere(['verified'=>'yes'])->all(),'id',
                function($model){
                    return $model['perusahaan'];
                }
            ),
            'options'=>['placeholder'=>"Perusahaan"],'pluginOptions'=>['allowClear'=>true]
        ]) ?>
      <?php else: ?>
        <?= $form->field($model, 'perusahaan')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Customer::find()->where(['verified'=>['yes','black']])->all(),'id',
                function($model){
                    return $model['perusahaan'];
                }
            ),
            'options'=>['placeholder'=>"Perusahaan"],'pluginOptions'=>['allowClear'=>true]
        ]) ?>
      <?php endif ?>
    </div>
<?php if(Yii::$app->user->identity->type != 'Marketing'): ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'sales')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Karyawan::find()->orderBy(['nama'=>SORT_ASC])->all(),'id',
                function($model){
                    return $model['nama_pendek'];
                }
            ),
            'options'=>['placeholder'=>"Sales"],'pluginOptions'=>['allowClear'=>true]
        ]) ?>
    </div>
     <div class="col-sm-4">
        <?= $form->field($model, 'broker')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(Broker::find()->orderBy(['nama'=>SORT_ASC])->all(),'id',
                function($model){
                    return $model['nama'];
                }
            ),
            'options'=>['placeholder'=>"Broker"],'pluginOptions'=>['allowClear'=>true]
        ]) ?>
    </div>
<?php endif; ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'no_po')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?php 
            if(!$model->isNewRecord || $model->isNewRecord){
                if($model->tgl_po!=null){
                    $model->tgl_po=date('d-m-Y',strtotime($model->tgl_po));
                }
            }
        ?>
        <?= $form->field($model, 'tgl_po')->widget(DatePicker::className(),[
            'clientOptions'=>['autoclose'=>true,'format'=>'dd-mm-yyyy','orientation'=>'bottom']
        ])?>
    </div>
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
    <div class="col-sm-4">
        <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'kota_kirim')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(City::find()->orderBy(['kota'=>SORT_ASC])->all(),'id',
                function($model){
                    return $model['kota'];
                }
            ),
            'options'=>['placeholder'=>"Kab/Kota Kirim"],'pluginOptions'=>['allowClear'=>true]
        ]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'alamat_kirim')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'purchasing')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'no_purchasing')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'keuangan')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'no_keuangan')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'volume')->textInput(['type'=>'number']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'termin')->dropDownList(['Cash On Delivery'=>'Cash On Delivery','Cash Before Delivery'=>'Cash Before Delivery','Tempo 7 Hari'=>'Tempo 7 Hari','Tempo 14 Hari'=>'Tempo 14 Hari','Tempo 21 Hari'=>'Tempo 21 Hari','Tempo 30 Hari'=>'Tempo 30 Hari']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'harga')->textInput(['type'=>'number']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'cashback')->textInput(['type'=>'number']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'pajak')->dropDownList(['PPN'=>'PPN','Non PPN'=>'Non PPN']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'pembayaran')->dropDownList(['Transfer'=>'Transfer','Tunai'=>'Tunai','Barter'=>'Barter']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'catatan')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'penerima')->textInput(['maxlength' => true]) ?>
    </div>
<?php if(Yii::$app->user->identity->type != 'Marketing'): ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'eksternal')->dropDownList(['yes'=>'yes'],['prompt'=>'--Eksternal ?--']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'penalti')->textInput(['type'=>'number']) ?>
    </div>
<?php endif ?>
    <div class="col-sm-4">
        <label>Backup BG ?</label>
        <?= $form->field($model, 'bilyet_giro')->checkBox(['label'=>false,'selected' => $model->bilyet_giro]) ?>
    </div>
<?php if(Yii::$app->user->identity->type != 'Marketing' && !$model->isNewRecord): ?>
    <?php if($model->jatuh_tempo != NULL): ?>
    <div class="col-sm-4">
        <?php 
            if(!$model->isNewRecord || $model->isNewRecord){
                if($model->jatuh_tempo!=null){
                    $model->jatuh_tempo=date('d-m-Y',strtotime($model->jatuh_tempo));
                }
            }
        ?>
        <?= $form->field($model, 'jatuh_tempo')->widget(DatePicker::className(),[
            'clientOptions'=>['autoclose'=>true,'format'=>'dd-mm-yyyy','orientation'=>'bottom']
        ])?>
    </div>
    <?php endif; ?>
    <?php if($model->tgl_lunas != NULL): ?>
    <div class="col-sm-4">
        <?php 
            if(!$model->isNewRecord || $model->isNewRecord){
                if($model->tgl_lunas!=null){
                    $model->tgl_lunas=date('d-m-Y',strtotime($model->tgl_lunas));
                }
            }
        ?>
        <?= $form->field($model, 'tgl_lunas')->widget(DatePicker::className(),[
            'clientOptions'=>['autoclose'=>true,'format'=>'dd-mm-yyyy','orientation'=>'bottom']
        ])?>
    </div>
    <?php endif; ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'status')->dropDownList(['Pending'=>'Pending','Ditolak'=>'Ditolak','Disetujui'=>'Disetujui','Terkirim'=>'Terkirim','Batal Kirim'=>'Batal Kirim','Terbayar-Selesai'=>'Terbayar-Selesai']) ?>
    </div>
    <?php if(in_array($model->status,['Terkirim','Terbayar-Selesai'])): ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'driver_id')->dropDownList(
        ArrayHelper::map(Drivers::find()->all(),'id',
            function($model){
                return $model['driver'];
            }
        )); ?>
    </div>
    <?php endif ?>
<?php endif ?>
</div>
    </div></div>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
