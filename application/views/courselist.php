        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">รายชื่อผู้เข้าเรียนแบ่งตาม course</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php foreach ($allcourses as $course) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <?php echo $course['course_name']; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อ - สกุล</th>
                                            <th>ห้อง</th>
                                            <th>วันที่</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($course['students'])) { 
                                            $i = 1;
                                            foreach ($course['students'] as $student) { 
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $student->name; ?></td>
                                            <td><?php echo $student->email; ?></td>
                                            <td><?php echo $student->created; ?></td>
                                        </tr>
                                        <?php $i++; } ?>
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan=4>ยังไม่มีผู้ลงทะเบียน</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            <?php } ?>
        </div>
        <!-- /#page-wrapper -->
