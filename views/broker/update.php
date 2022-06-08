<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Broker */

$this->title = 'Ubah Broker : '.$model->nama;
?>
<div class="broker-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
