<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>
<script>
	jQuery(document).ready(function(){
		jQuery(".pagination li a").click(function(e){
			document.getElementById('manage_bookings').action = jQuery(this).attr('href');
			jQuery('#manage_bookings').submit();
			e.preventDefault();
		});
	});

	function page_count_check(){
		document.getElementById("manage_bookings").submit();
	}
</script>
<style>
	.table-bordered th{padding:10px !important;}
	.table-bordered td{padding:10px !important;}
</style>
<script>

	$(".nav-tabs").tabs({

		select: function(event, ui) {

			window.location.hash = ui.tab.hash;

		}

	});





	function confirmAction(status,a_element, message, action){

		alertify.confirm(message, function(e) {

			if (e) {

				// a_element is the <a> tag that was clicked

				if (action) {

					action(status,a_element);

				}

			}

		});

	}



	function changeStatus(status,result){

		$.ajax({

			type: "POST",

			dataType: 'json',

			url: '<?php echo $this->config->item('update_fundraising_status');?>',

			data: "champion_id="+result+"&status="+status,

			success: function(Rid1) {

				if (Rid1) {

					location.reload();

					alertify.success("status updated successfully");

				}else{

					alertify.error("error in updating status");

				}

			}

		});

	}



	function reset(){

		$("#toggleCSS").attr("href", "<?php echo $this->config->item("admin_css_path");?>/alertify.default.css");

		alertify.set({

			labels : {

				ok     : "OK",

				cancel : "Cancel"

			},



			delay : 5000,

			buttonReverse : true,

			buttonFocus   : "ok"

		});

	}

</script>

<script>

	function load_sub_event_by_event_id(parent){



		if(parent.value != ""){

			$("#select_sub_event").load("<?php echo $this->config->item("load_sub_event_by_event_id");?>?event_id=" + parent.value);

		}else{

			$('#select_sub_event option').remove();

		}



	}



</script>

<?php
	if((isset($_POST['eid']))){
		$eid=$_POST['eid'];
		if(isset($_POST['sub_eid'])){
			$sub_id = $_POST['sub_eid'];
		}else{
			$sub_id = "";
		}
	}else{
		$eid='';
		$sub_id='';
	}

	if(isset($_POST['pay_status'])){
		$pay_status = $_POST['pay_status'];
	}else{
		$pay_status = "1";
	}
?>


<div class="content">
	<!-- Kode-Header End -->
	<div class="sub-header">
		<!-- SUB HEADER -->
	</div>

	<!-- Kode-Slider End -->
	<!--Kode-our-speaker-heading start-->
	<div class="Kode-page-heading">

		<div class="container">
			<!--ROW START-->
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>Donation Reports</h2>
				</div>
			</div>
			<!--ROW END-->
		</div>
	</div>
	<!--Kode-our-speaker-heading End-->

	<div class="kode-blog-style-2 search_table" style="min-height:500px;">
		<div class="container">

			<div class="row" style="margin-bottom:0px;">



				<form method="post" action="" id="manage_bookings" name="manage_bookings">
					<div class="col-sm-3">
						<select class="form-control dropdown" id="event_list" onchange="load_sub_event_by_event_id(this)" name="eid">                    							<option value="">-- All Events --</option>							<?php foreach($event_list as $list){?>							<option  <?php if($eid == $list['id']){ echo "selected";}?> value="<?php echo $list['id']; ?>"><?php echo $list['title']; ?></option>							<?php } ?>
						</select>
					</div>					<div class="col-sm-3">
						<select class="form-control dropdown" id="select_sub_event" name="sub_eid">
							<?php if(!isset($_POST['sub_eid'])){ ?>
							<option value="">-- Select Event --</option>
							<?php }  if(!empty($get_sub_event_details)){
								foreach($get_sub_event_details as $sub_evento){ ?>
								<option value="<?php echo $sub_evento['id'];?>" <?php if(isset($_POST['sub_eid'])){ echo 'selected'; }else{ echo ''; }; ?>><?php echo $sub_evento['schedule_title'];?></option>								<?php	}												} ?>
						</select>
					</div>

						<div class="col-sm-3">
						<input type="text" class="search_events form-control" placeholder="Donation From" name="donation_from" id="donation_from" value="<?php if(isset($_POST['donation_from'])){ echo $_POST['donation_from']; }else{ echo ''; }; ?>">
						</div>
						
						<div class="col-sm-3">
							<select class="form-control dropdown" id="pay_status" name="pay_status">
								<option value="3" <?php if($pay_status == "3"){ echo "SELECTED";}?>>All</option>	
								<option value="1" <?php if($pay_status == "1"){ echo "SELECTED";}?>>Successfull</option>
								<option value="2" <?php if($pay_status == "2"){ echo "SELECTED";}?>>Unsuccessfull</option>
							</select>
						</div>	

				</div>

				<div class="row" style="margin-bottom:0px;">
					<div class="col-sm-1">
						<label style="padding:10px;">Records</label>
					</div>
					<div class="col-sm-2">
						<select class="form-control dropdown" id="per_page" name="per_page" onchange="page_count_check();">
							<option value="5" <?php if($page_count  == '5'){ echo " selected";}else{ echo "";}?>>5</option>
							<option value="10" <?php if($page_count  == '10'){ echo " selected";}else{ echo "";}?>>10</option>
							<option value="20" <?php if($page_count  == '20'){ echo " selected";}else{ echo "";}?>>20</option>
							<option value="30" <?php if($page_count  == '30'){ echo " selected";}else{ echo "";}?>>30</option>
							<option value="40" <?php if($page_count  == '40'){ echo " selected";}else{ echo "";}?>>40</option>
							<option value="50" <?php if($page_count  == '50'){ echo " selected";}else{ echo "";}?>>50</option>
						</select>
					</div>
					<div class="col-md-1">
						<button class="blue_box_title" type="submit" style="padding: 9px 20px;margin-bottom:15px;" id="seach_rec">Search</button>
					</div>
					<div class="col-md-1">
						<button onclick ="go_to_location();" class="blue_box_title" type="button" style="padding: 9px 20px;margin-bottom:15px;" >Reset</button>
					</div>
					<div class="col-md-2">
				
					<button  id="export_to_csv" id="download" class="blue_box_title" type="button" style="padding: 9px 20px;margin-bottom:15px;">Export To CSV</button>
					
					</div>
				</div>

			</form>
			<div class="row">

				<div class="col-md-12">
					<?php if($this->session->flashdata('message')): ?>
						<div style="color:green"><?php echo $this->session->flashdata('message'); ?></div>
					<?php endif; ?>
					<div class="table-responsive">

						<table class="table table-bordered">

							<thead>

								<tr>
									<th>Event Name</th>
									<th>Sub Event Name</th>
									<th>Donation To</th>
									<th>Donation From</th>
									<th>Amount</th>
									<th>Donation Date</th>
									<th>Action</th>
								</tr>

							</thead>

							<tbody>
								<?php
								if(count($data) > 0){
								$i=0;
								foreach($data as $get_value){

					if($i % 2 == 0) {
						$class = "even";
					}else{
						$class="odd";
					}
					$i++;
					?>
					<tr class="<?php echo $class;?>">
						<td><?php echo $get_value['event_name']; ?></td>
						<td><?php echo $get_value['sub_event_name']; ?></td>
						<td><?php echo $get_value['title']; ?></td>
						<td><?php echo $get_value['first_name']; ?></td>
						<td><?php echo number_format($get_value['donation_amount'],2); ?></td>
						<?php $n_date=date("d-m-Y",strtotime($get_value['created_date'])); ?>
						<td><?php echo $n_date; ?></td>
						<td>
							<a href="<?php echo base_url(); ?>index.php/frontend/donation_reports/view_organiser_donations/<?php echo $get_value['main_id'];?>">View</a>		
							|
							<?php if($get_value['status'] == 1){ ?>
								<a href="#" class="<?php echo $get_value['main_id']; ?> send_receipt_class <?php echo $get_value['email']; ?>" id="<?php echo $get_value['order_id']; ?>" data-toggle="modal" data-target="#myModal">Send Receipt</a>										
							<?php }else{ 
								echo "Send Receipt";
							} ?>
						</td>

				</tr>
				<?php } }else{ ?>
					<tr>
						<td colspan="9">No records are available</td>
					</tr>
				<?php }?>
			</tbody>

		</table>

	</div>

