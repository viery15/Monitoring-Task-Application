<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
?>
<div class="task-view">
    <?php
        $timestamp = strtotime($model->create_at);
        $date_create = date('d M Y h:i A', $timestamp);

        $timestamp2 = strtotime($model->update_at);
        $date_update = date('d M Y h:i A', $timestamp2);

        $timestamp3 = strtotime($model->date_from);
        $date_from = date('d M Y ', $timestamp3);

        $timestamp4 = strtotime($model->date_to);
        $date_to = date('d M Y ', $timestamp4);
    ?>

 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

//           'id',
            [
                'label'  => 'Date From',
                'value'  => $date_from,
            ],
            [
                'label'  => 'Date To',
                'value'  => $date_to,
            ],
            'user_from',
            'user_to',
            'remark',
            'description',
            'status',
            [
                'label'  => 'Created At',
                'value'  => $date_create,
            ],
            [
                'label'  => 'Updated At',
                'value'  => $date_update,
            ],
        ],
    ]) ?>

</div>
