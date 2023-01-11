<script type="text/javascript" src="<?php echo base_url('assets/script/newcanvas.js') ?>"></script>
<script type="text/javascript">
    window.onload = function() {
        var chart_range = new CanvasJS.Chart("chartRange", {
            animationEnabled: true,
            theme: "light",
            title: {
                text: "Data Range",
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
                interval: 0.01,
                minimum: 82.30,
                maximum: 82.35,
                gridThickness: 1,
                gridDashType: "dash",
                suffix: " mm",
                stripLines: [{
                        value: 82.31,
                        lineThickness: 2,
                        showOnTop: true,
                        label: "Min SL = 82.31",
                        labelFontColor: "#ed1e1a",
                        color: "#ed1e1a"
                    },
                    {
                        value: 82.34,
                        lineThickness: 2,
                        showOnTop: true,
                        label: "Max SL = 82.34",
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
                toolTipContent: "<span style=\"color:#C0504E\">{name}</span> : {y} mm",
                dataPoints: [
                    {
                        y: 82.33,
                        label: "xx"
                    },
                    {
                        y: 82.32,
                        label: "xx"
                    }
                ]
            }]
        });
        chart_range.render();
    }
</script>

<div id="chartRange" style="height: 400px; width: 100%;"></div>