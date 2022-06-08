<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Departemen;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Jobtitle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobtitle-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-success"><div class="box-body">
    	<div class="row">
    		<div class="col-sm-4">
    			<?= $form->field($model, 'posisi')->textInput(['maxlength' => true]) ?>
    		</div>
    	</div>
    </div></div>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
