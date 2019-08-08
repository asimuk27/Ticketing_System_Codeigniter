<style>
span{
	color:red;
	font-weight: bold;
}
.error{
	color:red;
	font-weight: normal;
}
input[type="password"] {
    border: 1px solid rgb(185, 193, 204);
    color: #666;
    height: 43px;
    margin-bottom: 15px;
    padding: 8px 10px;
    width: 100%;
}
</style>	
<div class="content">
	<!-- Kode-Header End -->
	<div class="sub-header">
		<!-- SUB HEADER -->
	</div>
	<!-- Kode-Slider End -->
	<!--Kode-our-speaker-heading start-->
	<div class="Kode-page-heading">
		<div class="container">
			<!--ROW START-->
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>Reset Password</h2>
				</div>
			</div>
			<!--ROW END-->
		</div>
	</div>
	<!--Kode-our-speaker-heading End-->
	<div class="kode-blog-style-2"  style="min-height:300px;">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<?php 
					$id = 1;//$_POST['id']; 
					if($this->session->flashdata('message') != ''){ ?>
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<label  class="align_to_txt_box">&nbsp;</label>
						</div>
						<div class="col-md-6 col-sm-6" style="color:red;">
							<?php echo $this->session->flashdata('message');?>
						</div>						
					</div>
				<?php } ?>
					<div class="row">
						<form action="<?php echo base_url(); ?>index.php/frontend/password/set_profile_password" method="post" name="new_password_form" id="new_password_form">
						
						<div class="col-md-4 col-sm-4">
							<label for="password" class="align_to_txt_box">Password<span>*</span></label>
						</div>
						<div class="col-md-6 col-sm-6">
							<input type="password" id="password" name="password" class="search_events form-control" placeholder="Password" value="" >
						<?php echo form_error('password'); ?>
						</div>
						<div class="clear"></div>
						
						<div class="col-md-4 col-sm-4">
							<label for="email2" class="align_to_txt_box">Confirm Password<span>*</span></label>
						</div>
						<div class="col-md-6 col-sm-6">
							<input type="password" id="confirm_password" name="confirm_password" class="search_events form-control" placeholder="Confirm Password" value="" >
						<?php echo form_error('confirm_password'); ?>
						</div>						
						<div class="clear"></div>					
						
						<div class="col-md-4 col-sm-4"></div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="hidden" name="token" id="token" value="<?php echo $token?>"> 
							<a href="#"><button class="three_inline_buttons" type="submit">Submit</button></a>							
						</div>
						
						</form>
						</div>
					</div>
				</div>
			</div>
			<!--outer row-->
		</div>
	</div>
</div>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>	
<script>

 (function($,W,D){
    var user_validation = {}; 
    user_validation.UTIL =
    {
      setupFormValidation: function(){
            //form validation rules
            $("#new_password_form").validate({
              rules: {
               password: {
                required: true,
				minlength:7,
              },
              confirm_password: {
                required: true,
				minlength:7,
				equalTo: "#password",
              },	
            },
            messages: {
            confirm_password: {                   
              equalTo: jQuery.validator.format("confirm password should be same as password")
           },
      
          },
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