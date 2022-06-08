<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'Ubah '. $model->perusahaan;

?>
<div class="customer-update">

    <h2>Ubah <b><?= $model->perusahaan ?></b></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
