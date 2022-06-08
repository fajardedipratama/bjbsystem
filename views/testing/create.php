<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Testing */

$this->title = 'Create Testing';
$this->params['breadcrumbs'][] = ['label' => 'Testings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
