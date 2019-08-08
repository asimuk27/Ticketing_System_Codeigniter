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
	.input-disabled{background-color:#EBEBE4;border:1px solid #ABADB3;}
</style>
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="right_first_box">
					<img src="<?php echo $this->config->item('admin_image_path');?>home.png">
						<a href="#">Home</a> > <a href="#">My Profile</a>
				</div>
			</div>
		</div>  				 
		<div class="row margin_top margin_bottom">
			<div class="col-md-12">
				<div class="blue_top">My Profile</div>
				<div class="table-responsive table_white_box" style="padding:25px;">
					<form method="post" action="<?php echo $this->config->item('admin_save_profile');?>" id="my_profile" name="my_profile">
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
							<div class="col-md-3"><label class="control_lable">Name</label></div>
							<div class="col-md-9"><input value="<?php echo $listing_data['name'];?>" type="text" placeholder="Name" class="inp" id="name" name="name"></div>
						</div>
						<div class="row">
							<div class="col-md-3"><label class="control_lable">User Name</label></div>
							<div class="col-md-9"><input value="<?php echo $listing_data['username'];?>" type="text" placeholder="User Name" class="inp input-disabled" readonly></div>
						</div>	
						<div class="row">
							<div class="col-md-3"><label class="control_lable">Email</label></div>
							<div class="col-md-9"><input value="<?php echo  $listing_data['email'];?>" type="email" placeholder="Email" class="inp input-disabled" readonly></div>
						</div>						
						<br>
						<input type="submit" value="Update Profile" class="btn btn-primary save_btn"> 
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
            $("#my_profile").validate({
                rules: {                   
                    name: {
                        required: true,
                    }					
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