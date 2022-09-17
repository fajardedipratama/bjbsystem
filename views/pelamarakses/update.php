<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PelamarAkses */

$this->title = 'Update Pelamar Akses: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pelamar Akses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pelamar-akses-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
