<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PelamarAkses */

$this->title = 'Tambah Akses';
?>
<div class="pelamar-akses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
