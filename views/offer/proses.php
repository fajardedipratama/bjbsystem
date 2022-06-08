<?php
use app\models\City;
use app\models\Karyawan;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\OfferNumber;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OfferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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

$this->title = 'Penawaran Proses';

?>
<div class="offer-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <div class="box"><div class="box-body"><div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'header'=>'No Surat','value'=>'no_surat',
              'headerOptions'=>['style'=>'width:8%'],
            ],
            [
              'header'=>'Perusahaan','value'=>'perusahaan',
              'format' => 'raw',
              'value'=>function($data){
                if(!empty($data->catatan)){
                  return $data->customer->perusahaan.' <i class="fa fa-fw fa-info-circle" title="'.$data->catatan.'"></i>';
                }else{
                  return $data->customer->perusahaan;
                }
              },
            ],
            [
              'header'=>'Lokasi',
              'value'=>function($data){
                $query = City::find()->where(['id'=>$data->customer->lokasi])->one();
                return $query['kota'];
              },
              'visible' => Yii::$app->user->identity->type != 'Administrator'
            ],
            [
              'header'=>'SendToWA',
              'format'=>'raw',
              'headerOptions'=>['style'=>'width:8%'],
              'value'=>function($data){
                if($data->send_wa === 1){
                  return '<i class="fa fa-fw fa-check"></i>';
                }else{
                  return ' ';
                }
              }
            ],
            [
              'header'=>'Email',
              'format' => 'email',
              'value'=>'customer.email',
            ],
            [
              'attribute'=>'sales',
              'value' => 'karyawan.nama_pendek',
              'filter'=>\kartik\select2\Select2::widget([
                'model'=>$searchModel,'attribute'=>'sales','data'=>$sales,
                'options'=>['placeholder'=>'Sales'],'pluginOptions'=>['allowClear'=>true]
              ]),
              'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=>['style'=>'width:8%'],
              'header'=>'Status',
              'template' => '{terkirim} {gagal}',
                'buttons'=>
                [
                    'terkirim'=>function($url,$model)
                    {
                    return Html::a
                     (
                        '<span class="glyphicon glyphicon-ok"></span>',
                        ["offer/success",'id'=>$model->id],
                        ['title' => Yii::t('app', 'Terkirim')],
                     );
                    },
                    'gagal'=>function($url,$model)
                    {
                    return Html::a
                     (
                        '<span class="glyphicon glyphicon-remove"></span>',
                        ["offer/failed",'id'=>$model->id],
                        ['title' => Yii::t('app', 'Gagal')],
                     );
                    },
                ],
                'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=>['style'=>'width:8%'],
              'header'=>'Aksi',
              'template' => '{view} {cetak}',
              'buttons'=>
              [
                'view'=>function($url,$model)
                {
                  return Html::a
                  (
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    ["offer/view",'id'=>$model->id],
                    ['title' => Yii::t('app', 'View'),'target'=>'_blank'],
                  );
                },
                'cetak'=>function($url,$model)
                {
                  $city = City::find()->where(['id'=>$model->customer->lokasi])->one();
                  $setting = OfferNumber::find()->where(['id'=>1])->one();
                  
                  $min_price = $setting->min_price;
                  $oat = $city->oat;
                  $termin = termin_value($model->top);
                  $price = $model->harga;

                  if($price-$termin-$oat >= $min_price){
                    return Html::a
                    (
                      '<span class="glyphicon glyphicon-print"></span>',
                      ["offer/print",'id'=>$model->id],
                      ['title' => Yii::t('app', 'Print'),'target'=>'_blank'],
                    );
                  }
                },
              ],
              'visible' => Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
            ],
        ],
    ]); ?>
  </div></div></div>

</div>
