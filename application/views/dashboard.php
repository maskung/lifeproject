        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
					<?php if ($amount >= $course->amount) {	 ?>
					<div class="alert alert-danger">
					     ห้องเรียนนี้มีผู้สมัครเต็มแล้ว 
					</div>
					<?php } ?>
                    <h3 class="page-header">กรุณากรอกชื่อผู้สมัครเรียนวิชา <span class="text-primary"><?php echo $course->topic; ?></span> (<?php echo $course->teacher; ?>)</h3>
                    </div>
					<div id="response"></div>

					<div class="well">
					<form class="form-inline" role="form" id="frmadd" action="<?php echo base_url() ?>home/create" method="POST">
						<div class="form-group">
							<label class="sr-only" for="exampleInputEmail2">Full name</label>
							<input type="text" name="name" class="form-control" id="exampleInputEmail2" placeholder="ชื่อ">
						</div>
                        <div class="form-group">
							<label class="sr-only" for="church">คริสตจักร</label>
                            <select class="form-control" name="church">
                                <option value="">โปรดเลือกคริสตจักร</option>
                                <?php foreach($churches as $church) { ?>
                                    <option value="<?php echo $church->church_id; ?>"><?php echo $church->church_name; ?></option>
                                <?php } ?>
                                
                            </select>
                        </div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">@</div>
								<input class="form-control" name="email" type="text" placeholder="กลุ่ม" value="<?php echo $this->session->userdata('groupname'); ?>" readonly="true">
							</div>
						</div>
        
						<!--div class="form-group">
							<label class="sr-only" for="exampleInputPassword2">Contact</label>
							<input type="text" class="form-control" name="contact" id="exampleInputPassword2" placeholder="contact number">
						</div>
						<div class="form-group">
							<label class="sr-only" for="exampleInputPassword2">facebook link</label>
							<input type="text" name="facebook" class="form-control" id="exampleInputPassword2" placeholder="http://facebook.com/pariharvikram1989">
						</div-->
						
						<div class="form-group">
							<input class="form-control" name="courseid" type="hidden" value="<?php echo $this->session->userdata('course_id'); ?>" >
							<?php if ($amount < $course->amount) {  ?>
							<input type="submit" class="btn btn-success" id="exampleInputPassword2" value="เพิ่มรายชื่อ">
							<?php  } ?>
						</div>
					</form>
				</div>
		 
				<table class="table">
					<thead><tr><th>ID</th><th>ชื่อ-นามสกุล</th><th>คริสตจักร</th><th>วันที่</th><th>กำเนินการ</th></tr></thead>
					<tbody id="fillgrid">
					 
					</tbody>
					<tfoot></tfoot>
				</table>


				
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

<script>
$(document).ready(function (){
    //fill data
    var btnedit='';
    var btndelete = '';
        fillgrid();
        // add data
        $("#frmadd").submit(function (e){
            e.preventDefault();
            $("#loader").show();
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.ajax({
                url:url,
                type:'POST',
                data:data
            }).done(function (data){
                $("#response").html(data);
                $("#loader").hide();
                fillgrid();
            });
        });


		$("#frm_login").submit(function (e){
			e.preventDefault();
			var url = $(this).attr('action');
			var method = $(this).attr('method');
			var data = $(this).serialize();
			 
			$.ajax({
			   url:url,
			   type:method,
			   data:data
			}).done(function(data){
			   if(data !=='')
				{
					$("#response").show('fast');
					$("#response").effect( "shake" );
					$('#frm_login')[0].reset();
				}
				else
				{
				window.location.href='<?php echo base_url() ?>home/';
				throw new Error('go');
				} 
			});
		});
     
     
     
    function fillgrid(){
        $("#loader").show();
        $.ajax({
            url:'<?php echo base_url() ?>home/fillgrid',
            type:'GET'
        }).done(function (data){
            $("#fillgrid").html(data);
            $("#loader").hide();
            btnedit = $("#fillgrid .btnedit");
            btndelete = $("#fillgrid .btndelete");
            var deleteurl = btndelete.attr('href');
            var editurl = btnedit.attr('href');
            //delete record
            btndelete.on('click', function (e){
                e.preventDefault();
                var deleteid = $(this).data('id');
                if(confirm("are you sure")){
                    $("#loader").show();
                    $.ajax({
                    url:deleteurl,
                    type:'POST' ,
                    data:'id='+deleteid
                    }).done(function (data){
                    $("#response").html(data);
                    $("#loader").hide();
                    fillgrid();
                    });
                }
            });
             
            //edit record
            btnedit.on('click', function (e){
                e.preventDefault();
                var editid = $(this).data('id');
                $.colorbox({
                href:"<?php echo base_url()?>home/edit/"+editid,
                top:50,
                width:500,
                onClosed:function() {fillgrid();}
                });
            });
             
        });
    }
     
            $( "div" ).each(function( index ) {
            var cl = $(this).attr('class');
            if(cl =='')
                {
                    $(this).hide();
                }
            });
});


</script><!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
