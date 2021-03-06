<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Task;

$session = Yii::$app->session;
$session->open();
/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="task-form">

    <?php
        $form = ActiveForm::begin(['id'=>'form-add']);
    ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model,'date_from')->label('Date From *')->widget(DatePicker::className(),['dateFormat' => 'MM/dd/yyyy', 'options' => ['class' => 'form-control','autocomplete' => 'off']]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model,'date_to')->label('Date To *')->widget(DatePicker::className(),['dateFormat' => 'MM/dd/yyyy', 'options' => ['class' => 'form-control','autocomplete' => 'off']]) ?>
        </div>
    </div>

    <?php
        $dataList=ArrayHelper::map(User::find()->where(['<>','nik',$session["user"]["username"]])->asArray()->all(), 'nik', 'nik');
    ?>

    <?php
    if ($session['task'] == 'mytask') {
    ?>
        <?=$form->field($model, 'user_from')->label('User From *')->dropDownList($dataList,
            ['prompt'=>'-Assign To-']) ?>

        <?= $form->field($model, 'user_to')->hiddenInput(['readonly' => true, 'value' => $session['user']['username']])->label(false) ?>
        
    <?php } else {?>
        <?=$form->field($model, 'user_to')->label('Assign To *')->dropDownList($dataList,
            ['prompt'=>'-Assign To-']) ?>

        <?= $form->field($model, 'user_from')->hiddenInput(['readonly' => true, 'value' => $session['user']['username']])->label(false) ?>
    <?php } ?>

    <?= $form->field($model, 'remark')->label('Remark *')->textInput() ?>

    <?= $form->field($model, 'status')->hiddenInput(['readonly' => true, 'value' => 'pending'])->label(false) ?>

    <?= $form->field($model, 'description')->label('Description *')->textArea() ?>

    <?= $form->field($model, 'update_at')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'create_at')->hiddenInput()->label(false) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group" style="text-align: right">
            <?= Html::button(' Create', [
                'class' => 'btn btn-primary',
                'id' => 'btnadd',
            ])?>
            <?=
            Html::button('Close',['class'=>'btn btn-default','data-dismiss'=>"modal"])
            ?>
        </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
</div>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function(){
       $("#btnadd").click(function(){
         $.ajax({
             url : "<?php echo Yii::$app->request->baseUrl. '/task/create2' ?>",
             type : "post",
             data : $("#form-add").serialize(),
         });
       });
    });
</script>
