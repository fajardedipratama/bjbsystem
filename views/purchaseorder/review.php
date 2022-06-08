<?php
use app\models\PurchaseOrder;
use app\models\Karyawan;
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Review';

?>
<div class="purchase-order-review">

    <h1><?= Html::a('<i class="glyphicon glyphicon-chevron-left"></i>', ['index'], ['class' => 'btn btn-success']) ?> <?= Html::encode($this->title) ?></h1>


<div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'attribute'=>'perusahaan',
              'format'=>'raw',
              'value'=>function($data){
                if($data->eksternal){
                  return '<i class="fa fa-fw fa-user-secret" title="Titipan"></i>'.$data->customer->perusahaan;
                }else{
                  return $data->customer->perusahaan;
                }
                //return $data->customer->perusahaan;
              },
              'filter'=>\kartik\select2\Select2::widget([
                'model'=>$searchModel,'attribute'=>'perusahaan','data'=>$customer,
                'options'=>['placeholder'=>'Perusahaan'],'pluginOptions'=>['allowClear'=>true]
              ])
            ],
            [
              'header'=>'Sales Terakhir',
              'value'=>function($data){
                $purchase = PurchaseOrder::find()->where(['perusahaan'=>$data->perusahaan])->orderBy(['id'=>SORT_DESC])->one();
                $sales = Karyawan::find()->where(['id'=>$purchase->sales])->one();
                return $sales->nama_pendek;
              },
              'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
            ],
            [
              'header'=>'Aksi','class' => 'yii\grid\ActionColumn','template'=>'{view}',
              'buttons'=>
              [
                'view'=>function($url,$model)
                {
                  return Html::a
                  (
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                        ["reviewdetail",'id'=>$model->perusahaan],
                        ['title' => Yii::t('app', 'View')],
                  );
                },
              ],
            ],
        ],
    ]); ?>
</div></div></div>

</div>
