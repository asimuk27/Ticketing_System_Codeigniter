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
					<h2>Forgot Password</h2>
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
					<div class="row">
						<form action="<?php echo trim($this->config->item('forgot_password_send'));?>" method="post" name="forgot_password_form" id="forgot_password_form">
						<div class="col-md-2 col-sm-2">
							<label for="email" class="align_to_txt_box">Email</label>
						</div>
						<div class="col-md-6 col-sm-6">
							<input type="text" id="email" name="email" class="search_events form-control" placeholder="Email" required>
						<?php if($this->session->flashdata('message') != ''){ ?>
							<?php echo $this->session->flashdata('message');?>						
						<?php } ?>
						</div>						
						<div class="col-md-3 col-sm-3 col-xs-12">
							<a href="#"><button class="three_inline_buttons" type="submit">Submit</button></a>							
						</div>
						</form>
					</div>
				</div>
			</div>
			<!--outer row-->
		</div>
	</div>
</div>