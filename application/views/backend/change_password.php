<script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('user_list_form').action = jQuery(this).attr('href');
			jQuery('#user_list_form').submit();   
			e.preventDefault();
		});
	});
</script>
<style>
	label{font-weight:normal;}	
	.row p{color:red;}
	.error{color:red;}
</style>
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="right_first_box">
					<img src="<?php echo $this->config->item('admin_image_path');?>home.png">
						<a href="#">Home</a> > <a href="#">Change Password</a>
				</div>
			</div>
		</div>  				 
		<div class="row margin_top margin_bottom">
			<div class="col-md-12">
				<div class="blue_top">Change Password</div>
				<div class="table-responsive table_white_box" style="padding:25px;">
					<form method="post" action="<?php echo $this->config->item('admin_save_change_password');?>" id="change_password" name="change_password">
					<div class="col-lg-7 col-md-11">
						<?php if($this->session->flashdata('message') != ''){ ?>
							<div class="row" style="margin-bottom:5px;">
								<div class="col-md-3"><label class="control_lable">&nbsp;</label></div>
								<div class="col-md-9" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
								</div>
							</div>	
						<?php } ?>		
						<div class="row">
							<div class="col-md-3"><label class="control_lable">Old Password</label></div>
							<div class="col-md-9"><input type="password" placeholder="Enter your current password" class="inp" id="current_password" name="current_password"> <?php echo form_error('current_password'); ?></div>
						</div>
						<div class="row">
							<div class="col-md-3"><label class="control_lable">New Password</label></div>
							<div class="col-md-9"><input type="password" placeholder="Enter new password" class="inp"  id="new_password" name="new_password"> <?php echo form_error('new_password'); ?></div>
						</div>	
						<div class="row">
							<div class="col-md-3"><label class="control_lable">Confirm Password</label></div>
							<div class="col-md-9"><input type="password" placeholder="Enter confirm password" class="inp" 
							id="confirm_password" name="confirm_password"> <?php echo form_error('confirm_password'); ?></div>
						</div>						
						<br>
						<input type="submit" value="Change Password" class="btn btn-primary save_btn"> 
						<input type="button" value="Cancel" class="btn btn-primary save_btn" onclick="window.history.back();"> 		
						<br>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo $this->config->item('admin_js_path');?>jquery.validate.min.js"></script>
<script>
	  (function($,W,D){
		var user_validation = {}; 
		user_validation.UTIL =
		{
			setupFormValidation: function()
			{
				//form validation rules
				$("#change_password").validate({
					rules: {                   
						current_password: {
							required: true,							
						},
						new_password: {
							required: true,
							minlength: 7,
						},
						confirm_password: {
							required: true,
							minlength: 7,
							equalTo: "#new_password",
						},
					},
					messages: {},
					submitHandler: function(form) {
						form.submit();
					}
				});
			}
		}
		//when the dom has loaded setup form validation rules
		$(D).ready(function($) {
			user_validation.UTIL.setupFormValidation();
		}); 
	})(jQuery, window, document);
</script>