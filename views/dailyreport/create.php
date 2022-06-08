<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dailyreport */

$this->title = 'Progress Perusahaan';

?>
<div class="dailyreport-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
