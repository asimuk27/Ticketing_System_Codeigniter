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

</script>
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>

<script>
	function confirmAction(a_element, message, action){
		alertify.confirm(message, function(e) {
			if (e) {
				// a_element is the <a> tag that was clicked
				if (action) {
					action(a_element);
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


	function change_ticket_status(result){
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('base_url');?>frontend/tickets/change_ticket_status",
			data: "id="+result,
			success: function(Rid2) {
				if(Rid2){
				    location.reload();
					alertify.success("Ticket has been deleted successfully");
				}else{
					alertify.error("Unable to delete a ticket");
				}
			}
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

<?php if((isset($_POST['eid']))){
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
					<h2>Manage Ticket Bookings</h2>
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
							<option value="">-- Select Sub Event --</option>
							<?php }  if(!empty($get_sub_event_details)){
								foreach($get_sub_event_details as $sub_evento){ ?>
								<option value="<?php echo $sub_evento['id'];?>" <?php if(isset($_POST['sub_eid'])){ echo 'selected'; }else{ echo ''; }; ?>><?php echo $sub_evento['schedule_title'];?></option>								<?php	}												} ?>
						</select>
					</div>
					<div class="col-sm-3">								<input type="text" class="search_events form-control" placeholder="Order Id or Ticket Id" name="search_by_order_id" id="search_by_order_id" value="<?php if(isset($_POST['search_by_order_id'])){ echo $_POST['search_by_order_id']; }else{ echo ''; }; ?>">					</div>  					<div class="col-sm-3">								<input type="text" class="search_events form-control" placeholder="Email or Name" name="search_by_email" id="search_by_email" value="<?php if(isset($_POST['search_by_email'])){ echo $_POST['search_by_email']; }else{ echo ''; }; ?>">					</div>

				</div>

				<div class="row" style="margin-bottom:0px;">
					<div class="col-md-1">
						<label style="padding:10px;">Records</label>
					</div>
					<div class="col-md-1">
						<select class="form-control dropdown" id="per_page" name="per_page" onchange="page_count_check();">
							<option value="5" <?php if($page_count  == '5'){ echo " selected";}else{ echo "";}?>>5</option>
							<option value="10" <?php if($page_count  == '10'){ echo " selected";}else{ echo "";}?>>10</option>
							<option value="20" <?php if($page_count  == '20'){ echo " selected";}else{ echo "";}?>>20</option>
							<option value="30" <?php if($page_count  == '30'){ echo " selected";}else{ echo "";}?>>30</option>
							<option value="40" <?php if($page_count  == '40'){ echo " selected";}else{ echo "";}?>>40</option>
							<option value="50" <?php if($page_count  == '50'){ echo " selected";}else{ echo "";}?>>50</option>
						</select>
					</div>
					<div class="col-md-5">
						<button class="blue_box_title" type="submit" style="padding: 9px 20px;margin-bottom:15px;margin-right:15px;" id="seach_rec">Search</button>
						<button onclick ="go_to_location();" class="blue_box_title" type="button" style="padding: 9px 20px;margin-right:15px;margin-bottom:15px;" >Reset</button>
						<button  id="export_to_csv" id="download" class="blue_box_title" type="button" style="padding: 9px 20px;margin-right:15px;margin-bottom:15px;" >Export To CSV</button>
					</div>
				</div>
			</form>
			<?php if($this->session->flashdata('message')){ ?>
				<div class="row" style="margin-bottom:0px;">
					<div class="col-md-12 col-sm-12 col-xs-12" id="spr" style="color: green;">
						<?php echo $this->session->flashdata('message');?>
					</div>
				</div>
			<?php } ?>
			<div class="row">

				<div class="col-md-12">

					<div class="table-responsive">

						<table class="table table-bordered">

							<thead>

								<tr>

									<th>Payment Order Id</th>
									<th>Ticket Category</th>
									<th>Event Name</th>
									<th>Sub Event Name</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Transaction ID</th>
									<th>Scanned</th>
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
                        <td><?php
                                if( $get_value['price'] ) { ?>
                                   <a href="<?php echo $this->config->item('base_url');?>frontend/manage_orders/view_order/<?php echo  $get_value['order_id'];?>">#<?php echo ltrim($get_value['order_id'], '0');?></a>
                            <?php
                                } else {
                                    echo '';
                                }
                            ?>
                        </td>
						<td><?php echo $get_value['ticket_name']; ?></td>
						<td><?php echo $get_value['title']; ?></td>
						<td><?php echo $get_value['schedule_title']; ?></td>
						<td>
                            <?php
                                if( $get_value['price'] ) { ?>
                                <?php echo number_format($get_value['price'] * $get_value['quantity'],2); ?>
                            <?php
                                } else {
                                    echo '0.0';
                                }
                            ?>
                        </td>
                        <td><?php echo $get_value['quantity']; ?></td>
                        <?php   if( $get_value['price'] ) { ?>
                            <?php if($get_value['txn_number']=='' ){?>
                            <td>Failed</td>
                            <?php }else{ ?>
                            <td><?php echo $get_value['txn_number']; ?></td>
                            <?php } ?>
                        <?php } else { ?>
                            <td></td>
                        <?php } ?>
						<td>
							<?php
								if($get_value['ticket_scan_status'] > 0){
									echo "Yes";
								}else{
									echo "No";
								}
							?>
                        </td>
                            <?php if( $get_value['price'] ){?>
                            <td><?php if($get_value['txn_number']==''){?><a href="">View</a> <?php }else{ ?><a target="_blank" href="<?php echo base_url(); ?>/assets/tickets_generated/<?php echo $get_value['order_id']; ?>.pdf">View</a> <?php } ?>|
                            <?php
                                if($get_value['status'] != "1"){
                                    echo "Delete";
                                }else{
                            ?>
                                <?php if($get_value['is_deleted']=='0'){?>

                                    <?php if($get_value['ticket_scan_status'] == 0){ ?>
                                    <a href="" onclick="confirmAction(<?php echo $get_value['id'];?>, 'Are you sure you want to delete this ticket ?', change_ticket_status); return false;">Delete</a>
                                    <?php }else{ ?>
                                        Delete
                                    <?php } ?>

                                <?php }
                                    if($get_value['is_deleted']=='1'){?>
                                <label class="label label-danger">Deleted</label>
                                <?php } ?>
                                <?php
                                    }
                                ?>
                            </td>
                        <?php } else { ?>
                            <td></td>
                        <?php } ?>
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
		window.location = "<?php echo $this->config->item('base_url');?>index.php/frontend/tickets/manage_ticket_booking";
	}

	$(document).ready(function(){
		$('#export_to_csv').click(function(){
		    $('form').attr('action','<?php echo base_url(); ?>frontend/tickets/export_csv');
		    $('form').submit();
		});

		$('#seach_rec').click(function(){
			$('form').attr('action','');
			$('form').submit();
		});
	});
</script>
<?php if(isset($_POST)){ //print_r($_POST);?>
<script>
	$(document).ready(function(){
       var post_event_id = "<?php echo $_POST['eid']; ?>";
       var post_subevent_id = "<?php echo $_POST['sub_eid']; ?>";
       get_subs(post_event_id,post_subevent_id);
			function get_subs(post_event_id,post_subevent_id){
			if(post_event_id != ""){
				$("#select_sub_event").load("<?php echo base_url(); ?>index.php/frontend/events/get_subs/"+post_event_id+"/"+post_subevent_id);
            }else{
				$('#select_sub_event option').remove();
			}
		}
	});
</script>
<?php } ?>