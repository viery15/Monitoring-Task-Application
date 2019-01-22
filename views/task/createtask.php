<?php
/**
 * Created by PhpStorm.
 * User: VIERY
 * Date: 1/17/2019
 * Time: 2:08 PM
 */
Use yii\helpers\Html;
use app\models\Task;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
$model = new Task();
//print_r($param);
?>

<div class="task-create">
    <?= $this->render('_formtask', [
        'model' => $model,
    ]) ?>
</div>