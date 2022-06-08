<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Ubah User ' . $model->username;
?>
<div class="users-update">

    <h1>Ubah <i><strong>@<?= Html::encode($model->username) ?></strong></i></h1>
	<?= $this->render('_form', ['model' => $model]) ?>

</div>
