<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Pelamar;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\PelamarJadwal;
use app\models\PelamarAkses;

$hrd = PelamarAkses::find()->where(['akses'=>'HRD'])->one();

/* @var $this yii\web\View */
/* @var $model app\models\Pelamar */

$id = $_GET['id'];
$data = PelamarJadwal::find()->where(['id_pelamar' =>$id ])->all();

$this->title = $model->nama;
\yii\web\YiiAsset::register($this);
?>
<div class="pelamar-view">

    

    <div class="row">
        <div class="col-sm-8">
        <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-4">
<?php if(Yii::$app->user->identity->profilname == $hrd->karyawan): ?>
    <?php if($model->status === 'Interview HRD' || $model->status === 'Interview Pimpinan'): ?>
        <?= Html::a('Diterima', ['accept', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Pelamar diterima ?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Ditolak', ['decline', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Pelamar ditolak ?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>        
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>   
<?php endif ?> 
        </div>
    </div>


    <section class="content"><div class="nav-tabs-custom tab-success">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#detail" data-toggle="tab">Data Diri</a></li>
            <li><a href="#jadwal" data-toggle="tab">Jadwal Interview & Hasil</a></li>
            
        </ul>

    <div class="tab-content">
        <div class="active tab-pane" id="detail">
            <div class="table-responsive">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama',
            'email',
            'no_hp',
            'alamat',
            'gender',
            'agama',
            ['attribute'=>'tempat_lahir','value'=>$model->tempat_lahir.','.date('d/m/Y',strtotime($model->tanggal_lahir))],
            'pendidikan',
            'status_nikah',
            ['attribute'=>'posisi','value'=>$model->jobtitle->posisi],
            ['attribute'=>'departemen','value'=>$model->getdepart->departemen],
            'status',
            'ulasan',
        ],
    ]) ?>
            </div>
        </div>

        <div class="tab-pane" id="jadwal">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                <?php if(Yii::$app->user->identity->profilname == $hrd->karyawan): ?>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#jadwal-pelamar">Tambah Jadwal</button>
                <?php endif ?>
                    <tr>
                        <th>Jadwal</th>
                        <th>Jenis</th>
                        <th>Kehadiran</th>
                    </tr>
                <?php foreach ($data as $show ):?>
                    <tr>
                        <td> <?php echo date("d/m/Y", strtotime($show['tanggal'])); ?> </td>
                        <td> <?php echo $show['jenis']; ?> </td>
                        <td> <?php echo $show['kehadiran']; ?> </td>
                    </tr>
                <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>

    </div>    
    </section>

    <div class="modal fade" id="jadwal-pelamar"><div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Jadwal Interview</b></h4>          
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($formjadwal, 'tanggal')->widget(DatePicker::className(),[
                            'clientOptions'=>[
                            'autoclose'=>true,
                            'format'=>'dd-mm-yyyy',
                            'orientation'=>'bottom',
                            ]
                        ])?>
                    </div>
                        <div class="col-sm-6">
                            <?= $form->field($formjadwal, 'jenis')->dropDownList(['Interview HRD'=>'Interview HRD','Interview Pimpinan'=>'Interview Pimpinan'],['prompt'=>'--Jenis Interview--']) ?>
                        </div>
                </div>
                <div class="form-group">
                     <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        </div>
    </div>



</div>
