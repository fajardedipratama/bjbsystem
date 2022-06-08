<?php 
use app\models\KasDetail;

$result = KasDetail::find()->where(['tgl_kas'=>$tgl,'jenis'=>'Keluar'])->andWhere(['titip'=>0]);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Print Bukti Kas Keluar</title>
</head>
<body>
	<table border="1" cellspacing="0" cellpadding="3">
		<tr>
			<td colspan="4" align="center">
				<h3>BUKTI KAS KELUAR</h3>
				Tanggal : <?= date('d/m/Y',strtotime($tgl)) ?>
			</td>
		</tr>

		<tr>
			<th width="5%">No.</th>
			<th width="50%">Keperluan</th>
			<th width="12%">Paraf Penerima</th>
			<th width="23%">Jumlah</th>
		</tr>
	<?php
		$i = 1;
		foreach($result->all() as $show): 
	?>
		<tr>
			<td align="center"><?= $i++ ?></td>
			<td><?= $show->deskripsi ?></td>
			<td></td>
			<td align="right"><?= Yii::$app->formatter->asCurrency($show->nominal) ?></td>
		</tr>
	<?php endforeach ?>
		<tr>			
			<th colspan="3">Total</th>
			<th align="right"><?= Yii::$app->formatter->asCurrency($result->sum('nominal')) ?></th>
		</tr>
		<tr>
			<td colspan="4" align="right" style="padding-right:3%">
				<br>Keuangan <br><br><br><br> .................	
			</td>
		</tr>
	</table>
	<br><br><hr>
</body>
</html>