<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KasDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kas-detail-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-success"><div class="box-body">
        <?= $form->field($model, 'deskripsi')->textarea(['style' => 'resize:none','rows' => 3]) ?>
        <?= $form->field($model, 'titip')->checkBox(['selected' => $model->titip]) ?>
    </div></div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
