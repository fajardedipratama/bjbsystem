<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OfferPermit */

$this->title = 'Update Offer Permit: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Offer Permits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="offer-permit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
