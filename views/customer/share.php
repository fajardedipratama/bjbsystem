<?php
use app\models\Karyawan;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$query = Karyawan::find()->where(['id'=>$model->sales])->one();

$this->title = 'Sebar '. $model->perusahaan;

?>
<div class="customer-update">

    <h2>Sebar <b><?= $model->perusahaan ?></b></h2>
    <?php if($model->sales): ?>
    	<h5>Sales sebelumnya : <b><?= $query['nama'] ?></b></h5>
    <?php endif; ?>

    <?= $this->render('_formshare', [
        'model' => $model,
    ]) ?>

</div>
