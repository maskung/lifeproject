        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">รายงานการประเมินต่างๆ</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           จำนวนคนที่ลงทะเบียนเรียนแต่ละรายวิชา
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-bar-chart-hichart"></div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           สัดส่วนผู้ลงทะเบียนเรียนทั้งหมด 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-pie-chart"></div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Bar Chart Example
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-bar-chart"></div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    <!-- Flot Charts JavaScript -->
    <script src="/assets/flot/excanvas.min.js"></script>
    <script src="/assets/flot/jquery.flot.js"></script>
    <script src="/assets/flot/jquery.flot.pie.js"></script>
    <script src="/assets/flot/jquery.flot.resize.js"></script>
    <script src="/assets/flot/jquery.flot.time.js"></script>
    <script src="/assets/flot/jquery.flot.tooltip.min.js"></script>
    <!--script src="/assets/js/flot-data.js"></script-->

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script>


//Flot Pie Chart
$(function() {

    var data = [
    <?php foreach ($amountbychurch as $value) { ?>
    {
        label: "<?php echo $value->church_name==NULL?"ไม่ทราบ":$value->church_name." (".$value->amount." คน)"; ?>",
        data: <?php echo $value->amount; ?>
    },
       
    <?php } ?>
    ];

    var plotObj = $.plot($("#flot-pie-chart"), data, {
        series: {
            pie: {
                show: true,
                radius: 1
            }
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            },
            defaultTheme: false
        }
    });

});

//Flot Bar Chart

$(function() {

    var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 43200000
            }
        },
        xaxis: {
            mode: "time",
            timeformat: "%m/%d",
            minTickSize: [1, "day"]
        },
        grid: {
            hoverable: true
        },
        legend: {
            show: false
        },
        tooltip: true,
        tooltipOpts: {
            content: "x: %x, y: %y"
        }
    };
    var barData = {
        label: "bar",
        data: [
            [1, 1000],
            [2, 2000],
            [3, 3000],
            [4, 4000],
            [5, 5000],
            [6, 6000]
        ]
    };
    $.plot($("#flot-bar-chart"), [barData], barOptions);

});

    </script>

    <script>

	$(function () {
    $('#flot-bar-chart-hichart').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'กราฟแสดงจำวนผู้ลงทะเบียนเรียนในแต่ละวิชาในค่าย  Life Sharing'
        },
        subtitle: {
            text: 'Source: <a href="http://www.churchofcovenant.com/">COC</a>'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'จำนวนผุ้เรียน  (คน) '
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'จำนวนผู้ลงทะเบียน: <b>{point.y:.0f} </b> คน '
        },
        series: [{
            name: 'Population',
            data: [
            <?php foreach ($amountbyCourse as $value) { ?>
            ['<?php echo $value->group_name." ".$value->topic; ?>', <?php echo $value->amount; ?>],
            <?php  } ?>
            ],
            dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'center',
                format: '{point.y:.0f}', // one decimal
                y: 20, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
});

    </script>



