<div class="content">
	<!-- Kode-Header End -->
		<div class="sub-header"></div>
		<div class="Kode-page-heading">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2>Welcome to TicketingSystem</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="kode-blog-style-2" style="min-height:500px;">
			<div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
						<?php if($this->session->flashdata('message')!=''): ?>
							<div class="row">
								<div class="col-md-offset-2 col-md-8 col-sm-12 respose_style"><?php echo $this->session->flashdata('message'); ?></div>
								</div>
   							    <div class="clear"></div>
						<?php endif; ?>

                        <div class="row">
							<div class="col-md-offset-2 col-md-8 col-sm-12">
								<h5 class="logn_message">Already a Member ? Log In</h5>
							</div>
							<form id="user_login" name="user_login" action="<?php echo $this->config->item('base_url');?>index.php/frontend/login/check_login" method="post">
								<div class="col-md-offset-2 col-md-8 col-sm-12">
									<a href="#" onclick="logInWithFacebook();">
										<img src="<?php echo $this->config->item('frontend_image_path');?>images/fb1.png" alt="fb_icon">
									</a>
								</div>
								<div class="clear"></div>
								<div class="col-md-offset-2 col-md-8 col-sm-12"><img alt="divider_image" src="<?php echo $this->config->item('base_url');?>images/divider.png" class="img-responsive" style="margin:15px 0px;"></div>
								<div class="clear"></div>
									<div class="col-md-offset-2 col-md-8 col-sm-12">
										<input type="email" id="email" name="email" class="required form-control" placeholder="Email" value="" required="required">
										<?php echo form_error('email'); ?>
									</div>
									<div class="clear"></div>
									<div class="col-md-offset-2 col-md-8 col-sm-12">
										<input type="password" id="password" name="password" class="required form-control" placeholder="Password" required="required">
										<?php echo form_error('password'); ?>
									</div>
									<div class="clear"></div>
									<div class="col-md-offset-2 col-md-8 col-sm-12">
										<input type="checkbox" value="" id="remember_me"><label class="chkbox_space" for="remember_me">Remember Me</label>
										<input type="hidden" id="fund_raise_status" name="fund_raise_status" value="1">
									</div>
									<div class="clear"></div>
									<div class="col-md-offset-2 col-md-8 col-sm-12">
										<button class="submit_btn paragraph submit_full_width" type="submit">Login</button>
									</div>
									<div class="clear"></div>
									<div class="col-md-offset-2 col-md-8 col-sm-12">
										<div class="search_events text-center"><a href="<?php echo $this->config->item('forgot_password');?>">Forgot Password ?</a></div>
									</div>
								</form>
                            </div>
                         </div>
						 <div class="col-md-6 col-sm-6">
							<div class="row">
								<div class="col-md-offset-2 col-md-8 col-sm-12">
									<h5 class="logn_message">Not A Member ? No Problem. Register Now</h5>
								</div>
								<div class="col-md-offset-2 col-md-8 col-sm-12">
										<button class="submit_btn paragraph submit_full_width" type="button" id="register_now">Start Fundraising</button>
									</div>
							</div>
						</div>
                	</div><!--outer row-->

			</div>
		</div>
	</div>
	<form name="myForm" id="myForm" action="<?php echo base_url(); ?>frontend/login/login_ajax" method="post">
	   <input type="hidden" name="first_name" id="first_name">
	   <input type="hidden" name="last_name" id="last_name">
	   <input type="hidden" name="id" id="id">
	   <input type="hidden" name="email_idz" id="email_idz">
	   <input type="hidden" name="fund_raise_fb_status" id="fund_raise_fb_status" value="1">
	</form>

<!-- new html -->

<script>


	$(document).ready(function(){
		$('#register_now').click(function(){
			location.href = "<?php echo base_url(); ?>frontend/login/user_register";
		});

		$(".respose_style").fadeOut(3000);
	});
 </script>
 <script>
  function logInWithFacebook() {

  FB.login(function(response) {
      if (response.authResponse) {
      console.log(response.authResponse);

       FB.api('/me?fields=id,first_name,last_name,email,permissions', function(response)
       {
        if(response.id!='' && response.email!=''){

        	document.getElementById("id").value = response.id;
        	document.getElementById("first_name").value = response.first_name;
        	document.getElementById("last_name").value = response.last_name;
        	document.getElementById("email_idz").value = response.email;
        	document.forms["myForm"].submit();
        }
       });
      } else {
      }
    },{scope: 'email',return_scopes: true});
    return false;
  };
  window.fbAsyncInit = function() {
    FB.init({
      appId: '1058287097627083',
      cookie: true, // This is important, it's not enabled by default
      version: 'v2.2'
    });
  };

  (function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
