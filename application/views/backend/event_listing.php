<script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('user_list_form').action = jQuery(this).attr('href');
			jQuery('#user_list_form').submit();   
			e.preventDefault();
		});
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
	
	function changeStatus(result){		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('set_event_as_popular');?>",
			data: "event_id="+result,
			success: function(Rid1) {
				if (Rid1) {
					location.reload();
					alertify.success("event marked as popular");
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
	
	function changePopularity(result){		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('disable_event_as_popular');?>",
			data: "event_id="+result,
			success: function(Rid2) {
				if (Rid2) {
					location.reload();
					alertify.success("event marked as non-popular");
				}else{					
					alertify.error("error in updating status");
				}
			}
		}); 
	}
	function changeStats(result){		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('set_event_as_active');?>",
			data: "event_id="+result,
			success: function(Rid2) {
				if (Rid2) {
					location.reload();
					alertify.success("Event Marked As Active");
				}else{					
					alertify.error("error in updating status");
				}
			}
		}); 
	}
	function disableActive(result){		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('set_event_as_inActive');?>",
			data: "event_id="+result,
			success: function(Rid2) {
				if (Rid2) {
					location.reload();
					alertify.success("Event Is Deactive");
				}else{					
					alertify.error("error in updating status");
				}
			}
		}); 
	}
</script>


  <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Manage Events</a></div>
                    </div>
                   </div>
				   <div class="row">
                       <div class="col-lg-12 col-md-12">
                       <div class="white_box_two">
                            <div class="blue_top">
                            	Search
                            </div>
                            <div class="white_box_content">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-inline" role="form" method="post" action="<?php echo $this->config->item('admin_events');?>" name="user_list_form" id="user_list_form">
                                	<div class="form-group contractor_group">
                                     <label for="email" class="space_right" style="margin-left:38px;">Search</label>				

		
<select class="space_right form-control" id="searchby" name="searchby" style="margin-right:0px;">										
	<option value="">-- Please Select Category--</option>
		<?php foreach($categories as $category){ ?>
			<option value="<?php echo $category['id']; ?>" <?php if((isset($_POST['searchby'])) && ($_POST['searchby'] == $category['id'])){ echo "selected";}?>><?php echo $category['category_name']; ?>
			</option><?php  }?>
</select>
                                     <input value="<?php if(isset($_POST['keyword'])){echo $_POST['keyword'];} ?>" type="text" class="form-control" id="keyword" name="keyword" placeholder="Search for event name" >
                                                                      
                                  	</div>
									
									<div class="form-group contractor_group">
									<input value="<?php if(isset($_POST['keyword1'])){echo $_POST['keyword1'];} ?>" type="text" class="form-control" id="keyword1" name="keyword1" placeholder="City or Location" >
									<input value="<?php if(isset($_POST['keyword2'])){echo $_POST['keyword2'];} ?>" type="text" class="form-control" id="keyword2" name="keyword2" placeholder="Organization Name" >
									</div>
									
									<div class="form-group contractor_group">
									 <label class="space_right">&nbsp;</label>
									<button type="submit" class="btn btn-primary" style="margin-left:80px;">Search</button> 
									</div>									
                               
                                </div>
                            </div> 
                       </div>
                    </div>
			  </div>
                    <div class="row margin_top margin_bottom">
						<div class="col-lg-2 col-md-3 col-sm-5 col-xs-7" style="margin: 5px;">
							<label for="">Records per page</label>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
							<select class="form-control" id="page_count" name="page_count" onchange="page_count_check();">
								<option value="5" <?php if($page_count  == '5'){ echo " selected";}else{ echo "";}?>>5</option>
								<option value="10" <?php if($page_count == '10'){ echo " selected";}else{ echo "";}?>>10</option>
								<option value="20" <?php if($page_count == '20'){ echo " selected";}else{ echo "";}?>>20</option>
								<option value="30" <?php if($page_count == '30'){ echo " selected";}else{ echo "";}?>>30</option>
								<option value="40" <?php if($page_count == '40'){ echo " selected";}else{ echo "";}?>>40</option>
								<option value="50" <?php if($page_count == '50'){ echo " selected";}else{ echo "";}?>>50</option>
							</select>
						</div> 
						 </form>
						<div class="col-lg-2 col-md-3 col-sm-5 col-xs-7 " style="margin: 5px;">
							<label for="email">Total Records: </label>&nbsp;&nbsp;<?php echo $total_records;?>
						</div>
                    </div>
                    <div class="row">
                   <div class="col-md-12">
                   <div class="blue_top">Events Listing</div>
                   <div class="table-responsive table_white_box">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Event Id</th>
								<!--<th>Organiser Name</th>-->
								<th>Event Title</th>								
								<th>Location</th>
								<th>Start Date</th>
								<th>End Date</th>
								<!--<th>Status</th>-->					
								<th>Status</th>
								<th>Action </th>
								
							</tr>
						</thead>
                        <tbody>
							<?php 
						foreach($listing_data as $user_data){ 
						    
						    
						   if( $user_data['admin_status']=='1'){

		$img="active.png";
		}else{
		$img="activi-1.png";
	}

	if($user_data['admin_status']=='0'){

		$img1="deactive.png";
	}else{
		$img1="deactive1.png";
	}
						?>
							<tr>
								<td><?php echo $user_data['id'];?></td>
								<!--<td><?php //echo $user_data['organiser_id'];?></td>-->
								<td><?php echo $user_data['title'];?></td>
								<td><?php echo substr($user_data['event_location'],0,20);?></td>
								<td><?php echo date("d-m-Y", strtotime($user_data['event_start_date']));?></td>
								<td><?php echo date("d-m-Y", strtotime($user_data['event_end_date']));?></td>	
								<td>
									<?php 
										if($user_data['status']==1){
											echo "published";
										}else if($user_data['status']==2){
											echo "unpublished";
										}else if($user_data['status']==3){
											echo "suspended";
										}else if($user_data['status']==4){
											echo "closed";
										}else if($user_data['status']==5){
											echo "cancelled";
										}
									?>
								</td>
								<td>
									<a href="<?php echo $this->config->item('admin_view_events').'/'.$user_data['id']; ?>">View</a> 
									<a href="#" onclick="javascript:changeStats(<?= $user_data['id'] ?>);" ><img src="<?php echo $this->config->item('admin_image_path');?>/icons/<?= $img ?>" title="Active"></a> <a href="#" onclick="javascript:disableActive(<?= $user_data['id'] ?>);" ><img src="<?php echo $this->config->item('admin_image_path');?>/icons/<?= $img1 ?>" title="Deactive"></a>
								</td>
							</tr>   
							<?php } ?>
                        </tbody>
                     </table>
                     </div>
                   </div>
                   </div>
				   <div class="row">
                   <div class="col-md-12">
						<?php echo $this->pagination->create_links(); ?>
                   </div>
                   </div><br class="clear">
                   </div>
               </div>
<script>
	function page_count_check(){
		 document.getElementById("user_list_form").submit();
	}
</script>