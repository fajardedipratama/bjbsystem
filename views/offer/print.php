<?php 
use app\models\City;
use app\models\OfferNumber;
use app\models\OfferExtra;

$hariIni = \Carbon\Carbon::now()->locale('id');
$lokasi = City::find()->where(['id'=>$model->customer->lokasi])->one();
$inisial = OfferNumber::find()->where(['id'=>1])->one();
$extra = OfferExtra::find()->where(['offer_id'=>$model->id]);

function round_up($number, $precision = 2)
{
    $fig = pow(10, $precision);
    return (ceil($number * $fig) / $fig);
}

$ppn = ($model->harga*11)/100;
$pph = round_up(($model->harga*0.3)/100,2);
$include = $model->harga+$ppn+$pph;

?>
<!DOCTYPE html>
<html>
<head>
	<title>(<?= $model->no_surat ?>) Surat Penawaran PT Berdikari Jaya Bersama</title>
	<style type="text/css">
		.back {
		  width: 100%;
		  display: block;
		  position: relative;
		}

		.back::after {
		  content: "";
		  background: url(photos/logo.png);
		  background-size: 90% 35%;
		  background-repeat: no-repeat;
		  background-position: center;
		  opacity: 0.2;
		  top: 0;
		  left: 0;
		  bottom: 0;
		  right: 0;
		  position: absolute;
		  z-index: -1;   
		}
	</style>
</head>
<body style="margin-top: 0">
<div class="back">
<table style="font-family: Calibri;">
	<tr>
		<td width="20%"><img src="photos/logo.png" style="width: 105%"></td>
		<td width="60%" style="text-align: center">
			<font style="font-weight: bold;font-size: 28px">PT. BERDIKARI JAYA BERSAMA</font><br>
			<font style="font-size: 18px">SOLUTION FOR OUR ENERGY</font><br>
			<font style="font-size: 14px">Jl. Raya Lumajang KM 5 No. 618</font>
			<font style="font-size: 14px">Kelurahan Kedung Asem – Kecamatan Wonoasih – Kota Probolinggo – Jawa Timur</font>
			<font style="font-size: 14px">Telp/ Fax : 0335 – 421809</font>
		</td>
		<td width="20%"><img src="photos/iso.png" style="width: 55%;margin-left: 6%;"></td>
	</tr>
	<tr><td colspan="3"><hr style="height: 3px;background-color: black"></td></tr>
