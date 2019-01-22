<?php

use yii\helpers\Html;
use app\models\Task;


/* @var $this yii\web\View */
/* @var $model app\models\Task */
$model->update_at = date('Y-m-d H:i:s');
?>

<div class="task-update">
    <?= $this->render('_formreq', [
        'model' => $model,
    ]) ?>

</div>
