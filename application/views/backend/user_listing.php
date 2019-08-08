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
			url: "<?php echo base_url(); ?>index.php/backend/users/update_user_status",
			data: "user_id="+result+"&status="+status,
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
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Manage Users</a></div>
                    </div>
                   </div>
                   <div class="row">
                       <div class="col-lg-12 col-md-12">
                       <div class="white_box_two">
                            <div class="blue_top">
                            	Search Individual User
                            </div>
                            <div class="white_box_content">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-inline" role="form" method="post" action="<?php echo $this->config->item('admin_users');?>" name="user_list_form" id="user_list_form">
                                	<div class="form-group contractor_group">
                                     <label for="email" class="space_right">Search Individual User</label>
									 <select class="space_right form-control" id="searchby" name="searchby" required>
										<option value="">-- Please Select --</option>
										<option value="first_name" <?php if($selected_filter == 'first_name'){ echo " selected";}else{ echo "";}?>>First Name</option>
										<option value="last_name" <?php if($selected_filter == 'last_name'){ echo " selected";}else{ echo "";}?>>Last Name</option>
										<option value="email" <?php if($selected_filter == 'email'){ echo " selected";}else{ echo "";}?>>Email</option>
										<option value="status" <?php if($selected_filter == 'status'){ echo " selected";}else{ echo "";}?>>Status</option>										
									 </select>
                                     <input value="<?php if(isset($_POST['keyword'])){echo $_POST['keyword'];} ?>" type="text" class="form-control" id="keyword" name="keyword" required>
                                     <button type="submit" class="btn btn-primary">Search</button>                                  
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
						<div class="col-lg-2 col-md-3 col-sm-5 col-xs-7" style="margin: 5px;">
							<label for="email">Total Records: </label>&nbsp;&nbsp;<?php echo $total_records;?>
						</div>
                    </div>
					</form>
                    <div class="row">
                   <div class="col-md-12">
                   <div class="blue_top">User Listing</div>
                   <div class="table-responsive table_white_box">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>User Id</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Preferred Name</th>
								<th>Email</th>
								<th>Status</th>
								<th>Action</th>

								
							</tr>
						</thead>
                        <tbody>
							<?php 
						foreach($listing_data as $user_data){ ?>
							<tr>
								<td><?php echo $user_data['id'];?></td>
								<td><?php echo $user_data['first_name'];?></td>
								<td><?php echo $user_data['last_name'];?></td>
								<td><?php echo $user_data['preffered_name'];?></td>
								<td><?php echo $user_data['email'];?></td>
								
								<td><?php if($user_data['status']){ echo "Active"; }else{ echo "In-Active"; }?></td>								
								<td>
								    <?php if($user_data['status']=='1'){ $link="deactivate_user";$link_name="Deactivate"; } if($user_data['status']=='0'){ $link="activate_user";$link_name="Activate"; }?>
									 <a href="<?php echo base_url(); ?>index.php/backend/users/user_view/<?php echo $user_data['id'];  ?>">View</a> | <a href="#" onclick="confirmAction(<?php echo $user_data['status'];?>,<?php echo $user_data['id'];?>, 'Update  status?', changeStatus); return false;"><?php echo $link_name; ?> </a>
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
                   </div>
				   <br class="clear">
                   </div>
               </div>
			   
<script>
	function page_count_check(){
		 document.getElementById("user_list_form").submit();
	}
</script>