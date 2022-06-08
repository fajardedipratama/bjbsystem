<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrderPaid */

$this->title = 'Update Pembayaran'
?>
<div class="purchase-order-paid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
