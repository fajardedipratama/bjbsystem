<?php
use app\models\KasDetail;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kas */

$detail = KasDetail::find()->where(['kas_id'=>$model->id])->orderBy(['tgl_kas'=>SORT_DESC,'id'=>SORT_DESC,]);

$this->title = 'Kas '.$model->bulan.'/'.$model->tahun;
\yii\web\YiiAsset::register($this);
?>
<div class="kas-view">

<div class="row">
    <div class="col-sm-9">
        <h1><?= Html::encode($this->title) ?></h1>
        <button class="btn btn-success"><i class="fa fa-fw fa-money"></i> Saldo : <?= Yii::$app->formatter->asCurrency($model->saldo); ?></button>
    </div>
    <div class="col-sm-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#input-detail"><i class="fa fa-fw fa-plus-square"></i> Tambah Data</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#print-detail"><i class="fa fa-fw fa-print"></i> Print</button>
    </div>
</div>


<div class="box box-success" style="margin-top:1%"><div class="box-body"><div class="table-responsive">
<!--     <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
    </ul> -->
<?php if($detail->count() > 0): ?>
    <?= Html::a('<i class="fa fa-fw fa-trash"></i> Hapus Input Terakhir', ['/kasdetail/deletelast','id' =>$model->id], [
        'class' => 'btn btn-sm btn-danger',
        'data' => [
            'confirm' => 'Hapus Input Terakhir ?',
            'method' => 'post',
        ],
    ]) ?>
<?php endif ?>
    <table class="table table-hover table-bordered">
        <tr>
            <th width="10%">Tanggal</th>
            <th width="45%">Kebutuhan</th>
            <th width="15%">Masuk</th>
            <th width="15%">Keluar</th>
            <th width="15%">Saldo</th>
        </tr>
    <?php foreach($detail->all() as $show): ?>
        <tr <?php if($show->titip==1){ echo "style='background-color:yellow'"; } ?> >
            <td><?= date('d/m/Y',strtotime($show->tgl_kas)); ?></td>
            <td>
                <?= Html::a('<i class="fa fa-fw fa-pencil"></i>', ['/kasdetail/update','id'=>$show->id])?>
                <?= $show->deskripsi; ?>
            </td>
            <td>
                <?php if($show->jenis === 'Masuk'){
                    echo Yii::$app->formatter->asCurrency($show->nominal);
                } ?>  
            </td>
            <td>
                <?php if($show->jenis === 'Keluar'){
                    echo Yii::$app->formatter->asCurrency($show->nominal);
                } ?>  
            </td>
            <td><?= Yii::$app->formatter->asCurrency($show->saldo_akhir) ?></td>
        </tr>
    <?php endforeach ?>
    </table>
</div></div></div>

    <div class="modal fade" id="input-detail"><div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Tambah Data</b></h4>          
            </div>
            <div class="modal-body">
              <?= $this->render('_formdetail', ['newModel' => $newModel]) ?>
            </div>
        </div>
    </div></div>

    <div class="modal fade" id="print-detail"><div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Print</b></h4>          
            </div>
            <div class="modal-body">
              <?= $this->render('_formsearch', ['newModel' => $newModel]) ?>
            </div>
        </div>
    </div></div>

</div>
