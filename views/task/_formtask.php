<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Task;

$session = Yii::$app->session;
$session->open();

if (isset($id)) {
    $model = Task::findOne($id);
}

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="task-form2">
    <?php
        $form = ActiveForm::begin([
                'id'=>'form-up',
                'options' => ['accept-charset'=>'utf-8'],
        ]);
        $session['task'] = 'myrequest';
    ?>
    <input type="hidden" name="idd" value="<?= $id ?>">

    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <label>Date From</label>
                <input name="date_from" value="<?= $model['date_from'] ?>" type="text" id="datepicker" class="form-control datepicker1" placeholder="Choose">
            </div>
        </div>
        <div class='col-sm-6'>
            <div class="form-group">
                <label>Date To</label>
                <input name="date_to" value="<?= $model['date_to'] ?>" type="text" class="form-control datepicker1" placeholder="Choose">
            </div>
        </div>
    </div>

    <?php
        $dataList=ArrayHelper::map(User::find()->where(['<>','nik',$session["user"]["username"]])->asArray()->all(), 'nik', 'nik');
    ?>

    <?php
    if ($session['task'] == 'mytask') {
    ?>
        <?=$form->field($model, 'user_from')->dropDownList($dataList,
            ['prompt'=>'-Assign To-']) ?>

        <?= $form->field($model, 'user_to')->hiddenInput(['readonly' => true, 'value' => $session['user']['username']])->label(false) ?>
        
    <?php } else {?>
        <?=$form->field($model, 'user_to')->dropDownList($dataList,
            ['prompt'=>'-Assign To-']) ?>

        <?= $form->field($model, 'user_from')->hiddenInput(['readonly' => true, 'value' => $session['user']['username']])->label(false) ?>
    <?php } ?>

    <?= $form->field($model, 'remark')->textInput() ?>

    <?= $form->field($model, 'status')->hiddenInput(['readonly' => true, 'value' => 'Pending'])->label(false) ?>

    <?= $form->field($model, 'description')->textArea() ?>

    <?= $form->field($model, 'update_at')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'create_at')->hiddenInput()->label(false) ?>

	  	<div class="form-group" style="text-align: right">
            <?= Html::button(' Save', [
                'class' => 'btn btn-primary',
                'id' => 'btnup',
            ])?>
            <?=
            Html::button('Close',['class'=>'btn btn-default','data-dismiss'=>"modal"])
            ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>

<script language="JavaScript" type="text/javascript">

    $(function() {
        $( ".datepicker1" ).datepicker({
            dateFormat : 'yy-mm-dd',
//            changeMonth : true,
//            changeYear : true,
//            yearRange: '-100y:c+nn',
//            maxDate: '-1d'
        });
    });
        $("#btnup").click(function(){
            var data = $("#form-up").serialize();
            var idup = <?php echo $id ?>;
            $.ajax({
                url : "<?php echo Yii::$app->request->baseUrl. '/task/updatetask' ?>",
                type : "post",
                data : data,
            });
        });
</script>
