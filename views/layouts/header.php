<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
$session = Yii::$app->session;
$session->open();

?>

<header class="main-header">

    <a href="<?php echo Yii::$app->homeUrl ?>" class="logo"><span class="logo-mini">APP</span><span class="logo-lg"><?= Html::img('@web/img/monita3.png', ['alt'=>'some', 'class'=>'img-responsive','width' => '130px','style' => 'margin-top:-7px;']);?></span></a>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= $session['user']['username'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <small class="text-muted">Last login : <?= $session['user']['last_login'] ?></small>

                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
