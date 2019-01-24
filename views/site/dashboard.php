<?php
/**
 * Created by PhpStorm.
 * User: VIERY
 * Date: 1/15/2019
 * Time: 9:01 AM
 */
use yii\helpers\Url;
use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
use yii\bootstrap\Modal;
use app\models\Task;
use yii\web\JsExpression;
use app\assets\HighChartsAsset;

$session = Yii::$app->session;
$session->open();

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>


<style type="text/css">
    .timeline {
        list-style: none;
        padding: 20px 0 20px;
        position: relative;
    }
    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #606060;
        left: 50%;
        margin-left: -1.5px;
    }
    .timeline > li {
        margin-bottom: 20px;
        position: relative;
    }
    .timeline > li:before,
    .timeline > li:after {
        content: " ";
        display: table;
    }
    .timeline > li:after {
        clear: both;
    }
    .timeline > li:before,
    .timeline > li:after {
        content: " ";
        display: table;
    }
    .timeline > li:after {
        clear: both;
    }
    .timeline > li > .timeline-panel {
        width: 46%;
        margin: 1.5%;
        float: left;
        border: 1px solid #d4d4d4;
        border-radius: 2px;
        padding: 20px;
        position: relative;
        -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    }

    .timeline > li > .timeline-panel2 {
        width: 46%;
        margin: 1.5%;
        float: left;
        /*border: 1px solid #d4d4d4;*/
        border-radius: 2px;
        padding: 20px;
        position: relative;
        /*-webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);*/
        /*box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);*/
    }
    .timeline > li > .timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #ccc;
        border-right: 0 solid #ccc;
        border-bottom: 15px solid transparent;
        content: " ";
    }
    .timeline > li > .timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #fff;
        border-right: 0 solid #fff;
        border-bottom: 14px solid transparent;
        content: " ";
    }
    .timeline > li > .timeline-badge {
        color: #fff;
        width: 14px;
        height: 14px;
        line-height: 10px;
        font-size: 0.7em;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -5px;
        background-color: #999999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }
    .timeline > li.timeline-inverted > .timeline-panel {
        float: right;
        /*margin-right: 4%;*/
        /*width: 42%;*/
    }
    .timeline > li.timeline-inverted > .timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto;
    }
    .timeline > li.timeline-inverted > .timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }
    .timeline-badge.primary {
        background-color: #2e6da4 !important;
    }
    .timeline-badge.success {
        background-color: #3f903f !important;
    }
    .timeline-badge.warning {
        background-color: #f0ad4e !important;
    }
    .timeline-badge.danger {
        background-color: #d9534f !important;
    }
    .timeline-badge.info {
        background-color: #5bc0de !important;
    }
    .timeline-title {
        margin-top: 0;
        color: inherit;
    }
    .timeline-body > p,
    .timeline-body > ul {
        margin-bottom: 0;
    }
    .timeline-body > p + p {
        margin-top: 5px;
    }
</style>

<div class="row" style="background-color: white;margin: 0px;padding-bottom: 1%">
    <div class="col-md-6">
        <h3 style="text-align: center">My Task</h3>
        <div id="canvas-holder">
            <div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
    </div>
    <div class="col-md-6">
        <h3 style="text-align: center">My Request</h3>
        <div id="canvas-holder">
            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>

    </div>
</div>

