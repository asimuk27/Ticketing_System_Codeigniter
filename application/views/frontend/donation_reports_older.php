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
					</div>										<div class="col-md-1">
						 						<button class="blue_box_title" type="submit" style="padding: 9px 20px;margin-bottom:15px;">Search</button>
														</div>
													<div class="col-md-1">
														<button onclick ="go_to_location();" class="blue_box_title" type="button" style="padding: 9px 20px;margin-bottom:15px;" >Reset</button>

									</div>

									<div class="col-md-2">
										<button  id="download" class="blue_box_title" type="button" style="padding: 9px 20px;margin-bottom:15px;" >Export to Csv</button>

					</div>
				</div>

			</form>
			<div class="row">

				<div class="col-md-12">

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
						<td><?php echo $get_value['donation_amount']; ?></td>
						<?php $n_date=date("d-m-Y",strtotime($get_value['created_date'])); ?>
						<td><?php echo $n_date; ?></td>
						<td><a href="<?php echo base_url(); ?>index.php/frontend/donation_reports/view_organiser_donations/<?php echo $get_value['donation_id'];?>">View</a>				</td>

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



    <?php $csv='<table id="importantData" border="1">';
   
           //echo "<pre>";print_r($data);exit;
            $m=1;
						$csv.=' <tr><th>Charity Name</th><th>Event Name</th><th>SubEvent Name</th><th>Champion Page Title</th><th>Display Name</th><th>Donation To (email)</th><th>Amount Donated ($)</th><th>Message</th><th>Donation Date</th><th>Donating as</th><th>Orginisation Name</th><th>Doner Salutation</th><th>Doner Name</th><th>Donor Email</th><th>Phone</th><th>Street</th><th>Suburb</th><th>City</th><th>Post Code</th><th>Country</th><th>Communication</th><th>Payment Method</th><th>Order Id (internal)</th><th>PaymentId (internal)</th><th>Transaction Id (external)</th><th>Transaction Date</th><th>Transaction Status</th><th>Payment other</th></tr>';
					 foreach($data as $get_value){

					 $csv.='<tr><td>'.$get_value["org_charity_name"].'</td>';
					 $csv.='<td>'.$get_value["event_name"].'</td>';
			  	 $csv.='<td>'.$get_value["sub_event_name"].'</td>';
			  	 $csv.='<td>'.$get_value["title"].'</td>';
			  	 $csv.='<td>'.$get_value["title"].'</td>';
			  	 $csv.='<td>'.$get_value["users_email"].'</td>';
			  	 $csv.='<td>'.$get_value["donation_amount"].'</td>';
			  	 $csv.='<td>'.$get_value["donation_message"].'</td>';
					 $csv_date=date("d-m-Y",strtotime($get_value['created_date']));
			  	 $csv.='<td>'.$csv_date.'</td>';
					 $csv.='<td>'.$get_value["donor_name"].'</td>';
					 $csv.='<td>'.$get_value["organization_name"].'</td>';
					 $csv.='<td>'.$get_value["salutation"].'</td>';
					 $csv.='<td>'.$get_value["first_name"].'</td>';
					 $csv.='<td>'.$get_value["donation_email"].'</td>';
					 $csv.='<td>'.$get_value["donation_phone"].'</td>';
					 $csv.='<td>'.$get_value["donation_street"].'</td>';
					 $csv.='<td>suburb</td>';
					 $csv.='<td>'.$get_value["py_city"].'</td>';
					 $csv.='<td>'.$get_value["py_postal_code"].'</td>';
					 $csv.='<td>'.$get_value["donation_country"].'</td>';
					 $csv.='<td>'.$get_value["communication_required"].'</td>';
					 $csv.='<td>0</td>';
					 $csv.='<td>'.$get_value["donation_order_id"].'</td>';
					 $csv.='<td>'.$get_value["donation_order_id"].'</td>';

					 $csv.='<td>'.$get_value["txn_number"].'</td>';
					 $csv.='<td>'.$get_value["txn_date"].'</td>';
					 $csv.='<td>'.$get_value["txn_status"].'</td></tr>';


					}

         $csv.='</table>';


		?>

		<div id="csv_result" style="display:none;"><?php echo $csv; ?></div>







</div><!--Content-->


<style>
	.odd{background:#f9f9f9;}
	.even{background:#ffffff;}
</style>

<script>
	function go_to_location(){
		window.location = "<?php echo $this->config->item('base_url');?>index.php/frontend/donation_reports/";
	}
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
<script>
$(document).ready(function(){

	$('#download').click(function(){
		var csv_data=$('#csv_result').html();
	//	alert(csv_data);
		 exportTableToCSV( $('#csv_result') , 'donation_reports.csv' );
 });

 $('#download2').click(function(){
		 now = new Date;
		 now = now.toISOString().split('T')[0];

		 exportTableToCSV( $('#importantData') , 'importantData_'+now+'.csv' );
 });

 $('#download3').mouseenter(function(){
		 now = new Date;
		 now = now.toISOString().split('T')[0];

		 exportTableToCSV( $('#importantData') , 'importantData_'+now+'.csv' );
 });

 function exportTableToCSV($table, filename) {

		 var $rows = $table.find('tr:has(td),tr:has(th)'),

				 // Temporary delimiter characters unlikely to be typed by keyboard
				 // This is to avoid accidentally splitting the actual contents
				 tmpColDelim = String.fromCharCode(11), // vertical tab character
				 tmpRowDelim = String.fromCharCode(0), // null character

				 // actual delimiter characters for CSV format
				 colDelim = '","',
				 rowDelim = '"\r\n"',

				 // Grab text from table into CSV formatted string
				 csv = '"' + $rows.map(function (i, row) {
						 var $row = $(row),
								 $cols = $row.find('th,td');

						 return $cols.map(function (j, col) {
								 var $col = $(col),
										 text = $col.text();

								 return text.replace(/"/g, '""'); // escape double quotes

						 }).get().join(tmpColDelim);

				 }).get().join(tmpRowDelim)
						 .split(tmpRowDelim).join(rowDelim)
						 .split(tmpColDelim).join(colDelim) + '"',

				 // Data URI
				 //blob = new Blob([csv], { type: 'text/csv' }); //new way
				 //var csvUrl = URL.createObjectURL(blob);

				csvUrl = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

				 var link = document.createElement("a");
				 link.download = filename;
				 link.href = csvUrl;
				 link.click();
				 link.remove();
	

 }

});
</script>
