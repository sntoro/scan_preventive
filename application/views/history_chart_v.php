<script type="text/javascript" src="<?php echo base_url('assets/script/newcanvas.js') ?>"></script>
<script type="text/javascript">
    window.onload = function() {
        var chart_range = new CanvasJS.Chart("chartRange", {
            animationEnabled: true,
            theme: "light",
            title: {
                text: "<?php echo trim(strtoupper($std_chart->CHR_ITEM_CHECK)); ?>",
                fontFamily: "tahoma"
            },
            legend: {
                horizontalAlign: "center",
                verticalAlign: "bottom",
                fontSize: 12
            },
            axisY: {
                title: "Range",
                includeZero: false,
                interval: <?php echo $std_chart->CHR_RANGE; ?>,
                minimum: <?php echo $std_chart->CHR_STD_MIN - $std_chart->CHR_RANGE; ?>,
                maximum: <?php echo $std_chart->CHR_STD_MAX + $std_chart->CHR_RANGE; ?>,
                gridThickness: 1,
                gridDashType: "dash",
                suffix: " <?php echo $std_chart->CHR_UOM; ?>",
                stripLines: [{
                        value: <?php echo $std_chart->CHR_STD_MIN ?>,
                        lineThickness: 2,
                        showOnTop: true,
                        label: "Min = <?php echo $std_chart->CHR_STD_MIN ?>",
                        labelFontColor: "#ed1e1a",
                        color: "#ed1e1a"
                    },
                    {
                        value: <?php echo $std_chart->CHR_STD_MAX ?>,
                        lineThickness: 2,
                        showOnTop: true,
                        label: "Max = <?php echo $std_chart->CHR_STD_MAX ?>",
                        labelFontColor: "#ed1e1a",
                        color: "#ed1e1a"
                    }
                ]
            },
            axisX: {
                title: "Date",
                labelMaxWidth: 75,
                labelWrap: true
            },
            toolTip: {
                shared: true
            },
            data: [{
                type: "line",
                name: "Value ",
                showInLegend: true,
                legendText: "Data Range Hasil",
                toolTipContent: "<span style=\"color:#C0504E\">{name}</span> : {y} <?php echo $std_chart->CHR_UOM; ?>",
                dataPoints: [
                <?php
                $x = 1;
                $row = $data_chart->num_rows();
                foreach ($data_chart->result() as $val){
                    if($x == $row){
                ?>
                    {
                        y: <?php echo trim($val->CHR_REMARKS); ?>,
                        label: "<?php echo $x; ?>"
                    }
                <?php } else { ?>
                    {
                        y: <?php echo trim($val->CHR_REMARKS); ?>,
                        label: "<?php echo $x; ?>"
                    },
                <?php }
                    $x++;
                    } 
                ?>
                ]
            }]
        });
        chart_range.render();
    }
</script>

<?php if ($data_chart->num_rows() <= 0) { ?>
    <table width=100%><td> No data available in diagram</td></table>
<?php } else { ?>
    <div id="chartRange" style="height: 400px; width: 100%;"></div>
<?php } ?>