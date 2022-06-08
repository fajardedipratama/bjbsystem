<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KasDetail */

$this->title = 'Update Detail Kas';
?>
<div class="kas-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
