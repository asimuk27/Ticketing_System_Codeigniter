	<div class="kode-slider">
		<ul class="bxslider-banner">
			<?php if(empty($get_banner_images)){ ?>
			
			<li>
				<img src="<?php echo $this->config->item('frontend_image_path');?>extra-images/image_01_2.jpg" alt="" />
				<div class="kode-content">
					<div class="container">
						<div class="row">
							<div class="kode-slider-content">
								<h2>Half Marathon NZ. 2016</h2>
								<div class="overflow">
									<h3>November  25 - 26</h3>
									<h3 class="right-float">Joine The Event</h3>
								</div>								
							</div>
						</div>
					</div>
				</div>
			</li>
			<li>
				<img src="<?php echo $this->config->item('frontend_image_path');?>extra-images/image_02_2.jpg" alt="" />
				<div class="kode-content">
					<div class="container">
						<div class="row">
							<div class="kode-slider-content">
								<h2>Epic Swim Auckland 2016</h2>
								<div class="overflow">
									<h3>November  20 - 23</h3>
									<h3 class="right-float">Joine The Event</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
			<?php }else{ ?>
				 <?php foreach($get_banner_images as $images){?>
				   <li>
					<img src="<?php echo base_url(); ?>assets/image_uploads/banner_images/<?php echo $images['image_name']; ?>" alt="" />					
				   </li>
			<?php } ?>
			<?php } ?>
		</ul>		
	</div>
	<div class="content">		
		<div class="kode-overview-holder">
			<div class="container">
				<div class="row">
					<form method="post" action="<?php echo $this->config->item('base_url');?>event-listing">
						<div class="col-md-3 col-sm-3">
							<select class="search_select" id="category_name" name="category_name">
								<option value="">Select Category</option>
								<option value="1">Sports</option>
								<option value="2">Music</option>
								<option value="3">Entertainment</option>
								<option value="4">Games</option>
							</select>
						</div>
						<div class="col-md-3 col-sm-3"><input class="form-control" name="event_name" id="event_name" type="text" placeholder="Event Name"></div>
						<div class="col-md-2 col-sm-2"><input name="event_location" id="event_location" type="text" placeholder="Location" class="form-control"></div>
						<div class="col-md-2 col-sm-2">
							<select class="search_select" name="date_selection" id="date_selection">
								<option value="">-- Please Select --</option>
								<option value="1">Today</option>
								<option value="2">Tomorrow</option>
								<option value="4">This Week</option>
								<option value="5">This Weekend</option>
								<option value="7">Next Week</option>
								<option value="30">After This Month</option>
							</select>
						</div>	
						<div class="col-md-2 col-sm-2">
							<button type="submit" value="Search" class="submit_btn special_sub">Search</button>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-md-4 special_cols">
						<span class="popular_span">Popular Events:</span>
					</div>
				</div>
				<!--FIRST ROW START-->
				<div class="row">
					<!--COL-MD-4 START-->
					
						<?php if(isset($data) && (!empty($data))){ ?>
					<?php foreach($data as $result){ 
						if($result['status'] == "4"){
							$header_status = "Closed";								
						}else if($result['status'] == "5"){
							$header_status = "Cancelled";						
						}else if($result['status'] == "3"){
							$header_status = "Suspended";		
						}else{
							$header_status = "Book";							
						}
					?><div class="col-md-4">
						<!--KODE_EVENT_BLOG2 START-->
						<div class="kode-event-blog3">
							<figure>
								<img src="<?php echo $this->config->item('event_image');?><?php echo $result['original_event_image'];?>" alt="" class="event_image_height"/>
								<div class="kode-fig-capstion">
									<a href="<?php echo $this->config->item('base_url').'view-event/'.$result['id']; ?>"><span class="big_font"><?php echo $header_status;?></span></a>
								</div>
							</figure>
							<div class="kode-thumb-caption">
								<h4><?php echo strtoupper(substr($result['title'],0,25));?></h4>
								<ul>
									<li>
										<a href="#"><span class="fa fa-calendar"></span>
											<?php 							
												echo date("M j / Y", strtotime($result['event_start_date']));
											?>
										</a>
									</li>
									<li><a href="#"><span class="fa fa-location-arrow"></span><?php echo substr($result['event_location'],0,25);?></a></li>
								</ul>
								
							</div>
						</div>
						<!--KODE_EVENT_BLOG2 START-->
				</div>
					<?php 
						} }
					?>	
			</div>
		</div>			
		
	</div>
	</div>