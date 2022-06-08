<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dosamigos\chartjs\ChartJs;
/* @var $this yii\web\View */
/* @var $model app\models\Karyawan */

$this->title = 'Statistik '.$model->nama_pendek;
\yii\web\YiiAsset::register($this);
?>
<div class="karyawan-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <h5>Tanggal : <?= date('d-M-Y') ?></h5>

    <div class="box"><div class="box-body"><div class="table-responsive">
        <?= ChartJs::widget([
            'type' => 'bar',
            'data' => [
                'labels' => ["January"],
                'datasets' => [
                    [
                        'label' => "Penawaran Baru",
                        'backgroundColor' => "rgb(179,181,198)",
                        'borderColor' => "rgb(179,181,198)",
                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                        'data' => [65, 59, 90, 81, 56, 55, 40]
                    ],
                    [
                        'label' => "Penawaran Follow Up",
                        'backgroundColor' => "rgb(179,181,198)",
                        'borderColor' => "rgb(179,181,198)",
                        'pointBackgroundColor' => "rgba(255,99,132,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(255,99,132,1)",
                        'data' => [28, 48, 40, 19, 96, 27, 100]
                    ],
                    [
                        'label' => "Penawaran Gagal",
                        'backgroundColor' => "rgb(179,181,198)",
                        'borderColor' => "rgb(179,181,198)",
                        'pointBackgroundColor' => "rgba(255,99,132,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(255,99,132,1)",
                        'data' => [28, 48, 40, 19, 96, 27, 100]
                    ]
                ]
            ]
        ]);
        ?>
    </div></div></div>
</div>
