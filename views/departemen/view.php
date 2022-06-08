<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Departemen */

$this->title = $model->departemen;

\yii\web\YiiAsset::register($this);
?>
<div class="departemen-view">
    <div class="row">
        <div class="col-sm-8">
            <h1>Detail <b><i>#<?= Html::encode($this->title) ?></i></b></h1>
        </div>
        <div class="col-sm-4">
            <p>
                <?= Html::a('<i class="fa fa-fw fa-list"></i> Data', ['index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-fw fa-pencil"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('<i class="fa fa-fw fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Hapus data ini ?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'departemen',
        ],
    ]) ?>

</div>
