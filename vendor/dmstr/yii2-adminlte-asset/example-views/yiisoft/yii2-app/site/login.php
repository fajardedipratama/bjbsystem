<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

    <div class="login-box">
        <div class="form">
        <!-- <h2 style="font-family: Helvetica">BJB-APP</h2><br> -->
        <img src="photos/logo.png" width="50%" style="padding-bottom: 15px">
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
        <form class="login-form">
        <?= $form
            ->field($model, 'username')
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username'),'autofocus'=>'on']) ?>

        <?= $form
            ->field($model, 'password')
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
            <div class="row">
                <div class="col-xs-12">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
        </form>
        </div>
    </div>

        <?php ActiveForm::end(); ?>

</div>
