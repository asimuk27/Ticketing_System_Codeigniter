<!--script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('add_admin_user').action = jQuery(this).attr('href');
			jQuery('#add_admin_user').submit();   
			e.preventDefault();
		});
	});
</script-->
<style>
	label{font-weight:normal;}
	.input-disabled{background-color:#EBEBE4;border:1px solid #ABADB3;}
	span{color:red;}
	.error{color:red;}
</style>
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="right_first_box">
					<img src="<?php echo $this->config->item('admin_image_path');?>home.png">
						<a href="#">Home</a> > <a href="#">Admin Users</a>
				</div>
			</div>
		</div>  				 
		<div class="row margin_top margin_bottom">
			<div class="col-md-12">
				<div class="blue_top">Admin Users</div>
				<div class="table-responsive table_white_box" style="padding:25px;">
					<form method="POST" action="<?php echo $this->config->item('insert_admin');?>" id="add_admin_user" name="add_admin_user">
					<div class="col-lg-7 col-md-11">
						<?php if($this->session->flashdata('message') != ''){ ?>
							<div class="row" style="margin-bottom:5px;">
								<div class="col-md-4"><label class="control_lable">&nbsp;</label></div>
								<div class="col-md-8" style="color:green;margin-top:10px;">
						<?php echo $this->session->set_flashdata('message');  ?>
								</div>
							</div>	
						<?php } ?>		
						<div class="row">
							<div class="col-md-4"><label class="control_lable">Name</label><span>*</span></div>
							<div class="col-md-8"><input value="<?php echo set_value('name');?>" type="text" placeholder="Name" class="inp form-control" id="name" name="name"><?php echo form_error('name'); ?></div>
						</div>						
						<div class="row">
							<div class="col-md-4"><label class="control_lable">Email</label><span>*</span></div>
							<div class="col-md-8"><input value="<?php echo set_value('email');?>" type="email" placeholder="Email" class="inp form-control" id="email" name="email"><?php echo form_error('email'); ?></div>
						</div>
						<div class="row">
							<div class="col-md-4"><label class="control_lable">Password</label><span>*</span></div>
							<div class="col-md-8"><input value="<?php echo set_value('password');?>" type="password" placeholder="Password" class="inp form-control" id="password" name="password"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><label class="control_lable">Confirm Password</label><span>*</span></div>
							<div class="col-md-8"><input value="<?php echo set_value('confirmpassword');?>" type="password" placeholder="Confirm Password" class="inp form-control" id="confirmpassword" name="confirmpassword"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><label class="control_lable">Role</label><span>*</span></div>
							<div class="col-md-8">
								<div class="row">									
									<?php foreach($get_roles as $role){ ?>		
										<div class="col-md-8 col-sm-8">
											<input id="<?php echo $role['id']; ?>" value="<?php echo $role['id']; ?>" name="role_areas[]" type="checkbox">
											<label class="chkbox_space" for="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></label>
										</div> 
									<?php }	?>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-4">&nbsp;</div>
							<div class="col-md-8">
								<input type="submit" value="Submit" class="btn btn-primary save_btn"> 
								<input type="button" value="Cancel" class="btn btn-primary save_btn" onclick="window.history.back();"> 	
							</div>
						</div>
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
            $("#add_admin_user").validate({
                rules: {     
                    name: {
                        required: true,
                    },
					username: {
                        required: true,
                    },
					email: {
						required: true,
					},
					password: {
						required:true,						minlength:7,
					},
					confirmpassword: {
						required: true,						minlength:7,
						equalTo: "#password",
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


