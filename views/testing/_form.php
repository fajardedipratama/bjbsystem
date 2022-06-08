<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Testing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testing-form">

    <?php $form = ActiveForm::begin(); ?>
<?php for ($i=0; $i < 2; $i++) : ?>
    <?= $form->field($model, 'data_a[$i]')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'data_b[$i]')->textInput(['maxlength' => true]) ?>
<?php endfor ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
