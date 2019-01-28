<?php
/**
 * Created by PhpStorm.
 * User: VIERY
 * Date: 1/21/2019
 * Time: 1:26 PM
 */

?>

<div id="row-summary" class="row" style="background-color: white;margin: 0px;padding:1%;padding-top:2%;padding-right: 2%;margin-top: 1%;">
    <div class="col-md-6 col-md-offset-3" id="summary-user">
        <div id="canvas-holder">
            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
    </div>
</div>

<div id="row-table" class="row" style="background-color: white;margin: 0px;padding:1%;padding-top:2%;padding-right: 2%;margin-top: 1%;">
    <div class="col-md-12" id="table-monitoring" style="text-align: center">
        <h3> Tasks Of <?= $nik ?></h3>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th scope="col">Date Start</th>
                <th scope="col">Remark</th>
                <th scope="col">Description</th>
                <th scope="col">Assign From</th>

                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data_progress as $data_progress) {
                $date_from = strtotime($data_progress['date_from']);
                $date_to = strtotime($data_progress['date_to']);
                ?>
                <tr>
                    <td><?php echo date('d M Y', $date_from); ?></td>
                    <td><?= $data_progress['remark'] ?></td>
                    <td><?= $data_progress['description'] ?></td>
                    <td><?= $data_progress['user_from'] ?></td>
                    <td>On Progress</td>
                </tr>
            <?php } ?>
            <?php
            foreach ($data_done as $data_done) {
                $date_from = strtotime($data_done['date_from']);
                $date_to = strtotime($data_done['date_to']);
                ?>
                <tr>
                    <td><?php echo date('d M Y', $date_from); ?></td>
                    <td><?= $data_done['remark'] ?></td>
                    <td><?= $data_done['description'] ?></td>
                    <td><?= $data_done['user_from'] ?></td>

                    <td>Done</td>
                </tr>
            <?php } ?>

            </tbody>
            <tfoot>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Remark</th>
                <th scope="col">Description</th>
                <th scope="col">Assign From</th>

                <th scope="col">Status</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    $(function () {
        Highcharts.setOptions({
            colors: ['#50B432', '#308dc5',]
        });

        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Summary of '+ <?= $nik ?>+'\'s Tasks'
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
                    name: 'Done',
                    y: <?php echo json_encode($mystatus[0],JSON_NUMERIC_CHECK) ?>,
                    sliced: true,
                    selected: true
                }, {
                    name: 'On Progress',
                    y: <?php echo json_encode($mystatus[1],JSON_NUMERIC_CHECK) ?>,
                }]
            }]
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>



