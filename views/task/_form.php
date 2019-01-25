<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\User;
//use app\models\Task;

$session = Yii::$app->session;
$session->open();
/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
//$model = Task::findOne(88);
?>

<div class="task-form">
    <?php $form = ActiveForm::begin(['id'=>'form-add']); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model,'date_from')->widget(DatePicker::className(),['dateFormat' => 'MM/dd/yyyy', 'options' => ['class' => 'form-control','autocomplete' => 'off']]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model,'date_to')->widget(DatePicker::className(),['dateFormat' => 'MM/dd/yyyy', 'options' => ['class' => 'form-control','autocomplete' => 'off']]) ?>
        </div>
    </div>





    <?php
        $dataList=ArrayHelper::map(User::find()->where(['<>','nik',$session["user"]["username"]])->asArray()->all(), 'nik', 'nik');
    ?>
        <input type="hidden" name="_mode" id="_mode">

        <div class="form-group">
            <label for="sel1" id="labelselect"></label>
            <select name="user_value" class="form-control">
                <option selected disabled>Please Choose One</option>
                <?php
                foreach ($dataList as $data) {
                    echo '<option value="'.$data.'">'.$data.'</option>';
                } ?>
            </select>
        </div>

    <?= $form->field($model, 'remark')->textInput() ?>

    <?= $form->field($model, 'status')->hiddenInput(['readonly' => true, 'value' => 'pending'])->label(false) ?>

    <?= $form->field($model, 'description')->textArea() ?>

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

</script>
