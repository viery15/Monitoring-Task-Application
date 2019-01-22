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
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'user_from',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_to',
    ],
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

        'template' => ' {delete}{request}{update}{view}',
//
        'buttons' => [
            'request' => function ($url, $model, $key) {
//                if (Yii::$app->user->identity->id != $model->id) {
                if($model->status == 'Rejected') {
                    return Html::a('<span class="glyphicon glyphicon-repeat">&nbsp;</span>', Url::to(['task/request', 'id' => $model->id]),
                        [
                            'title' => Yii::t('app', 'Request'),
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
            'delete' => function ($url, $model, $key) {
//                if (Yii::$app->user->identity->id != $model->id) {
                if($model->status == 'Pending') {
                    return Html::a('<span class="glyphicon glyphicon-trash">&nbsp;</span>', Url::to(['task/delete', 'id' => $model->id]),
                        [
                            'role'=>'modal-remote',
                            'title' => Yii::t('app', 'Delete'),
                            'data-pjax' => '1',
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-toggle'=>'tooltip',
                            'data-confirm-title'=>'Are you sure?',
                            'data-confirm-message'=>'Are you sure want to delete this item',
                        ]
                    );
                }
            },
            'update' => function ($url, $model, $key) {
//                if (Yii::$app->user->identity->id != $model->id) {
                if($model->status == 'Pending') {
                    return Html::a('<span class="glyphicon glyphicon-pencil">&nbsp;</span>', Url::to(['task/update', 'id' => $model->id]),
                        [
                            'role'=>'modal-remote',
                            'title'=>'Update',
                            'data-toggle'=>'tooltip'
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