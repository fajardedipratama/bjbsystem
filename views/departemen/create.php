<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Departemen */

$this->title = 'Tambah Departemen';
?>
<div class="departemen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