<div style="background-color: white">
    <div class="page-header" style="padding: 5px;margin-left: 1.5%">
        <h1 id="timeline">My Timeline</h1>
    </div>
    <ul class="timeline">
        <li style="margin-top: -4%" class="timeline">
            <div class="timeline-badge primary"><i class="glyphicon glyphicon-off"></i></div>
            <div class="timeline-panel2">
                <div class="timeline-heading" style="text-align: center">
                    <h2 class="timeline-title">My Task</h2>
                </div>
                <div class="timeline-body" style="text-align: center">
                    <br>
                    <!--                        <button type="button" class="btn btn-primary btn-sm">-->
                    <!--                            <i class="glyphicon glyphicon-plus"></i> New Request-->
                    <!--                        </button>-->
                    <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Create Task', [
                        'value' => Yii::$app->urlManager->createUrl('/task/create'),
                        'class' => 'btn btn-primary',
                        'id' => 'btntask',
                        'data-toggle'=> 'modal',
                        'data-target'=> 'create-task',
                    ]) ?>
                </div>
            </div>
            <div class="timeline-panel2">
                <div class="timeline-heading" style="text-align: center">
                    <h2 class="timeline-title">My Request</h2>
                </div>
                <div class="timeline-body" style="text-align: center">
                    <br>
                    <!--                        <button type="button" class="btn btn-primary btn-sm">-->
                    <!--                            <i class="glyphicon glyphicon-plus"></i> New Request-->
                    <!--                        </button>-->
                    <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Create Request', [
                        'value' => Yii::$app->urlManager->createUrl('/task/create'),
                        'class' => 'btn btn-primary',
                        'id' => 'btnrequest',
                        'data-toggle'=> 'modal',
                        'data-target'=> 'create-request',
                    ]) ?>
                </div>
            </div>
        </li>
        <hr>

        <?php
        $idx = 0;
        foreach($data as $row) {

            if ($row['user_from'] == $session['user']['username']) {
                ?>
                <li class="timeline-inverted">
                <?php
            }
            else {
                ?>
                <li>
            <?php } ?>

            <?php
            if ($row['status'] == 'Pending') {
                ?>
                <div class="timeline-badge warning"><i class="glyphicon glyphicon-thumbs-up"></i></div>
                <?php
            }
            ?>
            <?php
            if ($row['status'] == 'Done') {
                ?>
                <div class="timeline-badge success"><i class="glyphicon glyphicon-thumbs-up"></i></div>
                <?php
            }
            ?>
            <?php
            if ($row['status'] == 'Rejected') {
                ?>
                <div class="timeline-badge danger"><i class="glyphicon glyphicon-thumbs-up"></i></div>
                <?php
            }
            ?>
            <?php
            if ($row['status'] == 'Approved') {
                ?>
                <div class="timeline-badge info"><i class="glyphicon glyphicon-thumbs-up"></i></div>
                <?php
            }
            ?>


            <div class="timeline-panel timeline-inverted" >
                <div class="timeline-heading">
                    <h4 class="timeline-title"><?= $row['remark'] ?></h4>
                    <?php
                    if ($row['user_from'] == $session['user']['username']) {
                    ?>
                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?= $row['update_at'] ?> <br>To <b style="color: blue"><?= $row['user_to'] ?></b>
                            <?php
                            }
                            else {
                            ?>
                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?= $row['update_at'] ?> <br>From <b style="color: blue"><?= $row['user_from'] ?></b>
                            <?php } ?>
                            <?php
                            if ($row['status'] == 'Pending') {
                                ?>
                                status : <span style="color: darkgoldenrod"><b><?= $row['status'] ?></b></span>
                                <?php
                            }
                            ?>
                            <?php
                            if ($row['status'] == 'Done') {
                                ?>
                                status : <span style="color: darkgreen"><b><?= $row['status'] ?></b></span>
                                <?php
                            }
                            ?>
                            <?php
                            if ($row['status'] == 'Rejected') {
                                ?>
                                status : <span style="color: red"><b><?= $row['status'] ?></b></span>
                                <?php
                            }
                            ?>
                            <?php
                            if ($row['status'] == 'Approved') {
                            ?>
                            status : <b style="color: dodgerblue"><b><?= $row['status'] ?></b></span>
                                <?php
                                }
                                ?>


                            </b></small></p>
                </div>
                <div class="timeline-body">
                    <p><?= $row['description'] ?></p>
                    <hr>
                    <div class="btn-group">

                        <?php
                        if ($row['status'] == 'Pending' && $row['user_from'] != $session['user']['username']) {

                            ?>
                            <!--                        <button type="button" class="btn btn-primary btn-sm">-->
                            <!--                            <i class="glyphicon glyphicon-ok"></i> Approve-->
                            <!--                        </button>-->

                            <div class="row">
                                <div class="col-md-3 col-sm-3" style="margin: 4px">
                                    <?= Html::a('<span class="glyphicon glyphicon-ok">Approve</span>', Url::to(['task/approve', 'id' => $row['id']]),
                                        [
                                            'title' => Yii::t('app', 'Approve'),
                                            'data-pjax' => '1',
                                            'class' => 'btn btn-success',
                                            'data-toggle'=> 'modal',
                                            'data-target'=> 'modal-approve',
                                            'id' => 'BtnModalId',
                                            'data' => [
                                                'method' => 'post',
                                                'confirm' => Yii::t('app', 'Are You Sure ?'),
                                                'pjax' => 1,
                                            ],
                                        ]
                                    );
                                    ?>
                                </div>
                                <div class="col-md-4 col-sm-4" style="margin: 4px">
                                    <?=
                                    Html::a('<span class="glyphicon glyphicon-saved">Reject</span>', Url::to(['task/reject', 'id' => $row['id']]),
                                        [
                                            'title' => Yii::t('app', 'Reject'),
                                            'data-pjax' => '1',
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'method' => 'post',
                                                'confirm' => Yii::t('app', 'Are You Sure ?'),
                                                'pjax' => 1,
                                            ],
                                        ]
                                    );
                                    ?>
                                </div>
                                <div class="col-md-4 col-sm-4" style="margin: 2px">
                                    <?=
                                    Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                                        [
                                            'title' => Yii::t('app', 'Comment'),
                                            'data-pjax' => '1',
                                            'class' => 'btn btn-success btn-comment',
                                            'id' => $row['id']
                                        ]
                                    );
                                    ?>
                                </div>
                            </div>
                            <!--                        <button type="button" class="btn btn-danger btn-sm">-->
                            <!--                            <i class="glyphicon glyphicon-remove"></i> Reject-->
                            <!--                        </button>-->

                        <?php } ?>

                        <?php
                        if ($row['status'] == 'Approved' && $row['user_from'] != $session['user']['username']) {

                            ?>
                            <!--                            <button type="button" class="btn btn-success btn-sm">-->
                            <!--                                <i class="glyphicon glyphicon-saved"></i> Done-->
                            <!--                            </button>-->
                       <div class="row">
                            <div class="col-md-4 col-sm-4" style="margin: 2px">
                            <?=
                            Html::a('<span class="glyphicon glyphicon-saved">Done</span>', Url::to(['task/done', 'id' => $row['id']]),
                                [
                                    'title' => Yii::t('app', 'Done'),
                                    'data-pjax' => '1',
                                    'class' => 'btn btn-primary',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => Yii::t('app', 'Are you sure ?'),
                                        'pjax' => 1,
                                    ],
                                ]
                            );
                            ?>
                             </div>
                            <div class="col-md-4 col-sm-4" style="margin: 2px">
                                <?=
                                Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                                    [
                                        'title' => Yii::t('app', 'Comment'),
                                        'data-pjax' => '1',
                                        'class' => 'btn btn-success btn-comment',
                                        'id' => $row['id']
                                    ]
                                );
                                ?>
                            </div>
                       </div>
                        <?php } ?>

                        <?php
                        if ($row['status'] == 'Pending' && $row['user_from'] == $session['user']['username']) {

                            $idx++;
                            ?>
                            <!--                            <button type="button" class="btn btn-primary btn-sm">-->
                            <!--                                <i class="glyphicon glyphicon-pencil"></i> Update-->
                            <!--                            </button>-->
                            <div class="row">
                                <div class="col-md-4 col-sm-4" style="margin: 2px">
                                    <?= Html::button('<i class="glyphicon glyphicon-pencil"></i> Update', [
                                        'class' => 'btn btn-warning btnupdate',
                                        'id' => $row['id'],
                                        'data-toggle'=> 'modal',
                                        'data-target'=> 'create-task',
                                    ]) ?>
                                </div>
                                <div class="col-md-3 col-sm-3" style="margin: 2px;">
                                    <!--                                <button type="button" class="btn btn-danger btn-sm">-->
                                    <!--                                    <i class="glyphicon glyphicon-trash"></i> Delete-->
                                    <!--                                </button>-->

                                    <?=
                                    Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', Url::to(['task/delete', 'id' => $row['id']]),
                                        [
                                            'title' => Yii::t('app', 'Delete'),
                                            'data-pjax' => '1',
                                            'class' => 'btn btn-danger pull-right',
                                            'data' => [
                                                'method' => 'post',
                                                'confirm' => Yii::t('app', 'Are you sure ?'),
                                                'pjax' => 1,
                                            ],
                                        ]
                                    );
                                    ?>
                                </div>
                                <div class="col-md-4 col-sm-4" style="margin: 2px">
                                    <!--                                <button type="button" class="btn btn-danger btn-sm">-->
                                    <!--                                    <i class="glyphicon glyphicon-trash"></i> Delete-->
                                    <!--                                </button>-->

                                    <?=
                                    Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                                        [
                                            'title' => Yii::t('app', 'Comment'),
                                            'data-pjax' => '1',
                                            'class' => 'btn btn-success btn-comment',
                                            'id' => $row['id']
                                        ]
                                    );
                                    ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        if ($row['status'] == 'Rejected' && $row['user_from'] == $session['user']['username']) {

                            ?>
                            <!--                            <button type="button" class="btn btn-warning btn-sm">-->
                            <!--                                <i class="glyphicon glyphicon-repeat"></i> Resend Request-->
                            <!--                            </button>-->
                        <div class="row">
                            <div class="col-md-5 col-sm-5" style="margin: 2px">
                            <?=
                            Html::a('<span class="glyphicon glyphicon-repeat"></span> Resend Task', Url::to(['task/request', 'id' => $row['id']]),
                                [
                                    'title' => Yii::t('app', 'Resend Task'),
                                    'data-pjax' => '1',
                                    'class' => 'btn btn-warning',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => Yii::t('app', 'Are you sure ?'),
                                        'pjax' => 1,
                                    ],
                                ]
                            );
                            ?>
                            </div>
                            <div class="col-md-5 col-sm-5" style="margin: 2px">
                            <?=
                            Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                                [
                                    'title' => Yii::t('app', 'Comment'),
                                    'data-pjax' => '1',
                                    'class' => 'btn btn-success btn-comment',
                                    'id' => $row['id']
                                ]
                            );
                            ?>
                            </div>
                        </div>

                        <?php } ?>

                        <?php
                            if ($row['status'] == 'Done' && $row['user_to'] == $session['user']['username']) {
                        ?>
                                <?=
                                Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                                    [
                                        'title' => Yii::t('app', 'Comment'),
                                        'data-pjax' => '1',
                                        'class' => 'btn btn-success btn-comment',
                                        'id' => $row['id']
                                    ]
                                );
                                ?>
                        <?php } ?>

                        <?php
                        if ($row['status'] == 'Approved' && $row['user_from'] == $session['user']['username']) {
                            ?>
                            <?=
                            Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                                [
                                    'title' => Yii::t('app', 'Comment'),
                                    'data-pjax' => '1',
                                    'class' => 'btn btn-success btn-comment',
                                    'id' => $row['id']
                                ]
                            );
                            ?>
                        <?php } ?>

                        <?php
                        if ($row['status'] == 'Done' && $row['user_from'] == $session['user']['username']) {
                            ?>
                            <?=
                            Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                                [
                                    'title' => Yii::t('app', 'Comment'),
                                    'data-pjax' => '1',
                                    'class' => 'btn btn-success btn-comment',
                                    'id' => $row['id']
                                ]
                            );
                            ?>
                        <?php } ?>
                        <?php
                        if ($row['status'] == 'Rejected' && $row['user_to'] == $session['user']['username']) {
                            ?>
                            <?=
                            Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                                [
                                    'title' => Yii::t('app', 'Comment'),
                                    'data-pjax' => '1',
                                    'class' => 'btn btn-success btn-comment',
                                    'id' => $row['id']
                                ]
                            );
                            ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            </li>
        <?php } ?>
    </ul>
