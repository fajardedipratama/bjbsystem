<?php
use yii\helpers\Html;
use app\models\Karyawan;
use app\models\Dailyreport;
use app\models\Customer;

$karyawan = Karyawan::find()->where(['id'=>Yii::$app->user->identity->profilname])->one();

$callback = Dailyreport::find()->where(['sales'=>Yii::$app->user->identity->profilname])->andWhere(['pengingat'=>date('Y-m-d')])->all();
/* @var $this \yii\web\View */
/* @var $content string */

?>

<header class="main-header" style="position: fixed;">

    <?= Html::a('<span class="logo-mini"><b>BJB</b></span><span class="logo-lg"><b>BJB</b>-APP</span>', 'index.php?r=dashboard', ['class' => 'logo']) ?>

    <nav class="navbar navbar-fixed-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu" title="Kalkulator">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-fw fa-calculator"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><a href="index.php?r=calculator/to_include" target="_blank"><i class="fa fa-calculator"></i> DPP -> Include Tax</a></li>
                        <li class="header"><a href="index.php?r=calculator/to_dpp" target="_blank"><i class="fa fa-calculator"></i> Include Tax -> DPP</a></li>
                        <li class="header"><a href="index.php?r=calculator/cashback" target="_blank"><i class="fa fa-calculator"></i> Cashback</a></li>
                    </ul>
                </li>
                <?php if(Yii::$app->user->identity->type == 'Marketing'): ?>
                <li class="dropdown notifications-menu" title="Hubungi Balik">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-phone-alt"></i>
                        <span class="label label-danger">!</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><b>Hubungi Balik Hari Ini</b></li>
                        <li>
                            <ul class="menu">
                            <?php foreach($callback as $notif): ?>
                            <?php $cust=Customer::find()->where(['id'=>$notif['perusahaan']])->one() ?>
                            <?php if(($cust['expired'] >= date('Y-m-d') || $cust['expired'] == NULL) && $cust['verified'] != 'no'): ?>
                                <li>
                                    <a href="index.php?r=selfcustomer/view&id=<?= $cust['id'] ?>">
                                        <i class="fa fa-phone text-aqua"></i> <?= $cust['perusahaan'] ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php endforeach ?>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif ?>
                

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span class="hidden-xs"> <?= $karyawan['nama'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="photos/employee/<?= $karyawan['foto_karyawan'] ?>" class="img-circle" alt="User Image"/>
                            <p>
                                <?= $karyawan['nama'] ?>
                                <small>@<?= Yii::$app->user->identity->username ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="index.php?r=karyawan/view&id=<?= Yii::$app->user->identity->profilname ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a('Sign out',['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
