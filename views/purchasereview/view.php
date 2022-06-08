<?php
use app\models\PurchaseReview;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseReview */

$check = PurchaseReview::find()->where(['perusahaan_id'=>$_GET['id']])->one();

$this->title = 'Review '.$model->perusahaan;
\yii\web\YiiAsset::register($this);
?>
<div class="purchase-review-view">

    <div class="row">
        <div class="col-sm-10">
            <h1>
                <?= Html::a('<i class="glyphicon glyphicon-chevron-left"></i>', ['/purchasereview'], ['class' => 'btn btn-success']) ?>
                Review <b><?= $model->perusahaan ?></b>
            </h1>
        </div>
        <div class="col-sm-2">
        <?php if($check): ?>
            <?= Html::a('<i class="fa fa-fw fa-pencil"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-warning','title'=>'Update']) ?>
        <?php else: ?>
            <?= Html::a('<i class="fa fa-fw fa-plus-square"></i> Tambah', ['create', 'id' => $model->id], ['class' => 'btn btn-warning','title'=>'Create']) ?>
        <?php endif ?>
        </div>
    </div>

<?php if($check): ?>
<div class="box box-success"><div class="box-body"><div class="table-responsive">
    <?= DetailView::widget([
        'model' => $detail,
        'attributes' => [
            'jarak_ambil',
            'catatan_kirim',
            'catatan_berkas',
            'catatan_bayar',
            'catatan_lain',
            'kendala',
            [
                'attribute'=>'review_by',
                'value'=>$detail->karyawan->nama_pendek,
            ],
        ],
    ]) ?>
</div></div></div>
<?php endif ?>

</div>
