<?php 
use app\models\Karyawan;
use app\models\Jobtitle;

$karyawan = Karyawan::find()->where(['id'=>Yii::$app->user->identity->profilname])->one();
$jobtitle = Jobtitle::find()->where(['id'=>$karyawan['posisi']])->one();

?>
<aside class="main-sidebar" style="position: fixed;">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="photos/employee/<?= $karyawan['foto_karyawan'] ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $karyawan['nama'] ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> <?= $jobtitle['posisi'] ?></a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Dashboard', 'icon' => 'bar-chart', 'url' => ['/dashboard'], 'active'=>in_array(\Yii::$app->controller->id,['dashboard'])],
                    [
                        'label' => 'Manajemen SDM',
                        'icon' => 'user-secret',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Data Karyawan', 'icon' => 'users', 'url' => ['/karyawan'], 'active'=>in_array(\Yii::$app->controller->id,['karyawan','exkaryawan'])],
                            ['label' => 'Jabatan', 'icon' => 'briefcase', 'url' => ['/jobtitle'], 'active'=>in_array(\Yii::$app->controller->id,['jobtitle'])],
                            ['label' => 'Departemen', 'icon' => 'building', 'url' => ['/departemen'], 'active'=>in_array(\Yii::$app->controller->id,['departemen'])],
                            ['label' => 'Data Broker', 'icon' => 'user-secret', 'url' => ['/broker'], 'active'=>in_array(\Yii::$app->controller->id,['broker'])],
                            ['label' => '.'],
                            [
                                'label' => 'User Login', 'icon' => 'key', 'url' => ['/users'], 'active'=>in_array(\Yii::$app->controller->id,['users']),
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->type == 'Administrator'
                            ],
                        ],
                        'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
                    ],
                    [
                        'label' => 'Marketing',
                        'icon' => 'line-chart',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Data Sales', 'icon' => 'user-secret', 'url' => ['/selfcustomer'], 'active'=>in_array(\Yii::$app->controller->id,['selfcustomer']),
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->type == 'Marketing'
                            ],
                            ['label' => 'Data Perusahaan', 'icon' => 'institution', 'url' => ['/customer'], 'active'=>in_array(\Yii::$app->controller->id,['customer','expired'])],
                            [
                                'label' => 'Data Penawaran', 'icon' => 'paste', 'url' => '#',
                                'items' => [
                                    ['label' => 'Selesai', 'icon' => 'check-square-o', 'url' => ['/offerfinish'], 'active'=>in_array(\Yii::$app->controller->id,['offerfinish'])],
                                    ['label' => 'Proses', 'icon' => 'spinner', 'url' => ['/offerproses'], 'active'=>in_array(\Yii::$app->controller->id,['offerproses'])],
                                    ['label' => 'Pending', 'icon' => 'clock-o', 'url' => ['/offer'], 'active'=>in_array(\Yii::$app->controller->id,['offer'])],
                                ],
                            ],
                            ['label' => 'Data PO', 'icon' => 'cart-plus', 'url' => ['/purchaseorder'], 'active'=>in_array(\Yii::$app->controller->id,['purchaseorder'])],
                            [
                                'label' => 'Kirim Dok/Sampel', 'icon' => 'flask', 'url' => ['/sendsample'], 'active'=>in_array(\Yii::$app->controller->id,['sendsample']),
                            ],
                            ['label' => '.'],
                            ['label' => 'Aktivitas Sales', 'icon' => 'table', 'url' => ['/dailyreport','waktu'=>date('Y-m-d')], 'active'=>in_array(\Yii::$app->controller->id,['dailyreport'])],
                            [
                                'label' => 'Statistik Sales', 'icon' => 'table', 'url' => ['/statistic'], 'active'=>in_array(\Yii::$app->controller->id,['statistic']),
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
                            ],
                            ['label' => '.'],
                            [
                                'label' => 'Kabupaten/Kota', 'icon' => 'map-marker', 'url' => ['/city'], 'active'=>in_array(\Yii::$app->controller->id,['city']),
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
                            ],
                            [
                                'label' => 'Data Supir', 'icon' => 'truck', 'url' => ['/drivers'], 'active'=>in_array(\Yii::$app->controller->id,['drivers']),
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->type == 'Administrator' || Yii::$app->user->identity->type == 'Manajemen'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Finance',
                        'icon' => 'money',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Kas', 'icon' => 'book', 'url' => ['/kas'], 'active'=>in_array(\Yii::$app->controller->id,['kas','kasakun','kasdetail'])],
                        ],
                        'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->type == 'Administrator'
                    ],

                    [
                        'label' => 'Rekrutmen',
                        'icon' => 'envelope',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Data Pelamar', 'icon' => 'users', 'url' => ['/pelamar'], 'active'=>in_array(\Yii::$app->controller->id,['pelamar'])],
                            ['label' => 'Jadwal Interview', 'icon' => 'calendar', 'url' => ['/jadwal'], 'active'=>in_array(\Yii::$app->controller->id,['kas','kasakun','kasdetail'])],
                            ['label' => 'Setting User', 'icon' => 'gear', 'url' => ['/setting'], 'active'=>in_array(\Yii::$app->controller->id,['kas','kasakun','kasdetail'])],
                        ],
                    ],

                ],
            ]
        ) ?>

    </section>

</aside>
