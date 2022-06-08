<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SendSample */

$this->title = 'Tambah Data';

?>
<div class="send-sample-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
