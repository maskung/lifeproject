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
                           รายงานคะแนนความพึงพอใจในรูปแบบกราฟแท่งเปรียบเทียบ 
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
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           รายงานคะแนนเฉลี่ยความพึงพอใจ 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-bar-chart-xbar"></div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        สัดส่วนผู้ทำแบบสอบแบ่งตามเพศทั้งหมดจากจำนวน  <?php echo  $totalamount->amount;  ?>  คน
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
                        สัดส่วนผู้ทำแบบสอบแบ่งตามเพื้นที่งหมดจากจำนวน  <?php echo  $totalamount->amount;  ?>  คน
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-pie-chart-area"></div>
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
    <?php foreach ($amountbysex as $value) { ?>
    {
        label: "<?php echo $value->sex==1?"ชาย"." (".$value->amount." คน)":"หญิง"." (".$value->amount." คน)"; ?>",
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

//Flot Pie Chart
$(function() {

    var data = [
    <?php foreach ($amountbyarea as $value) { ?>
    {
        label: "<?php if ($value->church==1) { 
            echo "กรุงเทพฯ"." (".$value->amount." คน)";
        } else if ($value->church==2) {
            echo "รอบนอก"." (".$value->amount." คน)";
        } else {
            echo "ต่างจังหวัด"." (".$value->amount." คน)";
        }
        ?> ",
        data: <?php echo $value->amount; ?>
    },
       
    <?php } ?>
    ];

    var plotObj = $.plot($("#flot-pie-chart-area"), data, {
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

$(function () {
    $('#flot-bar-chart-hichart').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ความพึงพอใจ'
        },
        xAxis: {
            categories: ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'ผลรวมคะแนนความพึงพอใจในกิจกรรม Life Sharing'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            }
        },
        series: [{
            name: 'มากที่สุด',
                data: [
                <?php foreach ($ranks[5] as $rank) { 
                    echo $rank.",";
                } ?>
                ]
        }, {
            name: 'มาก',
                data: [
                <?php foreach ($ranks[4] as $rank) { 
                    echo $rank.",";
                } ?>
                ]
        }, {
            name: 'ปานกลาง',
                data: [
                <?php foreach ($ranks[3] as $rank) { 
                    echo $rank.",";
                } ?>
                ]
        }, {
            name: 'น้อย',
                data: [
                <?php foreach ($ranks[2] as $rank) { 
                    echo $rank.",";
                } ?>
                ]
        }, {
            name: 'นอยที่สุด',
                data: [
                <?php foreach ($ranks[1] as $rank) { 
                    echo $rank.",";
                } ?>
                ]
        }]
    });
});	


$(function () {
    $('#flot-bar-chart-xbar').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ค่าเฉลี่ยความพึงพอใจในกิจกรรม Life Sharing'
        },
        subtitle: {
            text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
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
                text: 'ค่าเฉลี่ยความพึงพอใจ (X)'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'คะแนนเฉลี่ยความพึงพอใจ: <b>{point.y:.1f} millions</b>'
        },
        series: [{
            name: 'Population',
            data: [
            ['ผู้นำ life sharing', <?php echo $love[1]; ?>],
            ['เนื้อหาบทเรียน life sharing',<?php echo $love[2]; ?>],
            ['บรรยากาศโดยรวม life sharing', <?php echo $love[3]; ?>],
            ['ความพร้อมของสถานที่เรียน', <?php echo $love[4]; ?>],
            ['ความสะดวกในการสมัครเรียน ลงทะเบียน', <?php echo $love[5]; ?>],
            ['เวลาการเข้ากลุ่มเหมาะสม', <?php echo $love[6]; ?>],
            ['ท่านได้มีบทบาทในการแบ่งปันกลุ่ม', <?php echo $love[7]; ?>],
            ['การประชาสัมพันธ์', <?php echo $love[8]; ?>],
            ['ท่านได้รับประโยชน์จากการเข้ากลุ่ม', <?php echo $love[9]; ?>],
            ['ควรมีการจัด life sharing ครั้งต่อไป', <?php echo $love[10]; ?>],
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
});


    </script>



