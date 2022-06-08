<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
function round_up($number, $precision = 2)
{
    $fig = pow(10, $precision);
    return (ceil($number * $fig) / $fig);
}
$this->title = 'Cashback';
?>
<div class="calculator-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-6">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box box-success"><div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'input_value')->textInput(['type' => 'double']) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'volume')->textInput(['type' => 'number','min'=>1000]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'tax')->dropDownList(['PPN'=>'PPN','Non PPN'=>'Non PPN']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Hitung', ['class' => 'btn btn-success']) ?>
                </div>
            </div></div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-sm-6">
        <?php if(isset($_GET['value'])): ?>
        <?php 
            $cashback = $_GET['value'];
            $ppn = ($_GET['value']*11)/100;
            $non_ppn = ($_GET['value']*5)/100;
            $pph = round_up((($cashback-$ppn)*25)/100,2);
        ?>
            <div class="box box-success"><div class="box-body">
                <table class="table table-bordered">
                    <tr>
                      <th>Komponen</th>
                      <th>Persentase</th>
                      <th>Nilai</th>
                    </tr>
                    <tr>
                      <td>Cashback</td>
                      <td></td>
                      <td><?= Yii::$app->formatter->asCurrency($cashback); ?></td>
                    </tr>
                <?php if($_GET['tax']==='PPN'): ?>
                <?php $include = $cashback-$ppn-$pph; ?>
                    <tr>
                      <td>PPN</td>
                      <td>11%</td>
                      <td><?= Yii::$app->formatter->asCurrency($ppn); ?></td>
                    </tr>
                    <tr>
                      <td>PPH21</td>
                      <td>25%</td>
                      <td><?= Yii::$app->formatter->asCurrency($pph); ?></td>
                    </tr>
                <?php else: ?>
                <?php $include = $cashback-$non_ppn; ?>
                    <tr>
                      <td>Potongan</td>
                      <td>5%</td>
                      <td><?= Yii::$app->formatter->asCurrency($non_ppn); ?></td>
                    </tr>
                <?php endif; ?>
                    <tr>
                        <th colspan="2">Total</th>
                        <th><?= Yii::$app->formatter->asCurrency($include) ?></th>
                    </tr>
                    <tr>
                      <td colspan="2">Volume (l)</td>
                      <td><?= $_GET['volume']; ?></td>
                    </tr>
                    <tr>
                        <th colspan="2">Total</th>
                        <th><?= Yii::$app->formatter->asCurrency($include*$_GET['volume']) ?></th>
                    </tr>
                </table>
            </div></div>
        <?php endif; ?>
        </div>
    </div>

</div>