</div>

</div>

<div class="pag" style="float:left">
	<div class="col-md-12">
		<?php echo $this->pagination->create_links(); ?>
	</div>
</div>
</div>

</div>







</div>







</div><!--Content-->


<style>
	.odd{background:#f9f9f9;}
	.even{background:#ffffff;}
</style>

<script>
	function go_to_location(){
		window.location = "<?php echo $this->config->item('base_url');?>index.php/frontend/donation_reports/";
	}
	
	$(document).ready(function(){
        $('#export_to_csv').click(function(){
			$('#manage_bookings').attr('action','<?php echo base_url(); ?>frontend/donation_reports/export_csv');
			$('#manage_bookings').submit();
		});

		$('#seach_rec').click(function(){
			$('form').attr('action','');
			$('form').submit();
		});
	});
</script>


<?php
  if(isset($_POST)){
?>
 <script>
   $(document).ready(function(){
        var eve_id="<?php echo $_POST['eid'];?>";
				var sub_id="<?php echo $_POST['sub_eid']; ?>";
				$("#select_sub_event").load("<?php echo $this->config->item("load_sub_event_by_event_id_with_subevents");?>?event_id=" + eve_id+'&sub_event_id='+sub_id);

	 });
 </script>


<?php
	}
?>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Resend Donation Receipt</h4>
      </div>
      <form id="modal-form" name="modal-form" action="<?php echo $this->config->item("base_url");?>/frontend/donation_reports/resent_donation_receipt" method="post">
      <div class="modal-body">
        <div class="row">
        	<div class="col-md-12">
        		<input type="text" name="email" class="modal_email form-control">
        		<input type="hidden" name="order_no" class="modal_order_id form-control">
        		<input type="hidden" name="donation_id" class="modal_donation_id form-control">
				<span style="color:red" id="valiade_email"></span>
        	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" type="submit" >Send</button>   
      </div>
      </form>
    </div>

  </div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
        $('.send_receipt_class').click(function(){
           var order_no=this.id;
           var donation_id=$(this).attr('class').split(' ')[0];
           var email=$(this).attr('class').split(' ').pop();
          
		  
           $('.modal_order_id').val(order_no);
           $('.modal_donation_id').val(donation_id);
           $('.modal_email').val(email);

        });
	});
	
	
	 $(document).on('keyup','.modal_email',function(){
  	   $('#valiade_email').text('');
     }); 
		
		
	$(document).on('submit','#modal-form',function(e){
  		  var email=$('.modal_email').val();
  	    	  var pattern = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
			  
			 if(email==''){
			   $('#valiade_email').text('Please enter email address');
				e.preventDefault(e);
			 }
			 if(!pattern.test(email))
			 {
			 
			   $('#valiade_email').text('Please enter valid email address');
				 e.preventDefault(e);

			 }
              
		});
</script>



