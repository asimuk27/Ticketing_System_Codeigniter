<style>
	.submit_btn{width:100%;}
	.container input{margin-bottom:10px;}
	.submit_btn{margin-bottom:10px;}
	
	input[type="password"] {
		border: 1px solid rgb(185, 193, 204);
		color: #666;
		height: 43px;
		margin-bottom: 15px;
		padding: 8px 10px;
		width: 100%;
	}
	input[type="email"] {
		border: 1px solid rgb(185, 193, 204);
		color: #666;
		height: 43px;
		margin-bottom: 15px;
		padding: 8px 10px;
		width: 100%;
	}
	.error{color:red !important;}
	#user_login p{color:red !important;}
	
	 .respose_style{
  padding:10px;
  color: #fff;
  background-color: #5cb85c; 
  border-color: #4cae4c; 
  font-weight:bold;
}
</style>
<div class="content">
	<!-- Kode-Header End -->
		<div class="sub-header"></div>
		<div class="Kode-page-heading">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2>User Login</h2>
					</div>					
				</div>
			</div>
		</div>
		<div class="kode-blog-style-2" style="min-height:500px;">
			<div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 border_right_login">  
						<?php if($this->session->flashdata('message')!=''): ?>
							<div class="row">
								<div class="col-md-offset-2 col-md-8 col-sm-12 respose_style"><?php echo $this->session->flashdata('message'); ?></div>
								</div>
   							    <br class="clear">
						<?php endif; ?>
 
                        <div class="row">
							<form id="user_login" name="user_login" role="form" action="<?php echo $this->config->item('base_url');?>index.php/frontend/login/check_login" method="post">
								<div class="col-md-offset-2 col-md-8 col-sm-12">
									<a href="<?php echo base_url(); ?>index.php/frontend/auth/login_home">
										<img src="<?php echo $this->config->item('frontend_image_path');?>images/fb1.png">
									</a>
								</div>
								<br class="clear">
								<div class="col-md-offset-2 col-md-8 col-sm-12" style="font-weight:bold; font-size:15px; text-decoration:none; color:#000000;text-align:center;margin-bottom:10px;">OR</div>
								<br class="clear">
									<div class="col-md-offset-2 col-md-8 col-sm-12">    
										<input type="email" id="email" name="email" class="required form-control" placeholder="Email" value="" required="required">
										<?php echo form_error('email'); ?>
									</div>
									 <br class="clear">
									<div class="col-md-offset-2 col-md-8 col-sm-12">  
										<input type="password" id="password" name="password" class="required form-control" placeholder="Password" required="required">
										<?php echo form_error('password'); ?>
									</div>                       
									<br class="clear">
									<div class="col-md-offset-2 col-md-8 col-sm-12">
										<input type="checkbox" value="" id="remember_me"><label class="chkbox_space" for="remember_me">Remember Me</label>
									</div>
									<br class="clear">
									<div class="col-md-offset-2 col-md-8 col-sm-12">
										<button class="submit_btn paragraph" type="submit">Login</button>
									</div>
									<br class="clear">
									<div class="col-md-offset-2 col-md-8 col-sm-12">
										<div class="search_events text-center"><a href="<?php echo $this->config->item('forgot_password');?>">Forgot Password ?</a></div>
									</div>
								</form>
                            </div>

                         </div>

                         <div class="col-md-6 col-sm-6">

                         	<br class="clear">

                            <div class="col-md-offset-2 col-md-8 col-sm-12">
                                <a href="<?php echo $this->config->item('base_url')?>index.php/frontend/login/user_sign_up"><button class="submit_btn paragraph">Register as an Individual</button></a>
                            </div>
                            <br class="clear">

                            <br class="clear">

                            <div class="col-md-offset-2 col-md-8 col-sm-12">

                                <a href="<?php echo $this->config->item('base_url')?>index.php/frontend/login/organiser_sign_up"><button class="submit_btn paragraph">Register as an Organisation</button></a>

                            </div>

                         </div>

                	</div><!--outer row-->

			</div>

		</div>

	</div>
	
	
<!--- new html --->

<script>
	$(document).ready(function(){
		$(".respose_style").fadeOut(3000);
	});
 </script>