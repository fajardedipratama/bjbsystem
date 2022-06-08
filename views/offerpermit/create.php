<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OfferPermit */

$this->title = 'Create Offer Permit';
$this->params['breadcrumbs'][] = ['label' => 'Offer Permits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offer-permit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
