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
            'date_from',
            'date_to',
            'user_from',
            'user_to',
            'remark',
            'description',
            'status',
            'create_at',
            'update_at',
        ],
    ]) ?>

</div>
