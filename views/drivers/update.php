<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Drivers */

$this->title = 'Update Driver ' . $model->driver;
?>
<div class="drivers-update">

    <h1>Ubah Driver <b><i><?= $model->driver ?></i></b></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
