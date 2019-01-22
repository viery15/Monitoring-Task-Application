<?php

use yii\helpers\Html;
use app\models\Task;


/* @var $this yii\web\View */
/* @var $model app\models\Task */
$model = new Task();
?>

<div class="task-update">
    <?= $this->render('_formtask', [
        'model' => $model,
        'id' => $id
    ]) ?>
</div>