</div>

<?php
Modal::begin([
    'header' => '<h4 id="modal-head"></h4>',
    'id' => 'create-request',
    'size' => 'modal-md',
]);
?>
<?= \Yii::$app->view->renderFile('@app/views/task/createreq.php'); ?>
<?php
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4 id="head-update"></h4>',
    'id' => 'update-request',
    'size' => 'modal-md',
]);
?>
<div id="update-content"></div>
<?php
Modal::end();
?>

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
    var buttonmode;
    var id;

    $("#comment-modal").on("hidden", function () {
        alert('sukses');
    });

    $(".btn-comment").click(function(){
        id = $(this).attr("id");
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

    $("#btntask").click(function(e){
        $("#form-add")[0].reset();
        buttonmode = 'Add New My Task';
        e.preventDefault();
        $("#buttonmode").html(buttonmode);
        $("#_mode").val("task");
        $("#labelselect").html("Assign From");
        $("#modal-head").text(buttonmode);
        $('#create-request').modal('show');
    });

    $('#btnrequest').click(function(e){
        $("#form-add")[0].reset();
        buttonmode = 'Add New My Request';
        e.preventDefault();
        $("#labelselect").html("Assign To");
        $("#modal-head").text(buttonmode);
        $("#buttonmode").html(buttonmode);
        $("#_mode").val("request");
        $('#create-request').modal('show');
    });

    $('.btnupdate').click(function(e){
        e.preventDefault();
        id = $(this).attr("id");
        $.ajax({
            url : "<?php echo Yii::$app->request->baseUrl. '/task/update2' ?>",
            type : 'post',
            data: { 'id' : id },
            success : function(a) {
                $("#form-add")[0].reset();
                buttonmode = 'Update Request';
                $("#update-content").html(a);
                $("#labelselect").html("Assign To");
                $("#head-update").text(buttonmode);
                $("#buttonmode").html(buttonmode);
                $("#_mode").val("request");
                $('#update-request').modal('show');
            }
        });
    });


    $("#btnadd").click(function(){
        $.ajax({
            url : "<?php echo Yii::$app->request->baseUrl. '/task/create2' ?>",
            type : "post",
            data : $("#form-add").serialize(),
        });
    });

</script>
    <script>
        $(function () {
            Highcharts.setOptions({
                colors: ['#ffe700', '#f03f20','#308dc5','#45e521',]
            });

            Highcharts.chart('container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    width:510,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Summary'
                },

                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b> : ' + this.point.y + ' ('+ Math.round(this.percentage*100)/100 + ' %)';
                            },

                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Count',
                    colorByPoint: true,
                    data: [{
                        name: 'Pending',
                        y: <?php echo json_encode($myrequest[0],JSON_NUMERIC_CHECK) ?>,
                        sliced: true,
                        selected: true
                    }, {
                        name: 'UnApproved',
                        y: <?php echo json_encode($myrequest[1],JSON_NUMERIC_CHECK) ?>,
                    },{
                        name: 'On Progress',
                        y: <?php echo json_encode($myrequest[2],JSON_NUMERIC_CHECK) ?>,
                    },{
                        name: 'Finished',
                        y: <?php echo json_encode($myrequest[3],JSON_NUMERIC_CHECK) ?>,
                    },]
                }]
            });
        });
    </script>

    <script>
        $(function () {
            Highcharts.setOptions({
                colors: ['#ffe700', '#f03f20','#308dc5','#45e521',]
            });

            Highcharts.chart('container2', {
                chart: {
                    plotBackgroundColor: null,
                    width:490,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Summary'
                },

                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b> : ' + this.point.y + ' ('+ Math.round(this.percentage*100)/100 + ' %)';
                            },

                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Count',
                    colorByPoint: true,
                    data: [{
                        name: 'Pending',
                        y: <?php echo json_encode($mytask[0],JSON_NUMERIC_CHECK) ?>,
                        sliced: true,
                        selected: true
                    }, {
                        name: 'UnApproved',
                        y: <?php echo json_encode($mytask[1],JSON_NUMERIC_CHECK) ?>,
                    },{
                        name: 'On Progress',
                        y: <?php echo json_encode($mytask[2],JSON_NUMERIC_CHECK) ?>,
                    },{
                        name: 'Finished',
                        y: <?php echo json_encode($mytask[3],JSON_NUMERIC_CHECK) ?>,
                    },]
                }]
            });
        });
    </script>
<?php
HighChartsAsset::register($this);
?>