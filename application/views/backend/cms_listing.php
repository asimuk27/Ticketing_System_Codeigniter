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
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Manage CMS</a></div>
                    </div>
                </div>			   
                <div class="row margin_top">
                   <div class="col-md-12">
                   <div class="blue_top">CMS Listing</div>
				   
				     <div class="row">
						<a type="button" href="<?php echo $this->config->item('admin_add_cms');?>" class="btn btn-primary pull-left" style="margin-left: 15px;">Add New</a>
					</div>
					  <?php if($this->session->flashdata('message') != ''){ ?>
							<div class="row" style="margin-bottom:5px;">								
								<div class="col-md-9" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
								</div>
							</div>	
						<?php } ?>
						
                   <div class="table-responsive table_white_box">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Title</th>
								<th>Content Key</th>								
								<th>Created Date</th>								
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
                        <tbody>
							<?php 
						foreach($listing_data as $user_data){ ?>
							<tr>
								<td><?php echo $user_data['id'];?></td>
								<td><?php echo $user_data['title'];?></td>
								<td><?php echo $user_data['content_key'];?></td>								
								<td><?php echo $user_data['created_date'];?></td>							
								<td><?php if($user_data['status']){ echo "Active"; }else{ echo "Active"; }?></td>	
								<td>
									<a href="<?php echo $this->config->item('admin_edit_cms').'?id='.$user_data['id']?>">Edit</a> | <a href="#">Delete</a>
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