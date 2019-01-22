<?php

use yii\helpers\Html;
use app\models\Task;


/* @var $this yii\web\View */
/* @var $model app\models\Task */
$model = new Task();
$model->create_at = date('m-d-Y H:i:s');
?>

<div class="task-create">
    <?= $this->render('_formreq', [
        'model' => $model,
    ]) ?>
</div>
