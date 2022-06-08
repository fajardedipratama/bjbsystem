<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\City */

$this->title = 'Ubah ' . $model->kota;

?>
<div class="city-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
