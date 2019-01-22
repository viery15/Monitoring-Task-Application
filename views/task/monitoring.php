<?php
/**
 * Created by PhpStorm.
 * User: VIERY
 * Date: 1/21/2019
 * Time: 10:16 AM
 */
use app\assets\DataTablesAsset;
use app\assets\HighChartsAsset;

$this->title = 'Monitoring';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("@web/css/select2.min.css");

?>

<div class="row" style="background-color: white;margin: 0px;padding:1%;padding-top:2%;padding-right: 2%">
    <div class="col-md-12">
        <form class="form-horizontal" id="form-nik">
            <div class="form-group">
                <label class="col-sm-2 control-label">NIK :</label>
                <div class="col-sm-10">
                    <select class="js-example-responsive" style="width: 100%;" name="nik" id="input-nik">
                        <option disabled selected>Select NIK </option>
                        <?php
                            foreach ($user_data as $data) {
                        ?>
                        <option value="<?= $data['nik'] ?>"><?= $data['nik'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
        </form>
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" id="btn-submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
    </div>
</div>

<div id="data-user" style="display: none;">

</div>

<script language="JavaScript" type="text/javascript">

    $(".js-example-responsive").select2({
        width: 'resolve' // need to override the changed default
    });

    $("#btn-submit").click(function(){
        var nik = $('#form-nik').serialize();
        $.ajax({
           url : "<?php echo Yii::$app->request->baseUrl. '/task/searchnik' ?>",
           type : 'post',
           data : nik,
           success : function(html) {
                $("#data-user").show();
                $("#data-user").html(html);
                // config update
               // ctx.reload
           }
        });
    });
</script>

<?php
DataTablesAsset::register($this);
HighChartsAsset::register($this);
?>