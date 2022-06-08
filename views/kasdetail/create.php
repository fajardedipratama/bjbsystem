<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KasDetail */

$this->title = 'Create Kas Detail';
$this->params['breadcrumbs'][] = ['label' => 'Kas Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kas-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
