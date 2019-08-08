<!--<script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>
<style>
	.table-bordered th{padding:10px !important;}
	.table-bordered td{padding:10px !important;}
	.odd{background:#f9f9f9;}
	.even{background:#ffffff;}
</style>
<div class="content">
	<div class="sub-header">
	</div>
	<div class="Kode-page-heading">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>Sponsor Request Listing</h2>
				</div>				
			</div>
			<!--ROW END-->
		</div>
	</div>
	<!--Kode-our-speaker-heading End-->
	<div class="kode-blog-style-2 search_table" style="min-height:500px;">
		<div class="container">
			<div class="row" style="margin-bottom:0px;"> 
				<form method="post" action="" id="sponsor_request_search" name="sponsor_request_search" action="<?php echo base_url();?>index.php/frontend/events/sponsor_request_listing">
					<div class="col-sm-3">			
						<select class="form-control dropdown" id="event_list"  name="event_list"> 
							<option value="">-- All Events --</option>	
							<?php foreach($event_list_data as $event_data){ ?>
								<option value="<?php echo $event_data['event_id'];?>" <?php if(isset($_POST['event_list']) &&  ($_POST['event_list'] == $event_data['event_id'])){ echo "selected";}?>><?php echo $event_data['event_name'];?></option>	
							<?php }?>
						</select>  
					</div>
					<div class="col-sm-3">
						<input style="background:white none repeat scroll 0 0;" class="form-control" type='text' name='search_date' id='search_date' value="<?php if(isset($_POST['search_date'])){echo $_POST['search_date'];} ?>" placeholder="Date" readonly="readonly"/>  
					</div>					
					<div class="col-sm-3">
						<input type='text' class="form-control" name='search_text' id='search_text' value="<?php if(isset($_POST['search_text'])){echo $_POST['search_text'];} ?>" placeholder="Name Or Organisation Name" />   
					</div>					
					<div class="col-md-3 col-sm-6">   
						<button class="blue_box_title" type="submit" style="padding: 9px 29px;margin-bottom:15px;margin-right: 20px;">Search</button>   					
						<button onclick="fr_fresh();" class="blue_box_title" type="button" style="padding: 9px 29px;margin-bottom:15px;">Reset</button>   
					</div>						
			</div>  
			<div class="row" style="margin-bottom:0px;">
				<div class="col-sm-1">
					<label style="padding:10px;">Records</label>
				</div>
				<div class="col-sm-1">				
                    <select class="form-control dropdown" id="per_page" name="per_page" onchange="page_count_check();">
						<option value="5" <?php if($page_count  == '5'){ echo " selected";}else{ echo "";}?>>5</option>
						<option value="10" <?php if($page_count  == '10'){ echo " selected";}else{ echo "";}?>>10</option>
						<option value="20" <?php if($page_count  == '20'){ echo " selected";}else{ echo "";}?>>20</option>
						<option value="30" <?php if($page_count  == '30'){ echo " selected";}else{ echo "";}?>>30</option>
						<option value="40" <?php if($page_count  == '40'){ echo " selected";}else{ echo "";}?>>40</option>
						<option value="50" <?php if($page_count  == '50'){ echo " selected";}else{ echo "";}?>>50</option>
                    </select>
                </div>
            </div>			
			</form>
			   <?php if($this->session->flashdata('message') != ''){ ?>
					<div class="row">
						<div class="col-md-12" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
						</div>
					</div>	
				  <?php } ?>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Received Date</th>									
									<th>First Name</th>
									<th>Last Name</th>
									<th>Organisation Name</th> 
									<th>Email</th>
									<th>Contact No</th>
									<th style="width:15%">Sponsorship Type</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody>
								<?php 
								if(count($data) > 0){
								$i = 0;
								foreach($data as $get_value){ 
						if($i % 2 == 0) {	$class = "even"; }else{	$class="odd"; }
								?>
								<tr class="<?php echo $class;?>">
									<td><?php echo date("d-m-Y", strtotime($get_value['created_date']));?></td>		
									<td><?php echo $get_value['first_name']; ?></td>
									<td><?php echo $get_value['last_name']; ?></td>
									<td><?php echo $get_value['organisation_name']; ?></td> 
									<td><?php echo $get_value['contact_email']; ?></td>
									<td><?php echo $get_value['contact_number']; ?></td>
									<td style="width:15%"><?php echo $get_value['sponsor_type']; ?></td>
									<td><a href="#" onclick="confirmAction(<?php echo $get_value['id'];?>,'Are you sure you want to delete this request?', delete_request); return false;">Delete</a></td>								
								</tr>
								<?php $i++; } }else{
									?><tr><td colspan="8"><?php echo "No records are available";?></td></tr><?php
								 } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="pag">
                <div class="col-md-12">
					<?php echo $this->pagination->create_links(); ?>
                </div>
            </div>			
		</div>
	</div>
</div><!--Content-->
<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>
<script type="text/javascript">
	$("#search_date").datepicker({
	  changeMonth: true,
      changeYear: true,
	  dateFormat: 'dd-mm-yy',	 
      maxDate: '0d'
    });	

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
  

  function delete_request(result){
    $.ajax({
      type: "POST",
	  dataType: 'json',
      url: '<?php echo $this->config->item('base_url');?>index.php/frontend/events/delete_sponsor_request',
	  data: "request_id="+result,
      success: function(Rid1) {
        if (Rid1) {
          location.reload();
          alertify.success("record deleted successfully");
        }else{         
          alertify.error("error in deleting record");
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
  
  function page_count_check(){
	document.getElementById("sponsor_request_search").submit();
 }
 
 function fr_fresh(){
	 window.location = "<?php echo base_url();?>frontend/events/sponsor_request_listing";		
 }
</script>




