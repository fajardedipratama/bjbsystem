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

$this->title = 'Indlude Tax -> DPP';
?>
<div class="calculator-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-6">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box box-success"><div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'input_value')->textInput(['type' => 'double']) ?>
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
            $include = $_GET['value'];
            $dpp = ($_GET['value']*100)/111.3;
            $ppn = ($dpp*11)/100;
            $pph = round_up(($dpp*0.3)/100,2);
        ?>
            <div class="box box-success"><div class="box-body">
                Target Include : <?= $include  ?>
                <table class="table table-bordered">
                    <tr>
                      <th>Komponen</th>
                      <th>Persentase</th>
                      <th>Nilai</th>
                    </tr>
                    <tr>
                      <td>DPP</td>
                      <td></td>
                      <td><?= Yii::$app->formatter->asCurrency($dpp); ?></td>
                    </tr>
                    <tr>
                      <td>PPN</td>
                      <td>11%</td>
                      <td><?= Yii::$app->formatter->asCurrency($ppn); ?></td>
                    </tr>
                    <tr>
                      <td>PPH22</td>
                      <td>0,3%</td>
                      <td><?= Yii::$app->formatter->asCurrency($pph); ?></td>
                    </tr>
                    <tr>
                        <th colspan="2">Total</th>
                        <th><?= Yii::$app->formatter->asCurrency($dpp+$ppn+$pph) ?></th>
                    </tr>
                </table>
            </div></div>
        <?php endif; ?>
        </div>
    </div>

</div>
