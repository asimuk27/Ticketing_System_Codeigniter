<script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('admin_user_list_form').action = jQuery(this).attr('href');
			jQuery('#admin_user_list_form').submit();   
			e.preventDefault();
		});
	});
</script>

 <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Manage Admin Users</a></div>
                    </div>
                   </div>
                   <div class="row">
                       <div class="col-lg-12 col-md-12">
                       <div class="white_box_two">
                            <div class="blue_top">
                            	Search Admin User
                            </div>
                            <div class="white_box_content">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-inline" role="form" method="post" action="<?php echo $this->config->item('admin_user');?>" name="admin_user_list_form" id="admin_user_list_form">
                                	<div class="form-group contractor_group">
                                     <label for="email" class="space_right">Search Admin User</label>
									 <select class="space_right form-control" id="searchby" name="searchby" required>
										<option value="">-- Please Select --</option>
										<option value="name" <?php if($selected_filter == 'name'){ echo " selected";}else{ echo "";}?>>Name</option>										
										<option value="email" <?php if($selected_filter == 'email'){ echo " selected";}else{ echo "";}?>>Email</option>
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
					<button class="btn btn-primary" onclick="location.href='<?php echo $this->config->item("add_admin_user"); ?>'" type="button">Add New</button>
                    <div class="row"> <br class="clear"> </div>
					<div class="row">
                   <div class="col-md-12">
                   <div class="blue_top">Admin User Listing</div>
				   
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
								<th>User Id</th>
								<th>Name</th>
								<th>Email</th>
								<th>Last Login</th>								
								<th>Status</th>	
								<th>Action</th>
							</tr>
						</thead>
                        <tbody>
							<?php 
							if(count($listing_data) > 0){
						foreach($listing_data as $user_data){ ?>
							<tr>
								<td><?php echo $user_data['id'];?></td>
								<td><?php echo $user_data['name'];?></td>								
								<td><?php echo $user_data['email'];?></td>
								<td><?php echo $user_data['last_login']; ?></td>
								<td><?php if($user_data['status']){ echo "Active"; }else{ echo "In-Active"; }?></td>
								<td><a href="#" title="In-Progress">Deactivate</a></td>
							</tr>   
							<?php }
							
							}else{ ?>
								<tr><td colspan="6">No records available</td></tr>
							<?php }?>
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
		 document.getElementById("admin_user_list_form").submit();
	}
</script>