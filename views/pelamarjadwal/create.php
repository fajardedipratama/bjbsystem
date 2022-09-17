<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PelamarJadwal */

$this->title = 'Create Pelamar Jadwal';
$this->params['breadcrumbs'][] = ['label' => 'Pelamar Jadwals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pelamar-jadwal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
