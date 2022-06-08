<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jobtitle */

$this->title = 'Tambah Jabatan';

?>
<div class="jobtitle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>