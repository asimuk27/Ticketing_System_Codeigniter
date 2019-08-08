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
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="#">Manage Organization Submissions</a></div>
                    </div>
                   </div>
                   <div class="row">
                       <div class="col-lg-12 col-md-12">
                       <div class="white_box_two">
                            <div class="blue_top">
                            	Search Organization Submissions
                            </div>
                            <div class="white_box_content">
                            	<div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-inline" role="form" method="post" action="<?php echo $this->config->item('');?>" name="user_list_form" id="user_list_form">
                                	<div class="form-group contractor_group">
                                     <label for="email" class="space_right">Search</label>
									 <select class="space_right form-control" id="searchby" name="searchby" required>
										<option value="">-- Please Select --</option>
										
										<option value="organization_name" <?php if($selected_filter == 'organization_name'){ echo " selected";}else{ echo "";}?>>Organization Name</option>
										
										<option value="first_name" <?php if($selected_filter == 'first_name'){ echo " selected";}else{ echo "";}?>>First Name</option>
										
										<option value="email" <?php if($selected_filter == 'email'){ echo " selected";}else{ echo "";}?>>Email</option>
										
										<option value="phone" <?php if($selected_filter == 'phone'){ echo " selected";}else{ echo "";}?>>Phone</option>
																		
									 </select>
                                     <input value="<?php if(isset($_POST['keyword'])){echo $_POST['keyword'];} ?>" type="text" class="form-control" id="keyword" name="keyword" required>
                                     <button type="button" class="btn btn-primary">Search</button>                                  
                                  	</div>
                                </form>
									
                                </div>
                            </div> 
                       </div>
                    </div>
			  </div>
                    <div class="row margin_top margin_bottom">
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 ">
							<button class="btn btn-primary" onclick="location.href='<?php echo $this->config->item("add_agent_organization"); ?>'" type="button">Add New</button>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" style="margin:5px;">
							<label for="email">Total Records: </label>&nbsp;&nbsp;<?php echo $total_records;?>							
						</div>						
                    </div>
                    <div class="row">
                   <div class="col-md-12">
                   <div class="blue_top">Organization Submission Listing</div>				  
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
								<th>Agent Id</th>
								<th style="width:17%;">Organization Name</th>
								<th>Name</th>
								<th>Logo</th>
								<th>Sig</th>
								<th>TS</th>
								<th>POLI</th>	
								<th>DD</th>	
								<th>Bank 1</th>	
								<th>Bank 2</th>	
								<th>Action</th>
							</tr>
						</thead>
                        <tbody>
							<?php 
								foreach($listing_data as $user_data){ 
								$i = 0;
							?>
							<tr>
								<td>1</td>
								<td style="width:17%;"><?php echo $user_data['organization_name'];?></td>
								<td><?php if($user_data['first_name'] == ""){ echo "No";$i++; }else{ echo "Yes";}?></td>								
								<td><?php if($user_data['logo'] == ""){ echo "No";$i++; }else{ echo "Yes";}?></td>
								<td><?php if($user_data['signature'] == ""){ echo "No";$i++; }else{ echo "Yes";}?></td>
								<td><?php if($user_data['tc'] == "0"){ echo "No";$i++; }else{ echo "Yes";}?></td>
								<td><?php if($user_data['poli_tc'] == "0"){ echo "No";$i++; }else{ echo "Yes";}?></td>
								<td><?php if($user_data['dd_tc'] == "0"){ echo "No";$i++; }else{ echo "Yes";}?></td>
								<td><?php if($user_data['bank1'] == ""){ echo "No";$i++; }else{ echo "Yes";}?></td>
								<td><?php if($user_data['bank2'] == ""){ echo "No";$i++; }else{ echo "Yes";}?></td>
								<td>
									<a href="<?php echo base_url(); ?>index.php/backend/set_organizations/edit_organisation_submission/<?php echo $user_data['organization_id'];?>">Edit</a> |								
									<?php if($i > 0){ ?>
										<a href="#" onclick="sent_email_func('<?php echo $user_data['id']?>');">Email</a> |
									<?php }else{ ?>
										Email |
									<?php } ?>	
									<?php if($i > 0){ ?>
										OK
									<?php }else{ ?>
										<a href="#" onclick="confirmAction(<?php echo $user_data['id'];?>, 'Are you sure to send this organization for approval ?', changeStatus); return false;">OK</a>  
									<?php } ?>									
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
			url: "<?php echo $this->config->item('base_url');?>index.php/backend/set_organizations/sent_charity_to_pending",
			data: "organiser_id="+result,
			cache: false, 
			success: function(Rid1) {
				if (Rid1) {
					location.reload();
					alertify.success("sent to pending successfully");
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
	
	function sent_email_func(event_id){
		$.ajax({
            type: "post",
			data: "event_id="+event_id,
            url: "<?php echo base_url(); ?>index.php/backend/set_organizations/sent_status_email/"+event_id,
            cache: false, 
            success: function(Rid1) {
				if (Rid1) {
					//location.reload();
					alertify.success("email successfully sent");
				}else{					
					alertify.error("error in sending email");
				}
			},
           error: function(){
            alert('Error while request..');
          }
        });
	}
	
	function get_pending_list(){
		document.getElementById("searchby").value = "status";
		document.getElementById("keyword").value = "2";
		document.getElementById("user_list_form").submit();// Form submission
	}
	function view_page(id){
		window.location.href = '<?php echo $this->config->item('view_organiser_profile')."/";?>'+id;
	}
	
	//function edit_page(id){
	//	window.location.href = '<?php echo $this->config->item('edit_organiser_profile')."/";?>'+id;
	//}
	function edit_page(id){
		window.location.href = '<?php echo $this->config->item('edit_organiser_submission_profile')."/";?>'+id;
	}
</script>