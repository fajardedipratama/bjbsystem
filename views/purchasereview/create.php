<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseReview */

$this->title = 'Review '.$customer->perusahaan;;
?>
<div class="purchase-review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'customer' => $customer,
    ]) ?>

</div>