</table>
<table style="font-family: Arial;font-size: 15px">
	<tr>
		<td width="12%" style="font-weight: bold;">No</td>
		<td>: 0<?= $model->no_surat ?> / <?= $inisial['inisial'] ?> / <?= date('Y') ?></td>
	</tr>
	<tr>
		<td width="12%" style="font-weight: bold;">Tanggal</td>
		<td>: Surabaya, <?= date('d ').$hariIni->monthName.date(' Y'); ?></td>
	</tr>
	<tr>
		<td width="12%" style="font-weight: bold;">Perihal</td>
		<td>: Penawaran Minyak Diesel Industri</td>
	</tr>
	<tr><td colspan="2"><br></td></tr>

	<tr><td colspan="2">Kepada Yth. <?= $model->pic ?></td></tr>
	<tr><td colspan="2"><?= $model->customer->perusahaan ?></td></tr>
	<tr><td colspan="2"><?= ucfirst(strtolower($lokasi['kota'])) ?></td></tr>
	<tr><td colspan="2"><br></td></tr>

	<tr><td colspan="2">Dengan Hormat,</td></tr>
	<tr><td colspan="2" style="text-align: justify;line-height: 1.5em"><span style="display:inline-block; width: 4%;"></span>Melalui surat ini kami jelaskan bahwa PT. Berdikari Jaya Bersama adalah perusahaan yang bergerak dalam penyediaan Bahan Bakar Minyak Diesel Industri. Adapun penawaran harganya yang berlaku sesuai periode <?= $inisial['periode'] ?>, adalah sebagai berikut :</td></tr>
	<tr><td colspan="2"><br></td></tr>

	<tr>
		<td colspan="2" style="font-weight: bold;">HARGA : 
		<?php if($extra->count() < 1): ?>
			<?= Yii::$app->formatter->asCurrency($model->harga) ?> / Liter 
			<?php if($model->pajak === 'PPN'): ?>
				(belum termasuk PPN & PPH22)
			<?php else: ?>
				(harga non-PPN)
			<?php endif ?>
			<br>
			<?php if($model->show_tax === 1 && $model->pajak === 'PPN'): ?>
				<font style="font-weight: normal;font-style: italic;">termasuk PPN(11%) & PPH22(0,3%) : <?= Yii::$app->formatter->asCurrency($include); ?> / Liter</font><br>
			<?php endif ?>
		<?php endif; ?>
		</td>
	</tr>
	<?php if($extra->count() > 0): ?>
	<tr>
		<td colspan="2" style="font-weight: bold;">
			<ul>
			<?php foreach($extra->all() as $show): ?>
			<?php 
				$ppn_ex = ($show->harga*11)/100;
				$pph_ex = ($show->harga*0.3)/100;
				$include_ex = round($show->harga+$ppn_ex+$pph_ex,2,PHP_ROUND_HALF_UP);
			?>
				<li>
				<?php 
					echo Yii::$app->formatter->asCurrency($show->harga).' / Liter (Payment : '.$show->top;
					if($show->pajak === 'PPN'){
						echo ', belum termasuk PPN & PPH22)';
						if($model->show_tax===1){
							echo '<br><font style="font-weight: normal;font-style: italic;">termasuk PPN(11%) & PPH22(0,3%) : '.Yii::$app->formatter->asCurrency($include_ex).'  / Liter</font>';
						}
					}else{
						echo ', harga non-PPN)';
					}
				?>
				</li>
			<?php endforeach ?>
			</ul>
		</td>
	</tr>
	<?php endif; ?>

	<tr>
		<td colspan="2" style="font-size: 14px;font-weight: bold;line-height: 1.5em">
			<font style="font-style: italic;">Note :</font>
			<ul>
				<li>Minimal per PO 5.000 liter</li>
				<li>Toleransi susut yang berlaku adalah 0,5%</li>
			<?php if($extra->count() < 1): ?>
				<li>Term Of Payment : <?= $model->top ?></li>
			<?php endif; ?>
				<li>Pengiriman setelah PO (Purchase Order) </li>
				<li>
				<?php if($extra->count() < 1): ?>
					<?php if($model->pajak === 'PPN'){
						echo 'Pembayaran Wajib ke :<br>Rekening Bank Mandiri : 1430014465569 a.n. PT. Berdikari Jaya Bersama<br>Rekening Bank BCA : 0393039300 a.n. PT. Berdikari Jaya Bersama';
					}else{
						echo 'Pembayaran Wajib ke :<br>Rekening Bank BCA (NON PPN) :  0566515151 a.n. Godwin';
					}?>
				<?php else: ?>
					<?= 'Pembayaran Wajib ke :<br>Rekening Bank Mandiri : 1430014465569 a.n. PT. Berdikari Jaya Bersama<br>Rekening Bank BCA  : 0393039300 a.n. PT. Berdikari Jaya Bersama<br>Rekening Bank BCA (NON PPN) :  0566515151 a.n. Godwin'; ?>
				<?php endif; ?>
				</li>
				<li>Hubungi Sales : <?= $model->karyawan->nama_pendek.' ( '.$model->karyawan->no_hp.' )' ?></li>
				<li>Apabila pembayaran melewati jatuh tempo, akan dikenakan denda Rp.100/liter</li>
			</ul>
		</td>
	</tr>

	<tr><td colspan="2" style="text-align: justify;line-height: 1.5em">Demikian surat penawaran ini kami ajukan untuk dapat dipertimbangkan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</td></tr>
	<tr><td colspan="2"><br></td></tr>

	<tr><td colspan="2">Hormat Kami,<br>PT. BERDIKARI JAYA BERSAMA</td></tr>
	<tr>
		<td colspan="2"><img src="photos/ttdyuwi.jpg" style="width: 25%"></td>
	</tr>
	<tr><td colspan="2" style="font-weight: bold;line-height: 1.5em"><u>Yuwie Santoso,</u><br>Direktur</td></tr>

</table>
</div>
</body>
</html>