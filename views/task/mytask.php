<?php
/**
 * Created by PhpStorm.
 * User: VIERY
 * Date: 1/13/2019
 * Time: 4:39 PM
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Tasks';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="task-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columnstask.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                        ['role'=>'modal-remote','title'=> 'Create new Tasks','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                        ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Tasks listing',
//                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
//                'after'=>BulkButtonWidget::widget([
//                        'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
//                            ["bulk-delete"] ,
//                            [
//                                "class"=>"btn btn-danger btn-xs",
//                                'role'=>'modal-remote-bulk',
//                                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
//                                'data-request-method'=>'post',
//                                'data-confirm-title'=>'Are you sure?',
//                                'data-confirm-message'=>'Are you sure want to delete this item'
//                            ]),
//                    ]).
                    '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php
Modal::begin([
    'header' => '<h4 id="head-comment"></h4>',
    'id' => 'comment-modal',
    'size' => 'modal-lg',
]);
?>
<div id="comment-content"></div>
<?php
Modal::end();
?>

<script type="text/javascript" language="JavaScript">
    $(".btn-comment").click(function(){
        var id = $(this).attr("id");
        $("#head-comment").text('Comment Task #'+id);
        $.ajax({
            url :  "<?php echo Yii::$app->request->baseUrl. '/task/comment' ?>",
            type : 'post',
            data : {id:id},
            success : function(a) {
                $('#comment-content').html(a);
                $('#comment-modal').modal('show');
            }
        });
    });
</script>