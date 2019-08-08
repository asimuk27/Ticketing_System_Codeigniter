<script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('champion_list_form').action = jQuery(this).attr('href');
			jQuery('#champion_list_form').submit();   
			e.preventDefault();
		});
	});	
</script>
  <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="#">Manage Champions</a></div>
                    </div>
                   </div>
                   <div class="row">
                       <div class="col-lg-12 col-md-12">
                       <div class="white_box_two">
                            <div class="blue_top">
                            	Search Champions
                            </div>
                            <div class="white_box_content">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-inline" role="form" method="post" action="<?php echo $this->config->item('be_champion_listing');?>" name="champion_list_form" id="champion_list_form">
                                	<div class="form-group contractor_group">
										<label for="supporter" class="space_right">Search</label>
										
										<input value="<?php if(isset($_POST['supporter'])){echo $_POST['supporter'];} ?>" type="text" class="form-control" id="supporter" name="supporter" placeholder="supporter name">
									
										<input value="<?php if(isset($_POST['organization_name'])){echo $_POST['organization_name'];} ?>" type="text" class="form-control" id="organization_name" name=	"organization_name" placeholder="organization name">
										
										<input value="<?php if(isset($_POST['event_name'])){echo $_POST['event_name'];} ?>" type="text" class="form-control" id="event_name" name="event_name" placeholder="event name">
										
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
							&nbsp;
						</div>
                    </div>
                    <div class="row">
                   <div class="col-md-12">
                   <div class="blue_top">Champions Listing</div>
				  
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
								<th>Id</th>
								<th>Name</th>
								<th>Target</th>
								<th>Raised</th>
								<th>Event</th>
								<th>Sub Event</th>
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
								<td><?php echo $user_data['display_name'];?></td>
								<td><?php echo $user_data['target_amount'];?></td>
								<td><?php echo "0";?></td>
								<td><?php echo $user_data['title'];?></td>
								<td><?php echo $user_data['schedule_title'];?></td>	
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
									  <a href="<?php echo base_url(); ?>index.php/backend/champions/view_champion/<?php echo $user_data['id']; ?>">View</a> 
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
	function view_page(id){
		window.location.href = '';
	}

</script>