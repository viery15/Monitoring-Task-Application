<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
?>
<div class="task-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_from',
            'user_to',
            'remark',
            'status',
            'description',
            'date_from',
            'date_to',
            'update_at',
            'create_at',
        ],
    ]) ?>

</div>
