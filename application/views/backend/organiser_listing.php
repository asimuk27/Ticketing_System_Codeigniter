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
			url: "<?php echo $this->config->item('update_organiser_status');?>",
			data: "organiser_id="+result+"&status="+status,
			success: function(Rid1) {
				if (Rid1) {
					location.reload();
					alertify.success("status updated succsessfully");
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
  <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="#">Manage Organization</a></div>
                    </div>
                   </div>
                   <div class="row">
                       <div class="col-lg-12 col-md-12">
                       <div class="white_box_two">
                            <div class="blue_top">
                            	Search Organization
                            </div>
                            <div class="white_box_content">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-inline" role="form" method="post" action="<?php echo $this->config->item('admin_organiser');?>" name="user_list_form" id="user_list_form">
                                	<div class="form-group contractor_group">
                                     <label for="email" class="space_right">Search</label>
									 <select class="space_right form-control" id="searchby" name="searchby" required>
										<option value="">-- Please Select --</option>
										
										<option value="organization_name" <?php if($selected_filter == 'organization_name'){ echo " selected";}else{ echo "";}?>>Organization Name</option>
										
										<option value="first_name" <?php if($selected_filter == 'first_name'){ echo " selected";}else{ echo "";}?>>First Name</option>
										
										<option value="email" <?php if($selected_filter == 'email'){ echo " selected";}else{ echo "";}?>>Email</option>
										
										<option value="phone" <?php if($selected_filter == 'phone'){ echo " selected";}else{ echo "";}?>>Phone</option>
										
										<option value="status" <?php if($selected_filter == 'status'){ echo " selected";}else{ echo "";}?>>Status</option>										
									 </select>
                                     <input value="<?php if(isset($_POST['keyword'])){echo $_POST['keyword'];} ?>" type="text" class="form-control" id="keyword" name="keyword" required>
                                     <button type="submit" class="btn btn-primary">Search</button>                                  
                                  	</div>
                                </form>
                                </div>
                            </div> 
                       </div>
                    </div>
			  </div>
                    <div class="row margin_top margin_bottom">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 ">
							<label for="email">Total Records: </label>&nbsp;&nbsp;<?php echo $total_records;?>
							&nbsp;<label for="email">Pending For Approval: </label>&nbsp;&nbsp;<a href="#" style="color:#000;"onclick="get_pending_list();"><?php echo $pending_count;?></a>
						</div>
                    </div>
                    <div class="row">
                   <div class="col-md-12">
                   <div class="blue_top">Organization Listing</div>
				  
				  <?php if($this->session->flashdata('message') != ''){ ?>
					<div class="row">
						<div class="col-md-12" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
						</div>
					</div>	
				  <?php } ?>
                  
				  <div class="table-responsive table_white_box">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Unique Id</th>
								<th>Organisation Name</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<!--<th>Phone</th>-->
								<th>Status</th>								
								<th>Action</th>
							</tr>
						</thead>
                        <tbody>
							<?php 
						foreach($listing_data as $user_data){ 
						
						?>
							<tr>
								<td><?php echo $user_data['id'];?></td>
								<td><?php echo $user_data['organization_name'];?></td>
								<td><?php echo $user_data['first_name'];?></td>
								<td><?php echo $user_data['last_name'];?></td>
								<td><?php echo $user_data['email'];?></td>
								<!--<td><?php if($user_data['phone'] == 0){ echo "";}else{ echo $user_data['phone'];}?></td>-->								
								<td>
									<?php 
										if($user_data['status'] == "1"){ 
											echo "Active";
										}else if($user_data['status'] == "0"){ 
											echo "In-Active"; 
										}else if($user_data['status'] == "2"){ 
											echo "Pending"; 
										}									
										?></td>
								<td>									
									<a href="#" onclick="edit_page(<?php echo $user_data['organization_id'];?>);">Edit</a> | <a href="#" onclick="view_page(<?php echo $user_data['organization_id'];?>);">View</a> | <a href="#" onclick="confirmAction(<?php echo $user_data['status'];?>,<?php echo $user_data['organization_id'];?>, 'Update organization status?', changeStatus); return false;">
										<?php if($user_data['status'] == 1){
											echo "Deactivate";
										}else{
											echo "Activate";
										}?>
									</a>  
								</td>
							</tr>   
							<?php } ?>
                        </tbody>
                     </table>
                     </div>
                   </div>
                   </div>
				   <br class="clear">
				   <div class="row">
                   <div class="col-md-12">
						<?php echo $this->pagination->create_links(); ?>
                   </div>
                   </div>
                   </div>
               </div>
			   
<script>
	function get_pending_list(){
		document.getElementById("searchby").value = "status";
		document.getElementById("keyword").value = "2";
		document.getElementById("user_list_form").submit();// Form submission
	}
	function view_page(id){
		window.location.href = '<?php echo $this->config->item('view_organiser_profile')."/";?>'+id;
	}
	
	function edit_page(id){
		window.location.href = '<?php echo $this->config->item('edit_organiser_profile')."/";?>'+id;
	}
</script>