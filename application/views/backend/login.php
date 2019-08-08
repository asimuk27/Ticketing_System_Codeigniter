<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo $this->config->item('admin_css_path');?>bootstrap.min.css">
    <link href="<?php echo $this->config->item('admin_css_path');?>style.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
	<style>
		.error{color:red;}
	</style>
</head>
<body class="login_body">
    <div class="container">
		<div class="row login_box">
			<div class="col-md-12">
				<div class="header_part text-center">Login</div>
			</div>
			 <div class="col-md-10 col-md-offset-1">
			 <form class="form-horizontal" role="form" name="login" id="login" method="post" action="<?php echo $this->config->item('login_check_url');?>">
			  <div class="form-group">
				<label class="control-label col-sm-3" for="email">Email:<span class="red_star">*</span></label>
				<div class="col-sm-9">
				  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
				  <?php echo form_error('email'); ?>
				</div>
			  </div>
			  <div class="form-group">
				<label class="control-label col-sm-3" for="pwd">Password:<span class="red_star">*</span></label>
				<div class="col-sm-9"> 
				  <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password">
				  <?php echo form_error('pwd'); ?>
				</div>
			  </div>
			  <div class="form-group"> 
				<div class="col-sm-offset-3 col-sm-10">
					<input type="submit" class="btn btn-primary btn_space" value="Login">
					<input type="reset" class="btn btn-primary btn_space" value="Clear">					
				</div>
			  </div>
			</form>
			 </div>
		   <!--<div class="col-md-12 text-center for_password"><a href="#">Forgot your password ?</a></div>-->
		</div>
     </div>
    <!-- jQuery -->
	<script src="<?php echo $this->config->item('admin_js_path');?>jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="<?php echo $this->config->item('admin_js_path');?>bootstrap.min.js"></script>   
	<script src="<?php echo $this->config->item('admin_js_path');?>jquery.validate.min.js"></script>
	<script>
	(function($,W,D){
    var user_validation = {}; 
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#login").validate({
                rules: {                   
                    pwd: {
                        required: true,
                    },
					email: {
                        required: true,
                        email: true,
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
<style>
	.form-group p{color:red !important;}
</style>
</body>
</html>
