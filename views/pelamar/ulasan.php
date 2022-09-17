<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pelamar */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Ulasan Pelamar';
?>

<div class="pelamar-form">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-success"><div class="box-body">
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'ulasan')->textarea(['style' => 'resize:none','rows'=>5]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
