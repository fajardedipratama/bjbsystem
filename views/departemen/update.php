<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Departemen */

$this->title = 'Ubah Dept. ' . $model->departemen;
?>
<div class="departemen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
