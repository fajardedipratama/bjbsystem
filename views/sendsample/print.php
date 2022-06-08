<?php 
use app\models\SendSample;
use app\models\Karyawan;
use app\models\Customer;

$sales = Karyawan::find()->where(['id'=>$model->sales])->one();
$perusahaan = Customer::find()->where(['id'=>$model->perusahaan])->one();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Print Alamat Kirim Sampel</title>
</head>
<body style="margin-top: 0">
<table style="font-family: Arial;font-size: 12px;" border="1" cellspacing="0" cellpadding="7">
	<tr>
		<td width="48%">
			<p><?= $sales['nama_pendek'].' ('.$sales['no_hp'].')' ?></p>
			<p>PT BERDIKARI JAYA BERSAMA (Marketing Branch)</p>
			<p>Jl. Raya Kendalsari RK 69, Ruko Nirwana Regency</p>
			<p>Surabaya - Jawa Timur</p>
		</td>
		<td width="4%"></td>
		<td width="48%">
			<p>Yth. <?= $model->penerima ?></p>
			<p><?= $perusahaan['perusahaan'] ?></p>
			<p><?= $model->alamat ?></p>
		</td>
	</tr>
</table>
</body>
</html>