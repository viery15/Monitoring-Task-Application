<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
$session = Yii::$app->session;
$session->open();

?><aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $session['user']['username'] ?></p>
                <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
            </div>
        </div>
        <?php if($session['user']['role'] == 'admin') { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'MONITA MENU', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['site/dashboard']],
                    // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Task',
                        'icon' => 'tasks',
                        'url' => '#',
                        'items' => [
                            ['label' => 'My Request', 'icon' => 'send', 'url' => ['task/myrequest'],],
                            ['label' => 'My Task', 'icon' => 'list-alt', 'url' => ['task/mytask'],],
                        ],
                    ],
                    [
                        'label' => 'Monitoring',
                        'icon' => 'th-list',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Employee Task', 'icon' => 'list-alt', 'url' => ['task/monitoring'],],
                        ],
                    ],
                        ['label' => 'User', 'icon' => 'user', 'url' => ['user/']],
                ],
            ]
        ) ?> <?php } ?>

        <?php if($session['user']['role'] == 'user') { ?>
            <?= dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        ['label' => 'Task Monitoring', 'options' => ['class' => 'header']],
                        ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['site/dashboard']],
                        // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                        [
                            'label' => 'Task',
                            'icon' => 'tasks',
                            'url' => '#',
                            'items' => [
                                ['label' => 'My Request', 'icon' => 'send', 'url' => ['task/myrequest'],],
                                ['label' => 'My Task', 'icon' => 'list-alt', 'url' => ['task/mytask'],],
                            ],
                        ],
                        [
                            'label' => 'Monitoring',
                            'icon' => 'th-list',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Employee Task', 'icon' => 'list-alt', 'url' => ['task/monitoring'],],
                            ],
                        ],

//                        ['label' => 'User', 'icon' => 'user', 'url' => ['user/index']],

                    ],
                ]
            ) ?> <?php } ?>
    </section>
</aside>