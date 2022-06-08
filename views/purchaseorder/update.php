<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */

$this->title = 'Ubah PO';
?>
<div class="purchase-order-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h4><?= $model->no_po.' - '.$model->customer->perusahaan ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
