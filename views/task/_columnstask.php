<?php
use yii\helpers\Url;
use yii\helpers\Html;


return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_from',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'user_to',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'remark',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
    ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_from',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_to',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'update_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'create_at',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '100px',
        'template' => ' {done}{approve}{reject}{view}',

        'buttons' => [
            'done' => function ($url, $model, $key) {
//                if (Yii::$app->user->identity->id != $model->id) {
                if($model->status == 'Approved') {
                    return Html::a('<span class="glyphicon glyphicon-check">&nbsp;</span>', Url::to(['task/done', 'id' => $model->id]),
                        [
                            'title' => Yii::t('app', 'Done'),
                            'data-pjax' => '1',
                            'data' => [
                                'method' => 'post',
                                'confirm' => Yii::t('app', 'Are You Sure ?'),
//                                'pjax' => 1,
                            ],
                        ]
                    );
                }
            },

            'approve' => function ($url, $model, $key) {
//                if (Yii::$app->user->identity->id != $model->id) {
                if($model->status == 'Pending') {
                    return Html::a('<span class="glyphicon glyphicon-ok">&nbsp;</span>', Url::to(['task/approve', 'id' => $model->id]),
                        [
                            'title' => Yii::t('app', 'Approve'),
                            'data-pjax' => '1',
                            'data' => [
                                'method' => 'post',
                                'confirm' => Yii::t('app', 'Are You Sure ?'),
                                'pjax' => 1,
                            ],
                        ]
                    );
                }
            },
            'reject' => function ($url, $model, $key) {
//                if (Yii::$app->user->identity->id != $model->id) {
                if($model->status == 'Pending') {
                    return Html::a('<span class="glyphicon glyphicon-remove">&nbsp;</span>', Url::to(['task/reject', 'id' => $model->id]),
                        [
                            'title' => Yii::t('app', 'Reject'),
                            'data-pjax' => '1',
                            'data' => [
                                'method' => 'post',
                                'confirm' => Yii::t('app', 'Are You Sure ?'),
//                                'pjax' => 1,
                            ],
                        ]
                    );
                }
            },

        ],
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Done',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],
];   