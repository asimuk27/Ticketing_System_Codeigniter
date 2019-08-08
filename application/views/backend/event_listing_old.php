<script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('user_list_form').action = jQuery(this).attr('href');
			jQuery('#user_list_form').submit();   
			e.preventDefault();
		});
	});
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
                            	Search Events
                            </div>
                            <div class="white_box_content">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-inline" role="form" method="post" action="<?php echo $this->config->item('admin_events');?>" name="user_list_form" id="user_list_form">
                                	<div class="form-group contractor_group">
                                     <label for="email" class="space_right">Search User</label>
									 <select class="space_right form-control" id="searchby" name="searchby" required>
										<option value="">-- Please Select --</option>
										<option value="location" <?php if($selected_filter == 'location'){ echo " selected";}else{ echo "";}?>>Location</option>
										<option value="title" <?php if($selected_filter == 'title'){ echo " selected";}else{ echo "";}?>>Title</option>
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
						<div class="col-lg-2 col-md-3 col-sm-5 col-xs-7 ">
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
								<th>Organiser Name</th>
								<th>Title</th>
								<th>Location</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Status</th>								
								<th>Action</th>
							</tr>
						</thead>
                        <tbody>
							<?php 
						foreach($listing_data as $user_data){ ?>
							<tr>
								<td><?php echo $user_data['id'];?></td>
								<td><?php echo $user_data['organiser_id'];?></td>
								<td><?php echo $user_data['title'];?></td>
								<td><?php echo $user_data['location'];?></td>
								<td><?php echo $user_data['start_date'];?></td>
								<td><?php echo $user_data['end_date'];?></td>								
								<td><?php if($user_data['status']){ echo "Active"; }else{ echo "In-Active"; }?></td>
								<td>
									<a href="#">Edit</a> | <a href="#">View</a> | <a href="#">Delete</a>
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
                   </div>
               </div>