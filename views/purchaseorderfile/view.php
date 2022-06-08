<?php 
use app\models\PurchaseOrderFile;
use app\models\PurchaseOrder;
use app\models\Karyawan;
use app\models\Customer;

$po_detail = PurchaseOrder::find()->where(['id'=>$model->purchase_order_id])->one();
$perusahaan = Customer::find()->where(['id'=>$po_detail->perusahaan])->one();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Alamat Kirim</title>
</head>
<body style="margin-top: 0">
<table style="font-family: Arial;font-size: 12px;" border="1" cellspacing="0" cellpadding="7">
    <tr>
        <td width="48%">
            <p>PT BERDIKARI JAYA BERSAMA (Marketing Branch)</p>
            <p>03121000167</p>
            <p>berdikarijayabersama.sby@gmail.com</p>
            <p>Jl. Raya Kendalsari RK 69, Ruko Nirwana Regency, Surabaya</p>
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