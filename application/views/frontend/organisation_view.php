<style>
	.extra_padding {
		padding: 6px 50px;
	}
</style>
<div class="content">
		<!-- Kode-Header End -->
		<div class="sub-header">
			<!-- SUB HEADER -->
		</div>
<div class="Kode-page-heading">
	<div class="container">
		<!--ROW START-->
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<h2>Organizer Profile</h2>
			</div>			
		</div>
		<!--ROW END-->
	</div>
</div>   
<div class="kf_content">
	<div class="container">
		<div class="row">
		
			<div class="col-md-12 col-sm-12 col-xs-12">
				<!--Who Am I Wrap Start-->
				<div class="kf_who_am center-block view_block_user">
					<div class="row">
						<div class="col-md-3 col-sm-4">
						<figure class="">
							<img src="<?php echo $this->config->item('organisation_logo');?><?php echo $data['logo'];?>" alt="Image Here">
						</figure>
						</div>
						<?php 
							//echo "<pre>";
							//print_r($data);
						?>
						<div class="col-md-8 col-sm-8">
							<div class="text-center center-block">								
								<h4><?php echo $data['first_name'];?> <?php echo $data['last_name'];?></h4>
								<span><?php echo $data['organization_name'];?></span>
								<p><?php echo $data['charity_overview'];?></p>
								<ul class="user_view_ul">
									<li>
										<strong>Charity Name</strong>
										<span><?php echo $data['charity_name'];?></span>
									</li>
									<li>
										<strong>Address</strong>
										<span><?php echo $data['street_address'];?>,<?php echo $data['city'];?>,<?php echo $data['region'];?></span>
									</li>
									<li>
										<strong>Phone</strong>
										<span><?php echo $data['phone'];?></span>
									</li>
									<li>
										<strong>Email</strong>
										<span><?php echo $data['email'];?></span>
									</li>									
								</ul>	
								<br class="clear">
							</div>
							<br class="clear">
							<div class="text-center center-block">
								<input type="button" value="Edit" class="submit_btn" onclick="edit_page();" style="margin-right:15px;">
								<input type="button" value="Change Password" class="submit_btn" onclick="change_page();" id="change">
							</div>
						</div>
					</div><!--row-->
				</div>
			</div>  
		</div>    
	</div>        
</div>
<script>
	function edit_page(id){
		window.location.href = '<?php echo $this->config->item('edit_fe_profile');?>';
	}
	
	function change_page(id){
		window.location.href = '<?php echo $this->config->item('base_url')?>frontend/organiser/change_organizer_password';
	}
</script>