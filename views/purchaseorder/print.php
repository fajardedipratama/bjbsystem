<?php 
use app\models\PurchaseOrder;
use app\models\City;
use app\models\Broker;

function termin_value($value){
    if($value=='Cash On Delivery'){
        return 0;
    }elseif($value=='Cash Before Delivery'){
        return 0;
    }elseif($value=='Tempo 7 Hari'){
        return 100;
    }elseif($value=='Tempo 14 Hari'){
        return 200;
    }elseif($value=='Tempo 21 Hari'){
        return 300;
    }elseif($value=='Tempo 30 Hari'){
        return 400;
    }
}
function cashback_value($value){
    if($value){
        return ' + Cashback '.$value;
    }
}

function round_up($number, $precision = 2)
{
    $fig = pow(10, $precision);
    return (ceil($number * $fig) / $fig);
}
$ppn = ($model->harga*10)/100;
$pph = round_up(($model->harga*0.3)/100,2);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Form PO <?= $model->customer->perusahaan ?></title>
</head>
<body style="margin-top: 0">

<table border="1" style="font-family: Arial;font-size: 15px;margin-left: 65%" cellpadding="7" cellspacing="0">
	<tbody>
		<tr><td colspan="2" style="font-weight: bold;text-align: center;">FORM PO</td></tr>
		<tr>
			<td style="font-weight: bold;">Status Order</td>
			<td>
				<?php 
					$check=PurchaseOrder::find()->where(['perusahaan'=>$model->perusahaan])->andWhere(['status'=>['Pending','Terkirim','Terbayar-Selesai']])->andWhere(['<=','tgl_po',$model->tgl_po])->count();
                    if($check > 1){
                        echo "Repeat Order";
                    }else{
                        echo "First Order";
                    }
				?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Perusahaan</td><td><?= $model->customer->perusahaan ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Nama Sales</td><td><?= $model->karyawan->nama ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Nama Broker</td>
			<td><?php if($model->broker != NULL){
						$query = Broker::find()->where(['id'=>$model->broker])->one();
	                    echo $query['nama'];
	                }else{
	                	echo "-";
	                }
				?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">No. PO</td><td><?= $model->no_po ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Tanggal PO</td><td><?= date('d/m/Y',strtotime($model->tgl_po))  ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Tanggal Kirim</td><td><?= date('d/m/Y',strtotime($model->tgl_kirim))  ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Alamat Perusahaan</td><td><?= $model->alamat ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Alamat Kirim</td><td><?= $model->alamat_kirim ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Volume</td><td><?= $model->volume ?> Liter</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Pajak</td><td><?= $model->pajak ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Catatan</td><td><?= $model->catatan ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Penerima Barang</td><td><?= $model->penerima ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Pembayaran</td><td><?= $model->termin ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Harga/liter</td>
			<td> 
				<?php 
					$city = City::find()->where(['id'=>$model->kota_kirim])->one();
					if($model->pajak === 'Non PPN'){
						echo ($model->harga-termin_value($model->termin)-$city['oat']-$model->cashback).' + Termin '.termin_value($model->termin).' + OAT '.$city['oat'].cashback_value($model->cashback).' = '.$model->harga;
					}else{
						echo ($model->harga-termin_value($model->termin)-$city['oat']-$model->cashback).' + Termin '.termin_value($model->termin).' + OAT '.$city['oat'].cashback_value($model->cashback).' = <b>DPP '.$model->harga.'</b>';
					}
				?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Metode Bayar</td>
			<td>
				<?php 
					if($model->bilyet_giro == 1){
						echo $model->pembayaran.' (& Backup BG)';
					}else{
						echo $model->pembayaran;
					} 
				?>	
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Purchasing</td><td><?= $model->purchasing.' '.$model->no_purchasing ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Keuangan</td><td><?= $model->keuangan.' '.$model->no_keuangan ?></td>
		</tr>
	</tbody>
</table>

</body>
</html>