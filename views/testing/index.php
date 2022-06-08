<?php
use app\models\SendSample;
use app\models\Customer;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$query = SendSample::find()->where(['id'=>140])->andWhere(['>','created_time','2021-12-21 00:00:00']);

$this->title = 'Testings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testing-index">

<?= $query->count(); ?>
<body style="margin-top: 0">
    <table style="font-family: Arial;font-size: 12px;" border="1" cellspacing="2" cellpadding="7">
    <?php foreach ($query->all() as $show) : ?>
    <?php $perusahaan = Customer::find()->where(['id'=>$show->perusahaan])->one(); ?>
        <tr>
            <td width="50%">
                <b>Pengirim : </b><br>
                PT BERDIKARI JAYA BERSAMA (Marketing Branch) <br>
                Jl. Raya Kendalsari RK 69, Ruko Nirwana Regency, Surabaya <br>
                03121000167 <br>
            </td>
            <td width="50%">
                <b>Penerima : </b><br>
                Yth. <?= $show->penerima ?> <br>
                <?= $perusahaan['perusahaan'] ?> <br>
                <?= $show->alamat ?> <br>
                <?= $perusahaan['telfon'] ?> <br>
            </td>
        </tr>
    <?php endforeach ?>
    </table>
</body>

</div>
