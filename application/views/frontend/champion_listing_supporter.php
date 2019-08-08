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
						<h2>Champion Listing</h2>
					</div>					
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->	
		<!--KODE-EVENT-SHEDULE START-->
		<div class="kode-blog-style-2 special_text">
			<div class="container">
				You’re just one step away from making a huge difference!<br>
				<span class="big_font">Choose the champion of your cause and donate, make a positive difference TODAY!</span>
				</div>
			 <hr class="donation_form">
			</div>
			
		</div>
		<div class="kode-blog-style-2">
			<div class="container">
				<div class="row">
					<form action="<?php echo $this->config->item('fe_champion_search'); ?>" method="post">
						<div class="col-sm-1 col-sm-1">
							<label for="champion_name" class="space_right" style="padding:10px 0px;">Search</label>
						</div>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" placeholder="Champion Name" name="champion_name" id="champion_name" value="<?php if(isset($_POST['champion_name'])){echo $_POST['champion_name'];} ?>">
						</div>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" placeholder="Organisation Name" name="organization_name" id="organization_name" value="<?php if(isset($_POST['organization_name'])){echo $_POST['organization_name'];} ?>">
						</div>					
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" placeholder="Event Name" name="event_name" id="event_name" value="<?php if(isset($_POST['event_name'])){echo $_POST['event_name'];} ?>">
						</div>					
						<div class="col-md-2 col-sm-2">				
							<button value="Search" class="submit_btn" style="padding:9px 29px;">Search</button>	
						</div>
					</form>
				</div>
				<!--FIRST ROW START-->				
				<div class="row" style="min-height:400px;">
					<!--COL-MD-4 START-->
					<?php if(!empty($champions_data)){ ?>
					<?php foreach($champions_data as $champions){
						if($champions['fundraising_image']){ 
							if(filter_var($champions['fundraising_image'], FILTER_VALIDATE_URL)){
								$profile_image = $champions['fundraising_image'];
							}else{
								$profile_image = $this->config->item('frontend_profileimage_path').'/'.$champions['fundraising_image'];
							}
						}else{
							$profile_image = $this->config->item('default_image_url').'/fundraising_profile.jpg';
						}
						
					//	$profile_image = $this->config->item('frontend_profileimage_path').'/'.$champions['fundraising_image'];
					?>
					<div class="col-md-4 cols-sm-4">
						<!--KODE_EVENT_BLOG2 START-->
						<div class="kode-event-blog3">
							<figure style="width:200px;">
								<img style="width:200px;height:200px;" src="<?php echo $profile_image;?>" alt=""/>
								<div class="kode-fig-capstion">
									<a href="<?php echo $this->config->item('base_url')."view-champion/".$champions['id']; ?>"><span class="big_font">Support</span></a>									
								</div>
							</figure>
							<div class="kode-thumb-caption">
								<h4><?php echo $champions['display_name'];?></h4>
                                <div class="blue_txt champ_list search_events">Has raised $<?php if($champions['raised_amount'] == ""){echo "0";}else{ echo round($champions['raised_amount']);};?> of <?php echo $champions['target_amount'];?></div>
                                <h5 class="champ_list_event search_events">For <?php echo $champions['charity_name'];?> - <?php echo substr($champions['title'],0,12);?></h5>
								
							</div>
						</div>
						<!--KODE_EVENT_BLOG2 START-->
					</div>
					<?php } }else{ ?>
						No result found matching your search criteria
					<?php } ?>
				</div>				
			</div>
		</div>
		