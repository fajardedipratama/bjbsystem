<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pelamar */

$this->title = 'Tambah Pelamar';
$this->params['breadcrumbs'][] = ['label' => 'Pelamars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pelamar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
