<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Offer */
$this->title = 'Penawaran Baru';

?>
<div class="offer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formadmin', [
        'model' => $model,
    ]) ?>

</div>
